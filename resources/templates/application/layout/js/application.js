/*
 *
 *
 *
 *
 *
 */

let typingTimer;
let specInputs = [
    '#region',
    '#district',
    '#locality',
    '#street',
    '#insurance-company'
];

const patient_card_body = $('#patient-card-body');

const card_search_input =  $("input[name='card-search']");

$(function () {
    loadPatientCardData(1);
    loadMasksForDynamicInputs();
    loadMasksForStaticInputs();
});

$("#patient-card-body :input").not(specInputs.join(',')).change(function() {
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

const flipPatientCardStatus = function (name) {
    let input = $(`input[name=${name}]`);
    if (input.val() == 1){
       input.val(2);
    }else {
        input.val(1);
    }
};

const updatePatientCardData = function () {
    let id = $("input[name='id']").val();
    let cardNumber = $("input[name='card-number']").val();
    let isAliveId = $("input[name='is-alive-id']").val();
    let isAttachId = $("input[name='is-attach-id']").val();
    let fullName = $("input[name='full-name']").val();
    let gender = $("select[name='gender']").val();
    let dateBirth = $("input[name='date-birth']").val();
    let telephone = $("input[name='telephone']").val();
    let email = $("input[name='email']").val();
    let insuranceCertificate = $("input[name='insurance-certificate']").val();
    let policyNumber = $("input[name='policy-number']").val();
    let insuranceCompany = $("input[name='insurance-company-id']").val();
    let passport = $("input[name='passport']").val();
    let fmsDepartment = $("textarea[name='fms-department']").val();
    let birthCertificate = $("input[name='birth-certificate']").val();
    let registryOffice = $("textarea[name='registry-office']").val();
    let region = $("input[name='region-id']").val();
    let district = $("input[name='district-id']").val();
    let locality = $("input[name='locality-id']").val();
    let street = $("input[name='street-id']").val();
    let houseNumber = $("input[name='house-number']").val();
    let apartment = $("input[name='apartment']").val();
    let workplace = $("input[name='workplace']").val();
    let profession = $("input[name='profession']").val();
    let notation = $("textarea[name='notation']").val();
    let request = $.ajax({
        type: "POST",
        url: "/patient-card/update",
        data: {
            'id' : id,
            'cardNumber' : cardNumber,
            'isAlive' : isAliveId,
            'isAttach' : isAttachId,
            'fullName' : fullName,
            'gender' : gender,
            'dateBirth' : dateBirth,
            'telephone' : telephone,
            'email' : email,
            'insuranceCertificate' : insuranceCertificate,
            'policyNumber' : policyNumber,
            'insuranceCompany' : insuranceCompany,
            'passport' : passport,
            'fmsDepartment' : fmsDepartment,
            'birthCertificate' : birthCertificate,
            'registryOffice' : registryOffice,
            'region' : region,
            'district' : district,
            'locality' : locality,
            'street' : street,
            'houseNumber' : houseNumber,
            'apartment' : apartment,
            'workplace' : workplace,
            'profession' : profession,
            'notation' : notation
        },
        cache: false
    });
    request.done(function (response) {
        if (response.status === 'fail'){
            $('.incorrect-input-message').remove();
            $.each(response.errors.error, function (key, value) {
                let parent = $(`#${value.field}`).parent();
                let panel = `<div class="incorrect-input-message"><i>${value.message.text}</i></div>`;
                let input_group_text = parent.find($(".input-group-text"));
                let input = parent.find('input');
                parent.before(panel);
                input_group_text.addClass('incorrect-input-group');
                input.addClass('incorrect-input-border');
            });
        }else {
            console.log(response.complete.message[0].text);
        }
    });
    return id;
};

const editPatientCardData = function () {
    let id = $("input[name='id']").val();
    let request = $.ajax({
        type: "POST",
        url: "/patient-card/edit",
        data: {'id': id},
        cache: false
    });
    request.done(function (response) {
        console.log(response);
        if (response.status === 'success'){
            console.log(response.complete.content[0].message.text + ' ' + response.complete.content[0].cardId);
            patient_card_body.each(function(){
                $(this).find(':input').removeAttr('disabled');
            });
        }else {
            onsole.log(response.errors.error[0].message.text + ' ' + response.errors.error[0].cardId);
        }

    });
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
        loadPatientCard(response);
    });
};

