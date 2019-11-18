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
            <div id="patient-card-body"></div>
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



