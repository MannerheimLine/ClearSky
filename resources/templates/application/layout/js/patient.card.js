/*
 * Java Script касаемый карыт пациента
 * Когда я захожу на patine-card/show/xxx
 * Подгружается этот скрипт. Нужен для управлением всеми DOM эдементами на странице show.page
 *
 */

let typingTimer;

const MAN = 1;
const WOMAN = 2;
const CHILD = 3;

const patient_card_body = $('#patient-card-body');
const patient_card_menu = $('#patient-card-menu');
const modals = $('#modals');
const card_search_input =  $("input[name='card-search']");

$(function () {
    let data = {
        "card_data": {
            "status": $("input[name='status']").val(),
            "humanType": parseInt($("input[name='human-type']").val()),
            "isAliveId": parseInt($("input[name='is-alive-id']").val()),
            "isAttachId": parseInt($("input[name='is-attach-id']").val())
        }
    };
    //Действуя таким способом я делаю лишний запрос к серверу и БД.
    //let cardId = $("input[name='id']").val();
    //getCardData(cardId).done(function (result) {
        //loadCardMenu(result);
        //showCardStatuses(result);
    //});
    loadCardMenu(data);
    showCardStatuses(data);
    loadMasksForDynamicInputs();
    loadMasksForStaticInputs();
});

const flipAttachStatus = function () {
    let attachedSection = $('#patient-card-attached-section');
    let attachedImage = $("#patient-attached-image");
    let attachedStatus = $('#patient-attached-status');
    let input = $("input[name='is-attach-id']");
    if (parseInt(input.val()) === 1){
        input.val(2);
        attachedSection.css({'color' : '#d80e1b'});
        attachedImage.attr('class', 'fa fa-user-times');
        attachedStatus.text('Откреплен');
    }else {
        input.val(1);
        attachedSection.css({'color' : '#28a745'});
        attachedImage.attr('class', 'fa fa-user-plus');
        attachedStatus.text('Прикреплен');
    }
};

const flipAliveStatus = function () {
    let input = $("input[name='is-alive-id']");
    let humanType = getHumanType();
    let aliveSection = $('#patient-card-alive-section');
    let aliveImage = $("#patient-alive-image");
    let aliveStatus= $('#patient-alive-status');
    if (parseInt(input.val()) === 1){
        input.val(2);
        aliveSection.css({'color' : '#d80e1b'});
        aliveImage.attr('class', 'fa fa-skull');
        aliveStatus.text('Мертвый');
    }else {
        input.val(1);
        aliveSection.css({'color' : '#28a745'});
        aliveStatus.text('Живой');
        switch (humanType) {
            case 1 : aliveImage.attr('class', 'fa fa-male'); break;
            case 2 : aliveImage.attr('class', 'fa fa-female'); break;
            case 3 : aliveImage.attr('class', 'fa fa-child'); break;
            default : aliveImage.attr('class', 'fa fa-male');
        }
    }
};

const getHumanType = function(){
    let dob = $('#date-birth').val();
    let gender = $('#gender').val();
    let birthDate = new Date(dob);
    let cur = new Date();
    let diff = cur - birthDate; // This is the difference in milliseconds
    let age = Math.floor(diff/31557600000); // Divide by 1000*60*60*24*365.25
    if (age >= 18){
        switch (gender) {
            case 1 : return MAN;
            case 2 : return  WOMAN;
        }
    }else {
        return CHILD;
    }
};


/**
 * Редактировнаие карты, обновление, добавление, сохранение
 */

patient_card_menu.on('click', '#edit-card-button',function () {
    editCardData();
});

patient_card_menu.on('click', '#save-card-button', function () {
    saveCardData();
});

patient_card_menu.on('click', '#unblock-card-button', function () {
    unblockCardData();
});

patient_card_menu.on('click', '#talon-button', function () {
    window.open('/app/patient-card/talon/ambulatory/show/' + $("input[name='id']").val(), '_blank');
});

modals.on('click', '#add-card-button', function () {
    addCardData();
});