/**
 * Поиск карт
 */

card_search_input.keyup(function (e) {
    let searchString = card_search_input.val();
    if (e.which === 13){
        if (searchString.length > 0) {
            searchCards(searchString, 1);
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

patient_card_body.on('click', '#next-page', function () {
    let searchString = card_search_input.val();
    let selectedPage = +$('#current-page').val() + 1;
    searchCards(searchString, selectedPage);
});

patient_card_body.on('click', '#previous-page', function () {
    let searchString = card_search_input.val();
    let selectedPage = +$('#current-page').val() - 1 || 1;
    searchCards(searchString, selectedPage);

});

const searchCards = function (searchString, selectedPage) {
    let recordBadge = $('#patient-card-found-records');
    patient_card_body.empty();
    patient_card_body.append(loadPatientCardSearchTemplate());
    $('#current-page').val(selectedPage); //Записываю номер текущей страницы в input для быстрого доступа
    let request = $.ajax({
        type: "POST",
        url: "/patient-card/search-cards",
        data: {'searchString' : searchString, 'selectedPage' : selectedPage},
        cache: false
    });
    request.done(function (response) {
        if(response != null){
            let cards = response.cards;
            let pageOrder = response.pageOrder;
            if (cards != null){
                /**
                 * Необходимо проверить статус для определения, того как отображать кнопки пагинации
                 */
                switch (pageOrder) {
                    case 'first' :
                        $('#previous-page').parent().addClass('disabled');
                        break;
                    case 'last' :
                        $('#next-page').parent().addClass('disabled');
                        break;
                    case 'middle' :
                        $('#next-page').parent().removeClass('disabled');
                        break;
                    default :
                        $('#previous-page').parent().addClass('disabled');
                        $('#next-page').parent().addClass('disabled');
                        break;
                }
                let tableContent = $('#cards-data-table-content');
                let recordCount = cards.length || 0;
                recordBadge.text(recordCount);
                tableContent.empty();
                $.each(cards, function (key, value) {
                    let line = loadCardsDataTableContentLine(value);
                    tableContent.append(line);
                });
            }
        }else {
            let cardsDataSearchSection = $('#cards-data-search-section');
            let alert = `<div class="alert alert-danger" role="alert" style="width: 100%;">
                            Не найдено ни одной соответсвующей записи! Проверьте строку запроса и повторите поиск.
                         </div>`;
            cardsDataSearchSection.append(alert);
            $('#previous-page').parent().addClass('disabled');
            $('#next-page').parent().addClass('disabled');
        }
    });
};

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
        </div>
        <div id="cards-data-search-pagination">
        <div class="text-xs-center">
            <ul class="pagination pagination-center">
                <input id="current-page" name="current-page" hidden>
                <li class="page-item"><a id="previous-page" class="page-link" href="#">Предыдущая</a></li>
                <li class="page-item"><a id="next-page" class="page-link" href="#">Следующая</a></li>
            </ul>
        </div>
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
    patient_card_body.empty();
    patient_card_body.append(loadPatientCardTemplate());
    let recordBadge = $('#patient-card-found-records');
    loadPatientCardData(id);
    $("#patient-card-body :input").not(specInputs.join(',')).change(function() {updatePatientCardData()});
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

const loadPatientCardData = function (requestedId) {
    let id = $("input[name='id']");
    let cardNumber = $("input[name='card-number']");
    let isAliveId = $("input[name='is-alive-id']");
    let isAlive = $("#patient-alive-status");
    let isAttachedId = $("input[name='is-attach-id']");
    let isAttached = $("#patient-attach-status");
    let fullName = $("input[name='full-name']");
    let gender = $("select[name='gender']");
    let dateBirth = $("input[name='date-birth']");
    let telephone = $("input[name='telephone']");
    let email = $("input[name='email']");
    let insuranceCertificate = $("input[name='insurance-certificate']");
    let policyNumber = $("input[name='policy-number']");
    let insuranceCompanyId = $("input[name='insurance-company-id']");
    let insuranceCompany = $("input[name='insurance-company']");
    let passport = $("input[name='passport']");
    let fmsDepartment = $("textarea[name='fms-department']");
    let birthCertificate = $("input[name='birth-certificate']");
    let registryOffice = $("textarea[name='registry-office']");
    let regionId = $("input[name='region-id']");
    let region = $("input[name='region']");
    let districtId = $("input[name='district-id']");
    let district = $("input[name='district']");
    let localityId = $("input[name='locality-id']");
    let locality = $("input[name='locality']");
    let streetId = $("input[name='street-id']");
    let street = $("input[name='street']");
    let houseNumber = $("input[name='house-number']");
    let apartment = $("input[name='apartment']");
    let workplace = $("input[name='workplace']");
    let profession = $("input[name='profession']");
    let notation = $("textarea[name='notation']");
    let request = $.ajax({
        type: "GET",
        url: "/patient-card/show/" + requestedId,
        cache: false
    });
    request.done(function (response) {
        let card_data = response.card_data;
        id.val(card_data.id);
        cardNumber.val(card_data.cardNumber);
        isAliveId.val(card_data.isAliveId);
        isAlive.text(card_data.isAlive);
        isAttachedId.val(card_data.isAttachId);
        isAttached.text(card_data.isAttached);
        fullName.val(card_data.surname + ' ' + card_data.firstName + ' ' + (card_data.secondName || ''));
        $.each(response.genders, function (key, value) {
            gender.append(`<option value="${value.id}" ${card_data.genderId == value.id ?' selected':''}>${value.description}</option>`)
        });
        dateBirth.val(card_data.dateBirth);
        telephone.val(card_data.telephone);
        email.val(card_data.email);
        insuranceCertificate.val(card_data.insuranceCertificate);
        policyNumber.val(card_data.policyNumber);
        insuranceCompanyId.val(card_data.insuranceCompanyId);
        insuranceCompany.val(card_data.insuranceCompany);
        if((card_data.passportSerial && card_data.passportNumber) != null){
            passport.val(card_data.passportSerial + ' ' + card_data.passportNumber);
        }else{
            passport.val('');
        }
        fmsDepartment.val(card_data.fmsDepartment);
        if ((card_data.birthCertificateSerial && card_data.birthCertificateNumber) != null){
            birthCertificate.val(card_data.birthCertificateSerial + ' ' + card_data.birthCertificateNumber);
        }else {
            birthCertificate.val('');
        }
        registryOffice.val(card_data.registryOffice);
        regionId .val(card_data.regionId);
        region .val(card_data.region);
        districtId.val(card_data.districtId);
        district.val(card_data.district);
        localityId.val(card_data.localityId);
        locality.val(card_data.locality);
        streetId.val(card_data.streetId);
        street.val(card_data.street);
        houseNumber.val(card_data.houseNumber);
        apartment.val(card_data.apartment);
        workplace.val(card_data.workPlace);
        profession.val(card_data.profession);
        notation.val(card_data.notation);

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
                                    <input type="text" class="form-control" id="insurance-certificate" name="insurance-certificate" placeholder="СНИЛС">
                                </div>
                                <hr>
                                <label for="policy-number">Единый номер полиса<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clipboard"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="policy-number" name="policy-number" placeholder="Номер полиса">
                                </div>
                                <label for="insurance-company">Страховая компания:</label>
                                <div class="input-group mb-2">
                                    <input name="insurance-company-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clipboard"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="insurance-company" name="insurance-company" placeholder="Страховая компания">
                                    <div id="insurance-company-search-result-area" class="search-result-area"></div>
                                </div>
                                <hr>
                                <ul class="nav nav-tabs nav-fill" id="person-documents-navs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active text-warning" id="passport-tab" data-toggle="tab" href="#passport-panel" role="tab" aria-controls="home" aria-selected="true">Паспорт</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-danger" id="birth-certificate-tab" data-toggle="tab" href="#birth-certificate-panel" role="tab" aria-controls="profile" aria-selected="false">Свидетельство</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="person-documents-content">
                                    <div class="tab-pane fade show active" id="passport-panel" role="tabpanel">
                                        <label for="passport">Серия, номер паспорта:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="passport" name="passport" placeholder="Серия, номер паспорта">
                                        </div>
                                        <label for="fms-department">Отдел ФМС выдавший паспорт:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <textarea class="form-control" id="fms-department" name="fms-department"></textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="birth-certificate-panel" role="tabpanel">
                                        <label for="birth-certificate">Серия, номер свидетельства:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="birth-certificate" name="birth-certificate" placeholder="Серия, номер свидетельства">
                                        </div>
                                        <label for="registry-office">Отдел ЗАГС выдавший свидетельство:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <textarea class="form-control" id="registry-office" name="registry-office"></textarea>
                                            <div id="fms-department-search-result-area" class="search-result-area"></div>
                                        </div>
                                    </div>
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
        let passport = patient_card_body.find($("#passport"));
        let birthCertificate = patient_card_body.find($("#birth-certificate"));
        insurance_certificate.mask("999-999-999 99");
        telephone.mask("9(999)999-99-99");
        passport.mask("9999 999999");
        birthCertificate.mask("99-99 999999");
    }, 100);
};

const loadMasksForStaticInputs = function(){
    $("#add-insurance-certificate").mask("999-999-999 99");
};


/**
 * Работа с поиском в секции АДРЕСА
 */

patient_card_body.on('keyup', '#region', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function () {
        searchInSection('region');
    }, 500);
    //Очистка полей
    $("input[name='district-id']").val('');
    $("input[name='district']").val('');
    $("input[name='locality-id']").val('');
    $("input[name='locality']").val('');
    $("input[name='street-id']").val('');
    $("input[name='street']").val('');
});

patient_card_body.on('keyup', '#district', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function () {
        let params = {
            searchId: $('input[name="region-id"]').val()
        };
        searchInSection('district', params);
    }, 500);
    $("input[name='locality-id']").val('');
    $("input[name='locality']").val('');
    $("input[name='street-id']").val('');
    $("input[name='street']").val('');
});

