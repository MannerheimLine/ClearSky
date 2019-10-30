/*
 *
 *
 *
 *
 *
 */

let typingTimer;

const module_wrapper = $('.module-wrapper');
const patient_card_menu = $('.patient-card-menu');
const patient_card_body = $('#patient-card-body');
const personal_data_section = $('#personal-data-section');
const document_section = $('#document-section');
const addresses_section = $('#addresses-section');
const additionally_section = $('#additionally-section');

const card_search_input =  $("input[name='card-search']");

/*const id_input = $("input[name='id']");
const card_number_input = $("input[name='card-number']");
const is_alive_id_input = $("input[name='is-alive-id']");
const is_alive_input = $("#patient-alive-status");
const is_attached_id_input = $("input[name='is-attach-id']");
const is_attached_input = $("#patient-attach-status");
const full_name_input = $("input[name='full-name']");
const gender_input = $("select[name='gender']");
const date_birth_input = $("input[name='date-birth']");
const telephone_input = $("input[name='telephone']");
const email_input = $("input[name='email']");
const insurance_certificate_input = $("input[name='insurance-certificate']");
const policy_number_input = $("input[name='policy-number']");
const insurance_company_id_input = $("input[name='insurance-company-id']");
const insurance_company_input = $("input[name='insurance-company']");
const passport_serial_input = $("input[name='passport-serial']");
const passport_number_input = $("input[name='passport-number']");
const fms_department_id_input = $("input[name='fms-department-id']");
const fms_department_input = $("textarea[name='fms-department']");
const region_id_input = $("input[name='region-id']");
const region_input = $("input[name='region']");
const district_id_input = $("input[name='district-id']");
const district_input = $("input[name='district']");
const locality_id_input = $("input[name='locality-id']");
const locality_input = $("input[name='locality']");
const street_id_input = $("input[name='street-id']");
const street_input = $("input[name='street']");
const house_number_input = $("input[name='house-number']");
const apartment_input = $("input[name='apartment']");
const workplace_input = $("input[name='workplace']");
const profession_input = $("input[name='profession']");
const notation_input = $("textarea[name='notation']");*/

/*const patient_card_alive_section = $('#patient-card-alive-section');
const patient_card_attached_section = $('#patient-card-attached-section');
const is_alive_image = $("#patient-alive-image");
const is_attached_image = $("#patient-attached-image");*/

$(function () {
    loadPatientCardData(1);
    loadMasksForDynamicInputs();
    loadMasksForStaticInputs();
});

$("#patient-card-body :input").not('#region').not('#district').change(function() {
    updatePatientCardData();
});

$('#patient-card-alive-section').click(function () {
    flipPatientCardStatus('is-alive-id');
    let updatedCardId = updatePatientCardData();
    /**
     * Идея в том чтобы заморозить запрос на получение данных у БД хотя бы на немного.
     * Тем самы запрос на обновление записей всегда пройдет первым, а запрос на получение всегда будет вторым
     * соответсвенн овозвращая всегда актуальные данные.
     * -------------------------------------------------------------------------------------------------------
     * Решит ьпроблему нужно в любом случае через promise или callback, так как вставка данных может длиться и больше
     * 50 мс, а значит в этом случае, функция по запросу будет отправленна первой!.
     */

    let freezeToSql = function (){
        loadPatientCardData(updatedCardId);
    };
    setTimeout(freezeToSql, 50);
});

$('#patient-card-attached-section').click(function () {
    flipPatientCardStatus('is-attach-id');
    let updatedCardId = updatePatientCardData();
    let freezeToSql = function (){
        loadPatientCardData(updatedCardId);
    };
    setTimeout(freezeToSql, 50);
});

