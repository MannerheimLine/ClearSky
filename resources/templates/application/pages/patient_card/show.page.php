<div class="container-fluid">
    <div class="row" style="padding: 10px">
        <div class="module-wrapper">
            <div class="patient-card-menu">
                <button class="btn btn-primary">Кнопка</button>
                <button class="btn btn-primary">Кнопка</button>
            </div>
            <div class="patient-card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-user-circle" aria-hidden="true"></i> Личные данные
                            </div>
                            <div class='patient-card-information-section-body'>
                                <div class="patient-card-status">
                                    <i class="fa fa-male"></i>
                                </div>
                                <hr>
                                <p><?=$data->getId();?></p>
                                <p><?=$data->getCardNumber();?></p>
                                <p><?=$data->getSurname();?></p>
                                <p><?=$data->getFirstName();?></p>
                                <p><?=$data->getSecondName();?></p>
                                <p><?=$data->getGender();?></p>
                                <p><?=$data->getDateBirth();?></p>
                                <p><?=$data->getTelephone();?></p>
                                <p><?=$data->getEmail();?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-folder" aria-hidden="true"></i> Документы
                            </div>
                            <div class='patient-card-information-section-body'>
                                <p><?=$data->getInsuranceCertificate();?></p>
                                <p><?=$data->getPolicyNumber();?></p>
                                <p><?=$data->getInsuranceCompany();?></p>
                                <p><?=$data->getPassportSerial();?></p>
                                <p><?=$data->getPassportNumber();?></p>
                                <p><?=$data->getFmsDepartment();?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-address-book" aria-hidden="true"></i> Адреса
                            </div>
                            <div class='patient-card-information-section-body'>
                                <p><?=$data->getRegion();?></p>
                                <p><?=$data->getDistrict();?></p>
                                <p><?=$data->getLocality();?></p>
                                <p><?=$data->getStreet();?></p>
                                <p><?=$data->getHouseNumber();?></p>
                                <p><?=$data->getApartment();?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-info-circle" aria-hidden="true"></i> Дополнительно
                            </div>
                            <div class='patient-card-information-section-body'>
                                <p><?=$data->getWorkplace();?></p>
                                <p><?=$data->getProfession();?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


