<div id="talon-header" style="width: 100%; text-align: center;">
    <h3 style="margin: auto">ТАЛОН АМБУЛАТОРНОГО ПАЦИЕНТА</h3>
</div>
<div id="talon-data">
    <div class="talon-line" style="margin-bottom: 5px;">
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 45%">Код врача _________________</td>
                    <td style="width: 45%; text-align: right;">Номер карты: <b><?=$talonData['cardNumber']; ?></b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="talon-line">
        1. Ф.И.О <b><?=$talonData['fullName'];?></b>
        2. Пол: <b><?=$talonData['gender']; ?></b>
        3. Дата рождения: <b><?=$talonData['dateBirth']; ?></b>
    </div>
    <div class="talon-line">
        4. Паспортные данные: <b><?=$talonData['passportSerial'].' '.$talonData['passportNumber']; ?></b>
        5. Выдан: <b><?=$talonData['fmsDepartment']?></b>
    </div>
    <div class="talon-line">
        6. Свидетельство о рождении: <b><?=$talonData['birthCertificateSerial'].' '.$talonData['birthCertificateNumber']; ?></b>
        7. Выдано: <b><?=$talonData['registryOffice'];?></b>
    </div>
    <div class="talon-line">
        8. СНИЛС: <b><?=$talonData['insuranceCertificate'];?></b>
        9. Полис: <b><?=$talonData['policyNumber'];?></b>
    </div>
    <div class="talon-line">
        10. Страховая компания: <b><?=$talonData['insuranceCompany'];?></b>
        11. Код страховщика: <b><?=$talonData['insurerCode'];?></b>
    </div>
    <div class="talon-line">
        12. Категория: ___________
        13. Источник финансирования: ________
    </div>
    <div class="talon-line">
        14. Адрес: <b><?=$talonData['address']; ?></b>
    </div>
    <?php if(isset($talonData['workplace'])) : ?>
    <div class="talon-line">
        <b>15. Работает</b>
        16. Место работы: <b><?=$talonData['workplace']; ?></b>
        17. Профессия: <b><?=$talonData['profession']; ?></b>
    </div>
    <?php else :?>
        <div class="talon-line">
            <b>15. Не работает</b>
            16. Место работы: <b>отсутствует</b>
            17. Статус: <b><i>Пенсионер</i> / <i>Безработный</i></b>
        </div>
    <?php endif; ?>
    <div class="talon-line">
        18. Категория льготы: _____
        19. Цель обслуживания: ______________________________
    </div>
    <div class="talon-line">
        20. Принят на долечивание (код ЛПУ): ______________________________________________
    </div>
    <div class="talon-line">
        21. Случай обслуживания: 1 - Первичный / 2 - Повторный
        22. Экстренный: 1 - Да / 2 - Нет
    </div>
    <div class="talon-line">
        23. Дата начала: _______________________
        24. Дата закрытия: _______________________
    </div>
    <div class="talon-line">
        <table class="talon-table">
            <thead>
            <tr>
                <th style="width: 25%;">Место обслуживания</th>
                <th style="width: 50%;">Даты посещений</th>
                <th style="width: 15%;">Количество</th>
                <th style="width: 10%;">Дней</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Поликлиника</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>На дому (вызовы)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>На дому (активные)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Стациона на дому</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="talon-line">
            <table class="talon-table">
                <thead>
                <tr>
                    <th style="width:30%"></th>
                    <th style="width:15%">Код МКБ</th>
                    <th style="width: 55%;">Наименование диагноза</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Основной диагноз</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Сопутствующий диагноз</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Сопутствующий диагноз</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Сопутствующий диагноз</td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    <div class="talon-line">
        <b>25. Характер течения:</b> 1 - острое заболевание, 2 - впервые в жизни хроническое, 3 - известное ранее
        хроническое, 4 - обострение основного, 5 - обострение хранического, 6 - здоров
    </div>
    <div class="talon-line">
        <b>26. Сложность случая:</b> 1) Д1 и Д2 (здоров) 2) ДЗ - 1 (дисп.) 3) ДЗ - 2 (острый) 4) ДЗ - 3 (хронич.)
        5) ДЗ - 4 (безнадежн.)
    </div>
    <div class="talon-line">
        <b>27. Исход лечения:</b>  1 - выздоровление, 2- улучшение, 3 - без изменений, 4 - ухудшение, 5 - госпитализация,
        6 - умер, 7 - прервал лечение, 8 - поставлен на Д/У, 9 - поставлен на Д/У поздно
    </div>
    <div class="talon-line">
        <b>28. Вид травмы:</b> ________________________________________________,
    </div>
    <div class="talon-line">
        <b>29. Госпитализация:</b> _____________________________________________, плановая да - 1, нет - 2
        № направления ______________________________________, дата направления___________________
    </div>
    <div class="talon-line">
        <b>30. Больничный лист:</b> выдан ______________________ закрыт ___________________________
    </div>
    <div class="talon-line">
        <b>31. Д / учет код:</b> __________(0 - нет, 1 - взят на учет, 2 - стостоит на учете, 3 - переведен в другую гр.
        4 - снят с учета, 5 - вновь взят на учет)
    </div>
    <div class="talon-line">
        <b>32. Д / учет группа код:</b> 0 - нет, 1 - I, 2 - II, 3 - III) <b>33. Инвалидность:</b> (0 - нет, 1 - I, 2 - II, 3 - III)
        <b>34. Подтверждена гр. КЭК:</b> да / нет
    </div>
    <div class="talon-line">
        <b>35. Законченный случай:</b> да / нет
    </div>
</div>
<div id="talon-footer">
    <div class="talon-line" style="margin-top: 15px;">
        ФИО врача __________________________________ Подпись ________________________
    </div>
</div>