patient_card_body.on('keyup', '#locality', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function () {
        let params = {
            searchId: $('input[name="district-id"]').val()
        };
        searchInSection('locality', params);
    }, 500);
    $("input[name='street-id']").val('');
    $("input[name='street']").val('');
});

patient_card_body.on('keyup', '#street', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function () {
        let params = {
            searchId: $('input[name="locality-id"]').val()
        };
        searchInSection('street', params);
    }, 500);
});


/**
 * Работа с поиском в секции ДОКУМЕНТЫ
 */

patient_card_body.on('keyup', '#insurance-company', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function () {
        searchInSection('insurance-company');
    }, 500);
});


/**
 * Универсальные методы для работы с поиском внутри секций
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
    let searchString = $(`#${field}`).val();//$(`input[name=${field}]`).val();
    let SearchResultArea = $(`#${field}-search-result-area`);
    if (searchString.length > 0){
        let request = $.ajax({
            type: "POST",
            url: `/patient-card/search-${field}`,
            data: {'searchString' : searchString, 'params' : params},
            cache: false
        });
        request.done(function (response) {
            console.log(response);
            SearchResultArea.empty();
            $(`#${field}-search-result-area`).append(`<div id="${field}-search-result" class="search-result-container"></div>`);
            if (Array.isArray(response)) {
                $.each(response, function (key, value) {
                    let line = loadSearchInSectionLine(value);
                    $(`#${field}-search-result`).append(line);
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

const loadSearchInSectionLine = function (response) {
    return $(`<div class="patient-card-search-result-line with-result">
                <div class="search-id" hidden>${response.id}</div>
                <div class="search-text">${response.value}</div>
              </div>`).hide().fadeIn(1000);
};