const saveCardData = function () {
    updateCardData().done(function (response) {
        if (response.status === 'fail'){
            $('.incorrect-input-message').remove();
            patient_card_body.each(function () {
                $(this).find(':input').removeClass('incorrect-input-border');
                $(this).find($(".input-group-text")).removeClass('incorrect-input-group');
            });
            $.each(response.incomplete.errors, function (key, value) {
                switch (value.errorType) {
                    case 'Duplicate Key Entrance' : duplicateErrorHandle(value); break;
                    case 'Required Field Is Empty' : drawIncorrectInputMessage(value); break;
                    case 'Wrong Full Name' : drawIncorrectInputMessage(value); break;
                    case 'Not Owner Access' : notOwnerAccessHandler(value); break;
                }
            });
        }else {
            $('#save-card-button').delay(500).fadeOut(500, function () {
                $(this).remove();
            });
            let controlButtonsPanel = $('#card-control-buttons');
            let editButton = $(`<button id="edit-card-button" class="btn btn-dark btn-sm mr-1" ><i class="fa fa-edit"></i> Изменить</button>`).hide().fadeIn(1000);
            controlButtonsPanel.append(editButton);
            $('.incorrect-input-message').remove();
            patient_card_body.each(function() {
                $(this).find(':input').attr('disabled', 'true');
                $(this).find(':input').removeClass('incorrect-input-border');
                $(this).find($(".input-group-text")).removeClass('incorrect-input-group');
                $('.patient-card-status').addClass('blocked-status').removeClass('editable-status');
            });
        }
    });
};

