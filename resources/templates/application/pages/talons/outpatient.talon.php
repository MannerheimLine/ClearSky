<div id="talon-header">
    <h3 style="margin: auto">ТАЛОН АМБУЛАТОРНОГО ПАЦИЕНТА</h3>
</div>
<div id="personal-data">
    <div class="talon-line">
        Код врача _________________
    </div>
    <div class="talon-line">
        <b>1. Номер карты:</b> <?=$talonData['cardNumber']; ?>
        <b>2. Ф.И.О</b> <?=$talonData['fullName'];?>
    </div>
    <div class="talon-line">
        <b>3. Пол:</b> <?=$talonData['gender']; ?>
        <b>4. Дата рождения:</b> <?=$talonData['dateBirth']; ?>
    </div>
    <div class="talon-line">
        <b>5. Паспортные данные:</b> <?=$talonData['passportSerial'].' '.$talonData['passportNumber']; ?>
        <b>6. Выдан:</b> <?=$talonData['fmsDepartment']?>
    </div>
    <div class="talon-line">
        <b>7. Свидетельство о рождении:</b> <?=$talonData['birthCertificateSerial'].' '.$talonData['birthCertificateNumber']; ?>
        <b>8. Выдано:</b> <?=$talonData['registryOffice'];?>
    </div>
    <div class="talon-line">
        <b>9. СНИЛС:</b> <?=$talonData['insuranceCertificate'];?>
        <b>10. Полис:</b> <?=$talonData['policyNumber'];?>
    </div>
    <div class="talon-line">
        <b>11. Страховая компания:</b> <?=$talonData['insuranceCompany'];?>
        <b>12. Код страховщика:</b> <?=$talonData['insurerCode'];?>
    </div>
    <div class="talon-line">
        <b>13. Категория:</b> ___________
        <b>14. Источник финансирования:</b> ________
    </div>
    <div class="talon-line">
        <b>15. Адрес:</b>  <?=$talonData['address']; ?>
    </div>
    <?php if(isset($talonData['workplace'])) : ?>
    <div class="talon-line">
        <b>16. Работает</b>
        <b>17. Место работы:</b> <?=$talonData['workplace']; ?>
        <b>18. Профессия:</b> <?=$talonData['profession']; ?>
    </div>
    <?php else :?>
        <div class="talon-line">
            <b>16. Не работает</b>
            <b>17. Место работы:</b> отсутствует
            <b>18. Статус:</b> <i>Пенсионер</i> / <i>Безработный</i>
        </div>
    <?php endif; ?>
    <div class="talon-line">
        <b>19. Категория льготы:</b> _____
        <b>20. Цель обслуживания:</b> ______________________________
    </div>
    <div class="talon-line">
        <b>21. Принят на долечивание (код ЛПУ):</b> ______________________________________________

    </div>
    <div class="talon-line">
        <b>22. Случай обслуживания:</b> 1 - Первичный / 2 - Повторный
        <b>23. Экстра:</b> 1 - Да / 2 - Нет
    <div class="talon-line">
        <b>24. Дата начала:</b> _______________________
        <b>25. Дата закрытия:</b> _______________________
    </div>
    <div class="talon-line">
        <table cellpadding="1" cellspacing="1" border="1">
            <thead>
            <tr>
                <th>Место обслуживания</th>
                <th>Даты посещений</th>
                <th>Количество посещений</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Поликлиника</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>На дому (вызовы)</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>На дому (активные)</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Стациона на дому</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
        <div class="talon-line">
            <table cellpadding="1" cellspacing="1" border="1">
                <thead>
                <tr>
                    <th></th>
                    <th>Код МКБ</th>
                    <th>Наименование диагноза</th>
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
        <b>26. Характер течения:</b> 1 - острое заболевание, 2 - впервые в жизни хроническое, 3 - известное ранее
        хроническое, 4 - обострение основного, 5 - обострение хранического, 6 - здоров
    </div>
    <div class="talon-line">
        <b>27. Сложность случая:</b> 1) Д1 и Д2 (здоров) 2) ДЗ - 1 (дисп.) 3) ДЗ - 2 (остр.) 4) ДЗ - 3 (хрон.)
        5) ДЗ - 4 (безнадежн.)
    </div>
    <div class="talon-line">
        <b>28. Исход лечения:</b>  1 - выздоровление, 2- улучшение, 3 - без изменений, 4 - ухудшение, 5 - госпитализация,
        6 - умер, 7 - прервал лечение, 8 - поставлен на Д/У, 9 - поставлен на Д/У поздно
    </div>
    <div class="talon-line">
        <b>29. Вид травмы:</b> _______________________,
    </div>
    <div class="talon-line">
        <b>30. Госпитализация:</b> _____________________________________________, плановая да - 1, нет - 2
        № направления ______________________________________, дата направления___________________
    </div>
    <div class="talon-line">
        <b>31. Больничный лист:</b> выдан ______________________ закрыт ___________________________
    </div>
    <div class="talon-line">
        <b>32. Д / учет код:</b> __________(0 - нет, 1 - взят на учет, 2 - стостоит на учете, 3 - переведен в другую гр.
        4 - снят с учета, 5 - вновь взят на учет)
    </div>
    <div class="talon-line">
        <b>33. Д / учет группа код:</b> 0 - нет, 1 - I, 2 - II, 3 - III) <b>34. Инвалидность:</b> (0 - нет, 1 - I, 2 - II, 3 - III)
        <b>35. Подтверждена гр. КЭК:</b> да / нет
    </div>
    <div class="talon-line">
        <b>36. Законченный случай:</b> да / нет
    </div>
    <div class="talon-line" style="margin-top: 30px;">
        Подпись врача _____________________________
    </div>
</div>




