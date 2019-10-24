/*
 *
 *
 *
 *
 *
 */

const module_wrapper = $('.module-wrapper');
const patient_card_menu = $('.patient_card_menu');
const patient_card_body = $('.patient_card_body');
const personal_data_section = $('#personal-data-section');
const document_section = $('#document-section');
const addresses_section = $('#addresses-section');
const additionally_section = $('#additionally-section');

const id_input = $("input[name='id']");
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
const notation_input = $("textarea[name='notation']");

const patient_card_alive_section = $('#patient-card-alive-section');
const patient_card_attached_section = $('#patient-card-attached-section');
const is_alive_image = $("#patient-alive-image");
const is_attached_image = $("#patient-attached-image");

$(function () {
    loadPatientCardData(1);
});

$(".patient-card-body :input").change(function() {updatePatientCardData()});

patient_card_alive_section.click(function () {
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

patient_card_attached_section.click(function () {
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
    /*let id_value = $("input[name='id']").val();
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
    let notation_value = $("textarea[name='notation']").val();*/
    let request = $.ajax({
        type: "POST",
        url: "/patient-card/update",
        data: {
            'id' : id_input.val(),//id_value,
            'cardNumber' : card_number_input.val(),//card_number_value,
            'isAlive' : is_alive_id_input.val(),//is_alive_id_value,
            'isAttach' : is_attached_id_input.val(),//is_attach_id_value,
            'fullName' : full_name_input.val(),//full_name_value,
            'gender' : gender_input.val(),//gender_value,
            'dateBirth' : date_birth_input.val(),//date_birth_value,
            'telephone' : telephone_input.val(),//telephone_value,
            'email' : email_input.val(),//email_value,
            'insuranceCertificate' : insurance_certificate_input.val(),//insurance_certificate_value,
            'policyNumber' : policy_number_input.val(),//policy_number_value,
            'insuranceCompany' : insurance_company_id_input.val(),//insurance_company_value,
            'passportSerial' : passport_serial_input.val(),//passport_serial_value,
            'passportNumber' : passport_number_input.val(),//passport_number_value,
            'fmsDepartment' : fms_department_id_input.val(),//fms_department_value,
            'region' : region_id_input.val(),//region_value,
            'district' : district_id_input.val(),//district_value,
            'locality' : locality_id_input.val(),//locality_value,
            'street' : street_id_input.val(),//street_value,
            'houseNumber' : house_number_input.val(),//house_number_value,
            'apartment' : apartment_input.val(),//apartment_value,
            'workplace' : workplace_input.val(),//workplace_value,
            'profession' : profession_input.val(),//profession_value,
            'notation' : notation_input.val()//notation_value
        },
        cache: false
    });
    request.done(function () {
        console.log('Patient card '+ card_number_input.val() + ' updated');
        console.log('Id '+ id_input.val() + ' updated');
    });
    return id_input.val();
};

const loadPatientCardData = function (id) {
    /*let id_input = $("input[name='id']");
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
    let notation_input = $("textarea[name='notation']");*/
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
        /*let patient_card_alive_section = $('#patient-card-alive-section');
        let patient_card_attached_section = $('#patient-card-attached-section');
        let is_alive_image = $("#patient-alive-image");
        let is_attached_image = $("#patient-attached-image");*/
        /*
         * Статус по карте: жив/мертв, прикреплен/откреплен
         */
        $('#patient-alive-status').text(card_data.isAlive);
        $('#patient-attached-status').text(card_data.isAttached);

        switch (card_data.isAliveId) {
            //Если пациент жив.
            case 1 :
                patient_card_alive_section.css({'color' : '#1ad81a'});
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
                patient_card_attached_section.css({'color' : '#1ad81a'});
                is_attached_image.attr('class', 'fa fa-user-plus');
                break;
            case 2 :
                patient_card_attached_section.css({'color' : '#d80e1b'});
                is_attached_image.attr('class', 'fa fa-user-times');
                break;

        }
    })
};