card_search_input.keyup(function (e) {
    let searchString = card_search_input.val();
    if (e.which === 13){
        let recordBadge = $('#patient-card-found-records');
        if (searchString.length > 0){
            patient_card_body.empty();
            patient_card_body.append(loadPatientCardSearchTemplate());
            let request = $.ajax({
                type: "POST",
                url: "/patient-card/search-cards",
                data: {'searchString' : searchString},
                cache: false
            });
            request.done(function (response) {
                let tableContent = $('#cards-data-table-content');
                let recordCount = response.length || 0;
                tableContent.empty();
                $.each(response, function (key, value) {
                    let line = loadCardsDataTableContentLine(value);
                    recordBadge.text(recordCount);
                    tableContent.append(line);
                    console.log(response);
                });
            });
        }else {
            alert('Введите данные для поиска');
            return false;
        }
    }
    if (searchString.length === 0 && e.which === 8){
        patient_card_body.empty();
        /**
         * Легкая задержка чтобы не делать кучу запросов к БД, когда отпускаешь ЗАЖАТУЮ клавишу
         */
        setTimeout(function () {
            loadPatientCard(1)
        }, 100);
        loadMasksForDynamicInputs();
    }
});

const flipPatientCardStatus = function (name) {
    let input = $(`input[name=${name}]`);
    if (input.val() == 1){
       input.val(2);
    }else {
        input.val(1);
    }
};

const updatePatientCardData = function () {
    let id_value = $("input[name='id']").val();
    let card_number_value = $("input[name='card-number']").val();
    let is_alive_id_value = $("input[name='is-alive-id']").val();
    let is_attach_id_value = $("input[name='is-attach-id']").val();
    let full_name_value = $("input[name='full-name']").val();
    let gender_value = $("select[name='gender']").val();
    let date_birth_value = $("input[name='date-birth']").val();
    let telephone_value = $("input[name='telephone']").val();
    let email_value = $("input[name='email']").val();
    let insurance_certificate_value = $("input[name='insurance-certificate']").val();
    let policy_number_value = $("input[name='policy-number']").val();
    let insurance_company_value = $("input[name='insurance-company-id']").val();
    let passport_serial_value = $("input[name='passport-serial']").val();
    let passport_number_value = $("input[name='passport-number']").val();
    let fms_department_value = $("input[name='fms-department-id']").val();
    let region_value = $("input[name='region-id']").val();
    let district_value = $("input[name='district-id']").val();
    let locality_value = $("input[name='locality-id']").val();
    let street_value = $("input[name='street-id']").val();
    let house_number_value = $("input[name='house-number']").val();
    let apartment_value = $("input[name='apartment']").val();
    let workplace_value = $("input[name='workplace']").val();
    let profession_value = $("input[name='profession']").val();
    let notation_value = $("textarea[name='notation']").val();
    let request = $.ajax({
        type: "POST",
        url: "/patient-card/update",
        data: {
            'id' : id_value,
            'cardNumber' : card_number_value,
            'isAlive' : is_alive_id_value,
            'isAttach' : is_attach_id_value,
            'fullName' : full_name_value,
            'gender' : gender_value,
            'dateBirth' : date_birth_value,
            'telephone' : telephone_value,
            'email' : email_value,
            'insuranceCertificate' : insurance_certificate_value,
            'policyNumber' : policy_number_value,
            'insuranceCompany' : insurance_company_value,
            'passportSerial' : passport_serial_value,
            'passportNumber' : passport_number_value,
            'fmsDepartment' : fms_department_value,
            'region' : region_value,
            'district' : district_value,
            'locality' : locality_value,
            'street' : street_value,
            'houseNumber' : house_number_value,
            'apartment' : apartment_value,
            'workplace' : workplace_value,
            'profession' : profession_value,
            'notation' : notation_value
        },
        cache: false
    });
    request.done(function () {
        console.log('Patient card '+ card_number_value + ' updated');
        console.log('Id '+ id_value + ' updated');
    });
    return id_value;
};

const addPatientCardData = function () {
    let card_number_value = $("input[name='add-card-number']").val();
    let full_name_value = $("input[name='add-full-name']").val();
    let gender_value = $("select[name='add-gender']").val();
    let date_birth_value = $("input[name='add-date-birth']").val();
    let insurance_certificate_value = $("input[name='add-insurance-certificate']").val();
    let policy_number_value = $("input[name='add-policy-number']").val();
    let insurance_company_value = $("input[name='add-insurance-company-id']").val();
    let request = $.ajax({
        type: "POST",
        url: "/patient-card/add",
        data: {
            'cardNumber' : card_number_value,
            'fullName' : full_name_value,
            'gender' : gender_value,
            'dateBirth' : date_birth_value,
            'insurance' : insurance_certificate_value,
            'policyNumber' : policy_number_value,
            'insuranceCompany' : insurance_company_value
        },
        cache: false
    });
    request.done(function (response) {
        $("#addPatientCardModal").modal('hide');
        patient_card_body.empty();
        loadPatientCard(response);
    });
};