const updateCardData = function () {
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
    return $.ajax({
        type: "POST",
        url: "/app/patient-card/update",
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
};

const editCardData = function () {
    let id = $("input[name='id']").val();
    let request = $.ajax({
        type: "POST",
        url: "/app/patient-card/edit",
        data: {'id': id},
        cache: false
    });
    request.done(function (response) {
        if (response.status === 'success'){
            $('#edit-card-button').delay(500).fadeOut(500, function () {
                $(this).remove();
            });
            let controlButtonsPanel = $('#card-control-buttons');
            let save_button = $(`<button id="save-card-button" class="btn btn-success btn-sm mr-1"><i class="fa fa-save"></i> Сохранить</button>`).hide().fadeIn(1000);
            controlButtonsPanel.append(save_button);
            console.log(response.complete.content[0].message.text + ' ' + response.complete.content[0].cardId);
            patient_card_body.each(function(){
                $(this).find(':input').removeAttr('disabled');
                $('.patient-card-status').addClass('editable-status').removeClass('blocked-status');
            });
        }else {
            console.log(response.incomplete.errors[0].message.text + ' ' + response.incomplete.errors[0].cardId);
        }
    });
};

const addCardData = function () {
    let card_number_value = $("input[name='add-card-number']").val();
    let full_name_value = $("input[name='add-full-name']").val();
    let gender_value = $("select[name='add-gender']").val();
    let date_birth_value = $("input[name='add-date-birth']").val();
    let insurance_certificate_value = $("input[name='add-insurance-certificate']").val();
    let policy_number_value = $("input[name='add-policy-number']").val();
    let request = $.ajax({
        type: "POST",
        url: "/app/patient-card/add",
        data: {
            'cardNumber' : card_number_value,
            'fullName' : full_name_value,
            'gender' : gender_value,
            'dateBirth' : date_birth_value,
            'insuranceCertificate' : insurance_certificate_value,
            'policyNumber' : policy_number_value,
        },
        cache: false
    });
    request.done(function (response) {
        if (response.status === 'success'){
            $("#addPatientCardModal").modal('hide');
            loadCard(response.complete.response[0].id);
            modals.each(function () {
                $(this).find(':input').val('');
            });
        }else {
            $('.incorrect-input-message').remove();
            modals.each(function () {
                $(this).find(':input').removeClass('incorrect-input-border');
                $(this).find($(".input-group-text")).removeClass('incorrect-input-group');
            });
            $.each(response.incomplete.errors, function (key, value) {
                switch (value.errorType) {
                    case 'Duplicate Key Entrance' : duplicateErrorHandle(value, 'add-'); break;
                    case 'Required Field Is Empty' : drawIncorrectInputMessage(value, 'add-'); break;
                    case 'Wrong Full Name' : drawIncorrectInputMessage(value, 'add-'); break;
                }
            });
        }
    });
};

const unblockCardData = function () {
    let id = $("input[name='id']").val();
    let request = $.ajax({
        type: "POST",
        url: "/app/patient-card/unblock",
        data: {
            'id' : id
        },
        cache: false
    });
    request.done(function (response) {
        $('#unblock-card-button').delay(500).fadeOut(500, function () {
            $(this).remove();
        });
        let controlButtonsPanel = $('#card-control-buttons');
        let editButton = $(`<button id="edit-card-button" class="btn btn-dark btn-sm mr-1" ><i class="fa fa-edit"></i> Изменить</button>`).hide().fadeIn(1000);
        controlButtonsPanel.append(editButton);
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
            loadCard(1);
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

patient_card_body.on('click', '.editable-status', function () {
    let statusPanelId = $(this).attr('id');
    switch (statusPanelId) {
        case 'patient-card-alive-section' : flipAliveStatus(); break;
        case 'patient-card-attached-section' : flipAttachStatus(); break;
    }
});

const searchCards = function (searchString, selectedPage) {
    let recordBadge = $('#patient-card-found-records');
    patient_card_body.empty();
    patient_card_body.append(loadPatientCardSearchTemplate());
    $('#current-page').val(selectedPage); //Записываю номер текущей страницы в input для быстрого доступа
    let request = $.ajax({
        type: "POST",
        url: "/app/patient-card/search-cards",
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
                    <td>${response.insurance_certificate}</td>
                    <td><i class="${live_status_image}" style="font-size: 18px;"></i></td>
                    <td><i class="${attached_status_image}" style="font-size: 18px;"></i></td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" onclick="loadCard(${response.id})">
                            <i class="fa fa-search"></i> Посмотреть
                        </button>
                    </td>
                </tr>`).hide().fadeIn(1000);
};


/**
 * Загрузка карты пациента
 */

const loadCard = function (cardId) {
    history.pushState(null, null, '/app/patient-card/show/'+cardId);
    getCardData(cardId).done(function (result) {
        loadCardData(result);
        loadCardMenu(result);
    });
};

const getCardData = function (id) {
    return $.ajax({
        type: "GET",
        url: "/app/patient-card/get/" +id,
        cache: false
    });
};

const loadCardData = function (data) {
    let recordBadge = $('#patient-card-found-records');
    patient_card_body.empty();
    patient_card_body.append(loadCardTemplate());
    showCardData(data);
    showCardStatuses(data);
    recordBadge.text(0);
    loadMasksForDynamicInputs();
};

const showCardData = function(data){
    let card_data = data.card_data;
    $("input[name='id']").val(card_data.id);
    $("input[name='card-number']").val(card_data.cardNumber);
    $("input[name='is-alive-id']").val(card_data.isAliveId);
    $("#patient-alive-status").text(card_data.isAlive);
    $("input[name='is-attach-id']").val(card_data.isAttachId);
    $("#patient-attach-status").text(card_data.isAttached);
    $("input[name='full-name']").val(card_data.surname + ' ' + card_data.firstName + ' ' + (card_data.secondName || ''));
    $.each(data.genders, function (key, value) {
        $("select[name='gender']").append(`<option value="${value.id}" ${card_data.genderId == value.id ?' selected':''}>${value.description}</option>`)
    });
    $("input[name='date-birth']").val(card_data.dateBirth);
    $("input[name='telephone']").val(card_data.telephone);
    $("input[name='email']").val(card_data.email);
    $("input[name='insurance-certificate']").val(card_data.insuranceCertificate);
    $("input[name='policy-number']").val(card_data.policyNumber);
    $("input[name='insurance-company-id']").val(card_data.insuranceCompanyId);
    $("input[name='insurance-company']").val(card_data.insuranceCompany);
    if((card_data.passportSerial && card_data.passportNumber) != null){
        $("input[name='passport']").val(card_data.passportSerial + ' ' + card_data.passportNumber);
    }else{
        $("input[name='passport']").val('');
    }
    $("textarea[name='fms-department']").val(card_data.fmsDepartment);
    if ((card_data.birthCertificateSerial && card_data.birthCertificateNumber) != null){
        $("input[name='birth-certificate']").val(card_data.birthCertificateSerial + ' ' + card_data.birthCertificateNumber);
    }else {
        $("input[name='birth-certificate']").val('');
    }
    $("textarea[name='registry-office']").val(card_data.registryOffice);
    $("input[name='region-id']").val(card_data.regionId);
    $("input[name='region']").val(card_data.region);
    $("input[name='district-id']").val(card_data.districtId);
    $("input[name='district']").val(card_data.district);
    $("input[name='locality-id']").val(card_data.localityId);
    $("input[name='locality']").val(card_data.locality);
    $("input[name='street-id']").val(card_data.streetId);
    $("input[name='street']").val(card_data.street);
    $("input[name='house-number']").val(card_data.houseNumber);
    $("input[name='apartment']").val(card_data.apartment);
    $("input[name='workplace']").val(card_data.workPlace);
    $("input[name='profession']").val(card_data.profession);
    $("textarea[name='notation']").val(card_data.notation);
};

const loadCardTemplate = function () {
    return `<div class="row">
                    <div id="personal-data-section" class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-user-circle" aria-hidden="true"></i> Личные данные
                            </div>
                            <div class='patient-card-information-section-body'>
                                <div class="row">
                                    <div class="col-6">
                                        <div id="patient-card-alive-section" class="patient-card-status blocked-status">
                                            <input name="is-alive-id" hidden>
                                            <i id="patient-alive-image"></i>
                                            <i id="patient-alive-status">Живой</i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div id="patient-card-attached-section" class="patient-card-status blocked-status">
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
                                    <input type="text" class="form-control" id="card-number" name="card-number" placeholder="Номер карты" disabled>
                                </div>
                                <label  for="full-name">ФИО<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user-circle"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="full-name" name="full-name" placeholder="ФИО" disabled>
                                </div>
                                <label  for="gender">Пол:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-venus-mars"></i> </div>
                                    </div>
                                    <select id="gender" name="gender" class="custom-select" disabled></select>
                                </div>
                                <label  for="date-birth">Дата рождения<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-birthday-cake"></i> </div>
                                    </div>
                                    <input type="date" class="form-control" id="date-birth" name="date-birth" disabled>
                                </div>
                                <label  for="telephone">Номер телефона:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-phone"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Номер телефона" disabled>
                                </div>
                                <label  for="email">Электронная почта:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" disabled>
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
                                    <input type="text" class="form-control" id="insurance-certificate" name="insurance-certificate" placeholder="СНИЛС" disabled>
                                </div>
                                <hr>
                                <label for="policy-number">Единый номер полиса<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clipboard"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="policy-number" name="policy-number" placeholder="Номер полиса" disabled>
                                </div>
                                <label for="insurance-company">Страховая компания:</label>
                                <div class="input-group mb-2">
                                    <input name="insurance-company-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clipboard"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="insurance-company" name="insurance-company" placeholder="Страховая компания" disabled>
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
                                            <input type="text" class="form-control" id="passport" name="passport" placeholder="Серия, номер паспорта" disabled>
                                        </div>
                                        <label for="fms-department">Отдел ФМС выдавший паспорт:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <textarea class="form-control" id="fms-department" name="fms-department" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="birth-certificate-panel" role="tabpanel">
                                        <label for="birth-certificate">Серия, номер свидетельства:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="birth-certificate" name="birth-certificate" placeholder="Серия, номер свидетельства" disabled>
                                        </div>
                                        <label for="registry-office">Отдел ЗАГС выдавший свидетельство:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <textarea class="form-control" id="registry-office" name="registry-office" disabled></textarea>
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
                                    <input type="text" class="form-control" id="region" name="region" placeholder="Регион" disabled>
                                    <div id="region-search-result-area" class="search-result-area"></div>
                                </div>
                                <label for="district">Район:</label>
                                <div class="input-group mb-2">
                                    <input name="district-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="district" name="district" placeholder="Район" disabled>
                                    <div id="district-search-result-area" class="search-result-area"></div>
                                </div>
                                <label for="locality">Населенный пункт:</label>
                                <div class="input-group mb-2">
                                    <input name="locality-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="locality" name="locality" placeholder="Населенный пункт" disabled>
                                    <div id="locality-search-result-area" class="search-result-area"></div>
                                </div>
                                <label for="street">Улица:</label>
                                <div class="input-group mb-2">
                                    <input name="street-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="street" name="street" placeholder="Улица" disabled>
                                    <div id="street-search-result-area" class="search-result-area"></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="house-number">Номер дома:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-building"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="house-number" name="house-number" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="apartment">Номер квартиры:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-building"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="apartment" name="apartment" disabled>
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
                                    <input type="text" class="form-control" id="workplace" name="workplace" placeholder="Место работы" disabled>
                                </div>
                                <label for="profession">Профессия:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-info-circle"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="profession" name="profession" placeholder="Место работы" disabled>
                                </div>
                                <hr>
                                <label for="notation">Примечание:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-info-circle"></i> </div>
                                    </div>
                                    <textarea class="form-control" id="notation" name="notation" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
};

const showCardStatuses = function (data) {
    let card_data = data.card_data;
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
};

const loadCardMenu = function (cardData) {
    let status = cardData.card_data.status;
    let controlButtonsPanel = $('#card-control-buttons');
    let auxiliaryButtonsPanel = $('#card-auxiliary-buttons');
    controlButtonsPanel.empty();
    auxiliaryButtonsPanel.empty();
    let create_button = $(`<button id="create-card-button" class="btn btn-dark btn-sm mr-1" data-toggle="modal" data-target="#addPatientCardModal"><i class="fa fa-plus-circle"></i> Создать</button>`).hide().fadeIn(1000);
    let edit_button = $(`<button id="edit-card-button" class="btn btn-dark btn-sm mr-1" ><i class="fa fa-edit"></i> Изменить</button>`).hide().fadeIn(1000);
    let unblock_button = $(`<button id="unblock-card-button" class="btn btn-danger btn-sm mr-1"><i class="fa fa-save"></i> Разблокировать</button>`).hide().fadeIn(1000);
    let talon_button = $(`<button id="talon-button" class="btn btn-dark btn-sm mr-1"><i class="fa fa-print"></i> Печать талона</button>`).hide().fadeIn(1000);
    controlButtonsPanel.append(create_button);
    switch (status) {
        case 'owner' :
            controlButtonsPanel.append(unblock_button);
            break;
        case 'other' :
            controlButtonsPanel.append(edit_button.attr('disabled', 'true'));
            break;
        default : controlButtonsPanel.append(edit_button);
    }
    auxiliaryButtonsPanel.append(talon_button);
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
});

const searchInSection = function(field, params){
    let searchString = $(`#${field}`).val();//$(`input[name=${field}]`).val();
    let SearchResultArea = $(`#${field}-search-result-area`);
    if (searchString.length > 0){
        let request = $.ajax({
            type: "POST",
            url: `/app/patient-card/search-${field}`,
            data: {'searchString' : searchString, 'params' : params},
            cache: false
        });
        request.done(function (response) {
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


/**
 * Обработка ошибок
 */
const drawIncorrectInputMessage = function (value, fieldPrefix = '') {
    let parent = $(`#${fieldPrefix+value.fieldName}`).parent();
    let panel = `<div class="incorrect-input-message"><i>${value.message.text}</i></div>`;
    let input_group_text = parent.find($(".input-group-text"));
    let input = parent.find('input');
    parent.before(panel);
    input_group_text.addClass('incorrect-input-group');
    input.addClass('incorrect-input-border');
};

const duplicateErrorHandle = function (value, fieldPrefix = '') {
    $('#watch-duplicated-card-button').parent().remove();
    drawIncorrectInputMessage(value, fieldPrefix);
    let button = `<div class="input-group-append"><button id="watch-duplicated-card-button" class="btn btn-danger btn-sm"><i class="fa fa-clipboard"></i> Смотреть</button></div>`;
    $(`#${value.fieldName}`).parent().find('input').after(button);
};

const notOwnerAccessHandler = function (value) {
    alert(value.message.text);
};