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
    $(".patient-card-body :input").change(function() {updatePatientCardData()});
});

const updatePatientCardData = function () {
    let id_value = $("input[name='id']").val();
    let card_number_value = $("input[name='card-number']").val();
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
    });
    //alert('Save Button is active now');
};

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
    })
};