const loadPatientCardData = function (id) {
    let id_input = $("input[name='id']");
    let card_number_input = $("input[name='card-number']");
    let is_alive_id_input = $("input[name='is-alive-id']");
    let is_alive_input = $("#patient-alive-status");
    let is_attached_id_input = $("input[name='is-attach-id']");
    let is_attached_input = $("#patient-attach-status");
    let full_name_input = $("input[name='full-name']");
    let gender_input = $("select[name='gender']");
    let date_birth_input = $("input[name='date-birth']");
    let telephone_input = $("input[name='telephone']");
    let email_input = $("input[name='email']");
    let insurance_certificate_input = $("input[name='insurance-certificate']");
    let policy_number_input = $("input[name='policy-number']");
    let insurance_company_id_input = $("input[name='insurance-company-id']");
    let insurance_company_input = $("input[name='insurance-company']");
    let passport_serial_input = $("input[name='passport-serial']");
    let passport_number_input = $("input[name='passport-number']");
    let fms_department_id_input = $("input[name='fms-department-id']");
    let fms_department_input = $("textarea[name='fms-department']");
    let region_id_input = $("input[name='region-id']");
    let region_input = $("input[name='region']");
    let district_id_input = $("input[name='district-id']");
    let district_input = $("input[name='district']");
    let locality_id_input = $("input[name='locality-id']");
    let locality_input = $("input[name='locality']");
    let street_id_input = $("input[name='street-id']");
    let street_input = $("input[name='street']");
    let house_number_input = $("input[name='house-number']");
    let apartment_input = $("input[name='apartment']");
    let workplace_input = $("input[name='workplace']");
    let profession_input = $("input[name='profession']");
    let notation_input = $("textarea[name='notation']");
    let request = $.ajax({
        type: "GET",
        url: "/patient-card/show/" + id,
        cache: false
    });
    request.done(function (response) {
        let card_data = response.card_data;
        id_input.val(card_data.id);
        card_number_input.val(card_data.cardNumber);
        is_alive_id_input.val(card_data.isAliveId);
        is_alive_input.text(card_data.isAlive);
        is_attached_id_input.val(card_data.isAttachId);
        is_attached_input.text(card_data.isAttached);
        full_name_input.val(card_data.surname + ' ' + card_data.firstName + ' ' + card_data.secondName);
        $.each(response.genders, function (key, value) {
            gender_input.append(`<option value="${value.id}" ${card_data.genderId == value.id ?' selected':''}>${value.description}</option>`)
        });
        date_birth_input.val(card_data.dateBirth);
        telephone_input.val(card_data.telephone);
        email_input.val(card_data.email);
        insurance_certificate_input.val(card_data.insuranceCertificate);
        policy_number_input.val(card_data.policyNumber);
        insurance_company_id_input.val(card_data.insuranceCompanyId);
        insurance_company_input.val(card_data.insuranceCompany);
        passport_serial_input.val(card_data.passportSerial);
        passport_number_input.val(card_data.passportNumber);
        fms_department_id_input.val(card_data.fmsDepartmentId);
        fms_department_input.val(card_data.fmsDepartment);
        region_id_input .val(card_data.regionId);
        region_input .val(card_data.region);
        district_id_input.val(card_data.districtId);
        district_input.val(card_data.district);
        locality_id_input.val(card_data.localityId);
        locality_input.val(card_data.locality);
        street_id_input.val(card_data.streetId);
        street_input.val(card_data.street);
        house_number_input.val(card_data.houseNumber);
        apartment_input.val(card_data.apartment);
        workplace_input.val(card_data.workPlace);
        profession_input.val(card_data.profession);
        notation_input.val(card_data.notation);

        /*
        * Значки fontawesome для статусов
        */
        let patient_card_alive_section = $('#patient-card-alive-section');
        let patient_card_attached_section = $('#patient-card-attached-section');
        let is_alive_image = $("#patient-alive-image");
        let is_attached_image = $("#patient-attached-image");
        /*
         * Статус по карте: жив/мертв, прикреплен/откреплен
         */
        $('#patient-alive-status').text(card_data.isAlive);
        $('#patient-attached-status').text(card_data.isAttached);

        switch (card_data.isAliveId) {
            //Если пациент жив.
            case 1 :
                patient_card_alive_section.css({'color' : '#28a745'});
                switch (card_data.humanType) {
                    case 1 : is_alive_image.attr('class', 'fa fa-male'); break;
                    case 2 : is_alive_image.attr('class', 'fa fa-female'); break;
                    case 3 : is_alive_image.attr('class', 'fa fa-child'); break;
                    default : is_alive_image.attr('class', 'fa fa-male');
                }
                break;
            case 2 :
                patient_card_alive_section.css({'color' : '#d80e1b'});
                is_alive_image.attr('class', 'fa fa-skull');
                break;
        }
        switch (card_data.isAttachId) {
            case 1 :
                patient_card_attached_section.css({'color' : '#28a745'});
                is_attached_image.attr('class', 'fa fa-user-plus');
                break;
            case 2 :
                patient_card_attached_section.css({'color' : '#d80e1b'});
                is_attached_image.attr('class', 'fa fa-user-times');
                break;

        }
    })
};

