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
    loadPatientCardData();
});

const loadPatientCardData = function () {
    let request = $.ajax({
        type: "GET",
        url: "/patient-card/edit/1",
        cache: false
    });
    request.done(function (response) {
        //res = JSON.parse(response);
        console.log(response);
        alert(response.Data);
    })
};