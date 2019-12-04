<div id="talon-header">
    <h3 style="margin: auto">ТАЛОН АМБУЛАТОРНОГО ПАЦИЕНТА</h3>
</div>
<div id="personal-data">
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
    <div class="talon-line"></div>
</div>