/**
 * Поиск карт
 */

const loadPatientCardSearchTemplate = function () {
    return `
        <div id="cards-data-search-section" class="row" style="padding: 10px;">
            <table id="cards-data-table" class="table-striped table-mine full-width box-shadow--2dp">
                 <thead>
                     <tr>
                         <th style="width: 20%;">ФИО</th>
                         <th style="width: 10%;">Номер карты</th>
                         <th style="width: 15%;">Полис</th>
                         <th style="width: 15%;">Снилс</th>
                         <th style="width: 10%;">Статус</th>
                         <th style="width: 10%;">Прикрепление</th>
                         <th style="width: 20%;">Действия</th>
                     </tr>
                 </thead>
                 <tbody id="cards-data-table-content"></tbody>
            </table>
        </div>`
};

const loadCardsDataTableContentLine = function(response){
    let live_status_image;
    let attached_status_image;
    switch (response.is_alive) {
        case 1 :
            live_status_image = 'fa fa-user';
            break;
        case 2 :
            live_status_image = 'fa fa-skull';
            break;
    }
    switch (response.is_attached) {
        case 1 :
            attached_status_image = 'fa fa-plus';
            break;
        case 2 :
            attached_status_image = 'fa fa-minus';
            break;
    }
    return $(`<tr class="tr-table-content">
                    <td>${response.surname} ${response.firstname} ${response.secondname}</td>
                    <td>${response.card_number}</td>
                    <td>${response.policy_number}</td>
                    <td>${response.insurance}</td>
                    <td><i class="${live_status_image}" style="font-size: 18px;"></i></td>
                    <td><i class="${attached_status_image}" style="font-size: 18px;"></i></td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" onclick="loadPatientCard(${response.id})">
                            <i class="fa fa-search"></i> Посмотреть
                        </button>
                    </td>
                </tr>`).hide().fadeIn(1000);
};

/**
 * Загрузка карты пациента
 */

const loadPatientCard = function (id) {
    patient_card_body.append(loadPatientCardTemplate());
    let recordBadge = $('#patient-card-found-records');
    loadPatientCardData(id);
    $("#patient-card-body :input").not('#region').not('#district').change(function() {updatePatientCardData()});
    $('#patient-card-alive-section').click(function () {
        flipPatientCardStatus('is-alive-id');
        let updatedCardId = updatePatientCardData();
        /**
         * Идея в том чтобы заморозить запрос на получение данных у БД хотя бы на немного.
         * Тем самы запрос на обновление записей всегда пройдет первым, а запрос на получение всегда будет вторым
         * соответсвенн овозвращая всегда актуальные данные.
         * -------------------------------------------------------------------------------------------------------
         * Решит ьпроблему нужно в любом случае через promise или callback, так как вставка данных может длиться и больше
         * 50 мс, а значит в этом случае, функция по запросу будет отправленна первой!.
         */

        let freezeToSql = function (){
            loadPatientCardData(updatedCardId);
        };
        setTimeout(freezeToSql, 50);
    });
    $('#patient-card-attached-section').click(function () {
        flipPatientCardStatus('is-attach-id');
        let updatedCardId = updatePatientCardData();
        let freezeToSql = function (){
            loadPatientCardData(updatedCardId);
        };
        setTimeout(freezeToSql, 50);
    });
    $('#cards-data-search-section').remove();
    recordBadge.text(0);
    loadMasksForDynamicInputs();
};

