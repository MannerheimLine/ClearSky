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

$(function () {
    loadPatientCardData(1);
});

const loadPatientCardData = function (id) {
    let id_input = $("input[name='id']");
    let card_number_input = $("input[name='card-number']");
    let full_name_input = $("input[name='full-name']");
    let gender_input = $("select[name='gender']");
    let date_birth_input = $("input[name='date-birth']");
    let telephone_input = $("input[name='telephone']");
    let email_input = $("input[name='email']");
    let insurance_certificate_input = $("input[name='insurance-certificate']");
    let policy_number_input = $("input[name='policy-number']");
    let insurance_company_input = $("input[name='insurance-company']");
    let passport_serial_input = $("input[name='passport-serial']");
    let passport_number_input = $("input[name='passport-number']");
    let fms_department_input = $("textarea[name='fms-department']");
    let region_input = $("input[name='region']");
    let district_input = $("input[name='district']");
    let locality_input = $("input[name='locality']");
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
        full_name_input.val(card_data.surname + ' ' + card_data.firstName + ' ' + card_data.secondName);
        $.each(response.genders, function (key, value) {
            gender_input.append(`<option value="${value.id}" ${card_data.genderId == value.id ?' selected':''}>${value.description}</option>`)
        });
        date_birth_input.val(card_data.dateBirth);
        telephone_input.val(card_data.telephone);
        email_input.val(card_data.email);
        insurance_certificate_input.val(card_data.insuranceCertificate);
        policy_number_input.val(card_data.policyNumber);
        insurance_company_input.val(card_data.insuranceCompany);
        passport_serial_input.val(card_data.passportSerial);
        passport_number_input.val(card_data.passportNumber);
        fms_department_input.val(card_data.fmsDepartment);
        region_input .val(card_data.region);
        district_input.val(card_data.district);
        locality_input.val(card_data.locality);
        street_input.val(card_data.street);
        house_number_input.val(card_data.houseNumber);
        apartment_input.val(card_data.apartment);
        workplace_input.val(card_data.workplace);
        profession_input.val(card_data.profession);
        notation_input.val(card_data.notation);
    })
};
