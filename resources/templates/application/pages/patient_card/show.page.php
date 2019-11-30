<div class="container-fluid">
    <div class="row" style="padding: 10px">
        <div class="module-wrapper">
            <div id="patient-card-menu">
                <div class="row">
                    <div id="buttons" class="col-6 right-border"></div>
                    <div id="search" class="col-6 right-border">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-search"></i> </div>
                            </div>
                            <input type="text" class="form-control" id="card-search" name="card-search" placeholder="Поиск">
                            <div class="input-group-append">
                                <div  class="input-group-text"><b>Найдено:</b></div>
                            </div>
                            <div class="input-group-append">
                                <div class="input-group-text"><span id="patient-card-found-records" class="badge badge-dark">0</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="patient-card-body">
                <div class="row">
                    <div id="personal-data-section" class="col-3">
                        <div class="patient-card-information-section box-shadow--2dp">
                            <div class="patient-card-information-section-header">
                                <i class="fa fa-user-circle" aria-hidden="true"></i> Личные данные
                            </div>
                            <div class='patient-card-information-section-body'>
                                <div class="row">
                                    <div class="col-6">
                                        <div id="patient-card-alive-section" class="patient-card-status blocked-status">
                                            <input name="is-alive-id" value="<?=$data['card_data']->_isAliveId;?>" hidden>
                                            <i id="patient-alive-image"></i>
                                            <i id="patient-alive-status"><?=$data['card_data']->_isAlive;?></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div id="patient-card-attached-section" class="patient-card-status blocked-status">
                                            <input name="is-attach-id" value="<?=$data['card_data']->_isAttachedId;?>" hidden>
                                            <i id="patient-attached-image"></i>
                                            <i id="patient-attached-status"><?=$data['card_data']->_isAttached;?></i>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <input name="id" value="<?=$data['card_data']->_id;?>" hidden>
                                <input name="status" value="<?=$data['card_data']->_status;?>" hidden>
                                <label for="card-number">Номер карты<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="card-number" name="card-number" placeholder="Номер карты" value="<?=$data['card_data']->_cardNumber;?>" disabled>
                                </div>
                                <label  for="full-name">ФИО<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user-circle"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="full-name" name="full-name" placeholder="ФИО" value="<?=$data['card_data']->_surname.' '.$data['card_data']->_firstName.' '.$data['card_data']->_secondName;?>" disabled>
                                </div>
                                <label  for="gender">Пол:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-venus-mars"></i> </div>
                                    </div>
                                    <select id="gender" name="gender" class="custom-select" disabled>
                                        <?php foreach ($data['genders'] as $gender) :?>
                                            <option value="<?=$gender['id'];?>" <?=$data['card_data']->_gender == $gender['id'] ?' selected':''?>><?=$gender['description'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label  for="date-birth">Дата рождения<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-birthday-cake"></i> </div>
                                    </div>
                                    <input type="date" class="form-control" id="date-birth" name="date-birth" value="<?=$data['card_data']->_dateBirth;?>" disabled>
                                </div>
                                <label  for="telephone">Номер телефона:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-phone"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Номер телефона" value="<?=$data['card_data']->_telephone;?>" disabled>
                                </div>
                                <label  for="email">Электронная почта:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?=$data['card_data']->_email;?>" disabled>
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
                                    <input type="text" class="form-control" id="insurance-certificate" name="insurance-certificate" placeholder="СНИЛС" value="<?=$data['card_data']->_insuranceCertificate;?>" disabled>
                                </div>
                                <hr>
                                <label for="policy-number">Единый номер полиса<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clipboard"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="policy-number" name="policy-number" placeholder="Номер полиса" value="<?=$data['card_data']->_policyNumber;?>" disabled>
                                </div>
                                <label for="insurance-company">Страховая компания:</label>
                                <div class="input-group mb-2">
                                    <input name="insurance-company-id" value="<?=$data['card_data']->_insuranceCompanyId;?>" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clipboard"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="insurance-company" name="insurance-company" placeholder="Страховая компания" value="<?=$data['card_data']->_insuranceCompany;?>" disabled>
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
                                            <input type="text" class="form-control" id="passport" name="passport" placeholder="Серия, номер паспорта" value="<?=$data['card_data']->_passportSerial.' '.$data['card_data']->_passportNumber;?>" disabled>
                                        </div>
                                        <label for="fms-department">Отдел ФМС выдавший паспорт:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <textarea class="form-control" id="fms-department" name="fms-department" disabled><?=$data['card_data']->_fmsDepartment;?></textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="birth-certificate-panel" role="tabpanel">
                                        <label for="birth-certificate">Серия, номер свидетельства:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="birth-certificate" name="birth-certificate" placeholder="Серия, номер свидетельства" value="<?=$data['card_data']->_birthCertificateSerial.' '.$data['card_data']->_birthCertificateNumber;?>" disabled>
                                        </div>
                                        <label for="registry-office">Отдел ЗАГС выдавший свидетельство:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                            </div>
                                            <textarea class="form-control" id="registry-office" name="registry-office" disabled><?=$data['card_data']->_registryOffice;?></textarea>
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
                                    <input type="text" class="form-control" id="region" name="region" placeholder="Регион" value="<?=($data['card_data']->_region) ?: '';?>" disabled>
                                    <div id="region-search-result-area" class="search-result-area"></div>
                                </div>
                                <label for="district">Район:</label>
                                <div class="input-group mb-2">
                                    <input name="district-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="district" name="district" placeholder="Район" value="<?=($data['card_data']->_district) ?: '';?>" disabled>
                                    <div id="district-search-result-area" class="search-result-area"></div>
                                </div>
                                <label for="locality">Населенный пункт:</label>
                                <div class="input-group mb-2">
                                    <input name="locality-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="locality" name="locality" placeholder="Населенный пункт" value="<?=($data['card_data']->_locality) ?: '';?>" disabled>
                                    <div id="locality-search-result-area" class="search-result-area"></div>
                                </div>
                                <label for="street">Улица:</label>
                                <div class="input-group mb-2">
                                    <input name="street-id" hidden>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-address-book"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="street" name="street" placeholder="Улица" value="<?=($data['card_data']->_street) ?: '';?>" disabled>
                                    <div id="street-search-result-area" class="search-result-area"></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="house-number">Номер дома:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-building"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="house-number" name="house-number" value="<?=($data['card_data']->_houseNumber) ?: '';?>"disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="apartment">Номер квартиры:</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-building"></i> </div>
                                            </div>
                                            <input type="text" class="form-control" id="apartment" name="apartment" value="<?=($data['card_data']->_apartment) ?: '';?>" disabled>
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
                                    <input type="text" class="form-control" id="workplace" name="workplace" placeholder="Место работы" value="<?=($data['card_data']->_workPlace) ?: '';?>" disabled>
                                </div>
                                <label for="profession">Профессия:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-info-circle"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="profession" name="profession" placeholder="Место работы" value="<?=($data['card_data']->_profession) ?: '';?>" disabled>
                                </div>
                                <hr>
                                <label for="notation">Примечание:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-info-circle"></i> </div>
                                    </div>
                                    <textarea class="form-control" id="notation" name="notation" disabled><?=($data['card_data']->_notation) ?: '';?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modals">
                <div class="modal fade" id="addPatientCardModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPatientCardTitle"><i class="fa fa-plus-circle"></i> Добавление нового пациента</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="patient-card-information-section-header">
                                    <i class="fa fa-user-circle" aria-hidden="true"></i> Личные данные
                                </div>
                                <label for="add-card-number">Номер карты<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="add-card-number" name="add-card-number" placeholder="Номер карты" required>
                                </div>
                                <label  for="add-full-name">ФИО<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user-circle"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="add-full-name" name="add-full-name" placeholder="ФИО" required>
                                </div>
                                <label  for="add-gender">Пол<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-venus-mars"></i> </div>
                                    </div>
                                    <select id="add-gender" name="add-gender" class="custom-select">
                                        <option value="1">Мужчина</option>
                                        <option value="2">Женщина</option>
                                    </select>
                                </div>
                                <label  for="add-date-birth">Дата рождения<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-birthday-cake"></i> </div>
                                    </div>
                                    <input type="date" class="form-control" id="add-date-birth" name="add-date-birth">
                                </div>
                                <div class="patient-card-information-section-header">
                                    <i class="fa fa-folder" aria-hidden="true"></i> Документы
                                </div>
                                <label for="add-insurance-certificate">СНИЛС<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-id-card"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="add-insurance-certificate" name="add-insurance-certificate" placeholder="СНИЛС" required>
                                </div>
                                <label for="add-policy-number">Единый номер полиса<span class="red-asterisk">*</span>:</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-clipboard"></i> </div>
                                    </div>
                                    <input type="text" class="form-control" id="add-policy-number" name="add-policy-number" placeholder="Номер полиса" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="add-card-button" class="btn btn-primary btn-sm">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="/resources/templates/application/layout/js/patient.card.js"></script>