const loadPatientCardTemplate = function () {
    return `<div class="row">
                    <div id="personal-data-section" class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-user-circle" aria-hidden="true"></i> Личные данные
                            </div>
                            <div class='patient-card-information-section-body'>
                                <div class="row">
                                    <div class="col-6">
                                        <div id="patient-card-alive-section" class="patient-card-status">
                                            <input name="is-alive-id" hidden>
                                            <i id="patient-alive-image"></i>
                                            <i id="patient-alive-status">Живой</i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div id="patient-card-attached-section" class="patient-card-status">
                                            <input name="is-attach-id" hidden>
                                            <i id="patient-attached-image"></i>
                                            <i id="patient-attached-status">Прикреплен</i>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <input name="id" hidden>
                                <label for="card-number">Номер карты<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="card-number" name="card-number" placeholder="Номер карты" required>
                                </div>
                                <label  for="full-name">ФИО<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user-circle"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="full-name" name="full-name" placeholder="ФИО" required>
                                </div>
                                <label  for="gender">Пол:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-venus-mars"></i> </div>
                                    </div>
                                    <select id="gender" name="gender" class="custom-select"></select>
                                </div>
                                <label  for="date-birth">Дата рождения<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-birthday-cake"></i> </div>
                                    </div>
                                    <input type="date" class="form-control" id="date-birth" name="date-birth">
                                </div>
                                <label  for="telephone">Номер телефона:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-phone"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Номер телефона">
                                </div>
                                <label  for="email">Электронная почта:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="document-section" class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-folder" aria-hidden="true"></i> Документы
                            </div>
                            <div class='patient-card-information-section-body'>
                                <label for="insurance-certificate">СНИЛС<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="insurance-certificate" name="insurance-certificate" placeholder="СНИЛС" required>
                                </div>
                                <hr>
                                <label for="policy-number">Единый номер полиса<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clipboard"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="policy-number" name="policy-number" placeholder="Номер полиса" required>
                                </div>
                                <input name="insurance-company-id" hidden>
                                <label for="insurance-company">Страховая компания:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clipboard"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="insurance-company" name="insurance-company" placeholder="Страховая компания">
                                </div>
                                <hr>
                                <label for="passport-serial">Серия паспорта:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="passport-serial" name="passport-serial" placeholder="Серия паспорта">
                                </div>
                                <label for="passport-number">Номер паспорта:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="passport-number" name="passport-number" placeholder="Номер паспорта">
                                </div>
                                <input name="fms-department-id" hidden>
                                <label for="fms-department">Отдел ФМС выдавший папорт:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                    </div>
                                    <textarea class="form-control" id="fms-department" name="fms-department"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="addresses-section" class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-address-book" aria-hidden="true"></i> Адреса
                            </div>
                            <div class='patient-card-information-section-body'>
                                <label for="region">Регион:</label>
                                <div  class="input-group mb-2">
                                    <input name="region-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="region" name="region" placeholder="Регион">
                                    <div id="region-search-result-area" class="search-result-area"></div>
                                </div>
                                <label for="district">Район:</label>
                                <div class="input-group mb-2">
                                    <input name="district-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="district" name="district" placeholder="Район">
                                    <div id="district-search-result-area" class="search-result-area"></div>
                                </div>
                                <label for="locality">Населенный пункт:</label>
                                <div class="input-group mb-2">
                                    <input name="locality-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="locality" name="locality" placeholder="Населенный пункт">
                                    <div id="locality-search-result-area" class="search-result-area"></div>
                                </div>
                                <label for="street">Улица:</label>
                                <div class="input-group mb-2">
                                    <input name="street-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="street" name="street" placeholder="Улица">
                                    <div id="street-search-result-area" class="search-result-area"></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="house-number">Номер дома:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-building"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="house-number" name="house-number">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="apartment">Номер квартиры:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-building"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="apartment" name="apartment">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="additionally-section" class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-info-circle" aria-hidden="true"></i> Дополнительно
                            </div>
                            <div class='patient-card-information-section-body'>
                                <label for="workplace">Место работы:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-info-circle"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="workplace" name="workplace" placeholder="Место работы">
                                </div>
                                <label for="profession">Профессия:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-info-circle"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="profession" name="profession" placeholder="Место работы">
                                </div>
                                <hr>
                                <label for="notation">Примечание:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-info-circle"></i> </div>
                                    </div>
                                    <textarea class="form-control" id="notation" name="notation"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
};

/**
 * Маски для input
 */

const loadMasksForDynamicInputs = function() {
    let patient_card_body = $("#patient-card-body");
    setTimeout(function () {
        let insurance_certificate = patient_card_body.find($("#insurance-certificate"));
        let telephone = patient_card_body.find($("#telephone"));
        insurance_certificate.mask("999-999-999 99");
        telephone.mask("9(999)999-99-99");
    }, 100);
};

const loadMasksForStaticInputs = function(){
    $("#add-insurance-certificate").mask("999-999-999 99");
};

/**
 * Поиск в input'ах внутри карты
 */

patient_card_body.on('keyup', '#region', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(searchRegion, 500);
});

const searchRegion = function () {
    searchInSection('region');
};

patient_card_body.on('keyup', '#district', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(searchDistrict, 500);
});

const searchDistrict = function (val) {
    /**
     * Я могу передавать какие угодно именованные параметры, при этом метод searchInSection остается универсальным,
     * так как он работает что с параметрами, что без них
     */
    let params = {
        regionId: $('input[name="region-id"]').val()
    };
    searchInSection('district', params);
};

/**
 * Универсальные методы для работы с поиском внтри секций
 * 1 - выбор результата
 * 2 - поиск по значению внутри input'а
 * 3 - подгрузка результатов поиска
 */

patient_card_body.on('click', '.with-result', function () {
    let parent = ($(this).parent().parent().parent());   //Ищу родителя, в котором находится выведенный результат
    let firstInputName = parent.children('input').eq(0).attr("name");   //Получаю имя input 1, где хранится id
    let secondInputName = parent.children('input').eq(1).attr("name");  //Получаю имя input 2, где хранится текст
    let Id = $(`input[name=${firstInputName}]`);
    let selectedValue = $(this).children('.search-id').text();
    let selectedText = $(this).children('.search-text').text();
    let SearchResultArea = $(`#${secondInputName}-search-result-area`);
    let InputText = $(`input[name=${secondInputName}]`);
    Id.val(selectedValue);  //Установка id для обновления в БД
    SearchResultArea.empty();   //Очищаю место вывода результатов
    InputText.val(selectedText);    //Меняю текст, для того что бы было понятно, что выбрано
    updatePatientCardData();    //Обновляю данные в БД
});

const searchInSection = function(field, params){
    let searchString = $(`input[name=${field}]`).val();
    let SearchResultArea = $(`#${field}-search-result-area`);
    if (searchString.length > 0){
        let request = $.ajax({
            type: "POST",
            url: `/patient-card/search-${field}`,
            data: {'searchString' : searchString, 'params' : params},
            cache: false
        });
        request.done(function (response) {
            SearchResultArea.empty();
            $(`#${field}-search-result-area`).append(`<div id="${field}-search-result" class="search-result-container"></div>`);
            if (Array.isArray(response)) {
                $.each(response, function (key, value) {
                    let line = loadSearchInSectionLine(value, field);
                    $(`#${field}-search-result`).append(line);
                    console.log(response);
                });
            }else {
                let line = `<div class="patient-card-search-result-line">${response}</div>`;
                $(`#${field}-search-result`).append(line);
            }
        })
    }else {
        SearchResultArea.empty();
    }
};

const loadSearchInSectionLine = function (response, field) {
    let fieldName = field+'_name'; //На будующее будет понятно как с этим работать
    return $(`<div class="patient-card-search-result-line with-result">
                <div class="search-id" hidden>${response.id}</div>
                <div class="search-text">${response[fieldName]}</div>
              </div>`).hide().fadeIn(1000);
};
