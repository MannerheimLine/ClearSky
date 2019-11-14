<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Card\Domains;


use Application\Base\AppDomain;
use DateTime;
use Engine\Database\Connectors\ConnectorInterface;
use Engine\DataStructures\StructuredResponse;

class PatientCard extends AppDomain implements \JsonSerializable
{
    const MAN = 1;
    const WOMAN = 2;
    const CHILD = 3;
    private $_dbConnection;
    private $_id;
    private $_cardNumber;
    private $_isAliveId;
    private $_isAlive;
    private $_isAttachedId;
    private $_isAttached;
    private $_humanType;
    private $_surname;
    private $_firstName;
    private $_secondName;
    private $_genderId;
    private $_gender;
    private $_dateBirth;
    private $_telephone;
    private $_email;
    private $_policyNumber;
    private $_insuranceCompanyId;
    private $_insuranceCompany;
    private $_insuranceCertificate;
    private $_passportSerial;
    private $_passportNumber;
    private $_fmsDepartment;
    private $_birthCertificateSerial;
    private $_birthCertificateNumber;
    private $_registryOffice;
    private $_regionId;
    private $_region;
    private $_districtId;
    private $_district;
    private $_localityId;
    private $_locality;
    private $_streetId;
    private $_street;
    private $_houseNumber;
    private $_apartment;
    private $_workPlace;
    private $_profession;
    private $_notation;

    /**
     * patient_card constructor.
     * @param ConnectorInterface $dbConnector
     */
    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    /**
     * @param array $updatingData
     * @return array
     */
    private function prepareUpdatingData(array $updatingData) : array {
        $castedData['id'] = (int)$updatingData['id'];
        $castedData['cardNumber'] = $updatingData['cardNumber'];
        $castedData['isAlive'] = (int)$updatingData['isAlive'];
        $castedData['isAttach'] = (int)$updatingData['isAttach'];
        $fullName = explode(' ', rtrim($updatingData['fullName']));
        $castedData['surname'] = $fullName[0];
        $castedData['firstName'] = $fullName[1];
        $castedData['secondName'] = $fullName[2];
        $castedData['gender'] = (int)$updatingData['gender'];
        $castedData['dateBirth'] = $updatingData['dateBirth'];
        $castedData['telephone'] = $updatingData['telephone'];
        $castedData['email'] = $updatingData['email'];
        $castedData['insuranceCertificate'] = $updatingData['insuranceCertificate'] ?: null;
        $castedData['policyNumber'] = $updatingData['policyNumber'];
        $castedData['insuranceCompany'] = (int)$updatingData['insuranceCompany'];
        $passport = explode(' ',$updatingData['passport']);
        $castedData['passportSerial'] = $passport[0] ?: null;
        $castedData['passportNumber'] = $passport[1] ?: null;
        $castedData['fmsDepartment'] = $updatingData['fmsDepartment'];
        $birthCertificate = explode(' ', $updatingData['birthCertificate']);
        $castedData['birthCertificateSerial'] = $birthCertificate[0] ?: null;
        $castedData['birthCertificateNumber'] = $birthCertificate[1] ?: null;
        $castedData['registryOffice'] = $updatingData['registryOffice'];
        $castedData['region'] = (int)$updatingData['region'] ?: null;
        $castedData['district'] = (int)$updatingData['district'] ?: null;
        $castedData['locality'] = (int)$updatingData['locality'] ?: null;
        $castedData['street'] = (int)$updatingData['street'] ?: null;
        $castedData['houseNumber'] = $updatingData['houseNumber'];
        $castedData['apartment'] = $updatingData['apartment'];
        $castedData['workplace'] = $updatingData['workplace'];
        $castedData['profession'] = $updatingData['profession'];
        $castedData['notation'] = $updatingData['notation'];
        return $castedData;
    }

    private function prepareAddingData(array $addingData){
        $castedData['cardNumber'] = $this->sanitize($addingData['cardNumber']);
        $fullName = explode(' ',$addingData['fullName']);
        $castedData['surname'] = $this->sanitize($fullName[0]);
        $castedData['firstName'] = $this->sanitize($fullName[1]);
        $castedData['secondName'] = $this->sanitize($fullName[2]);
        $castedData['gender'] = $this->sanitize($addingData['gender']);
        $castedData['dateBirth'] = $this->sanitize($addingData['dateBirth']);
        $castedData['insurance'] = $this->sanitize($addingData['insurance']);
        $castedData['policyNumber'] = $this->sanitize($addingData['policyNumber']);
        return $castedData;
    }

    private function getHumanType() : int {
        $today = new DateTime();
        $dateBirth = DateTime::createFromFormat("Y-m-d H:i", $this->_dateBirth.' 00:00');
        $difference = $today->diff($dateBirth);
        if ($difference->y >= 18 ){
            switch ($this->_genderId){
                case 1 : return self::MAN; break;
                case 2 : return self::WOMAN; break;
            }
        }else{
            return self::CHILD;
        }
    }

    /**
     * Вернет одно из трех состояний:
     * - owner - нажал кнопку редактирования тот кто карту заблокировал (если вдруг произойдет сбой, то карту может разблокировтаь тот кто ее блокировал)
     * - other - карту редактирует, кто то другой
     * - free - карта не реадктируется, готова к редактированию
     *
     * @param int $patient_card_id
     * @return string
     */
    private function getEditStatus(int $patient_card_id) : string {
        $query = ("SELECT * FROM `being_edited_patient_cards` WHERE `patient_card_id` = :patient_card_id");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'patient_card_id' => $patient_card_id
        ]);
        if ($result->rowCount() > 0){
            $data = $result->fetch();
            if ($data['user_account'] === 1){ //Пользовтаель (id) должен браться из сессии
                $result = 'owner';
            }else{
                $result = 'other';
            }
        }else{
            $result = 'free';
        }
        return $result;
    }

    private function setOnEdit(int $patient_card_id, $user = 1) : bool {
        $query = ("INSERT INTO `being_edited_patient_cards` (`patient_card_id`, `user_account`) VALUES (:patient_card_id, :user_account)");
        $result = $this->_dbConnection->prepare($query);
        if ($result->execute([
            'patient_card_id' => $patient_card_id,
            'user_account' => $user
        ])){
            return true;
        }
        return false;
    }

    private function setEditable(int $patient_card_id) : bool {
        $query = ("DELETE FROM `being_edited_patient_cards` WHERE `patient_card_id` = :patient_card_id");
        $result = $this->_dbConnection->prepare($query);
        if ($result->execute([
            'patient_card_id' => $patient_card_id
        ])){
            return true;
        }
        return false;
    }

    /**
     * @return PatientCard
     */
    public function get($id) : PatientCard {
        $query = ("SELECT 
        `patient_cards`.`id`,
        `patient_cards`.`card_number` as `card_number`,
        `patient_cards`.`is_alive` as `is_alive_id`,
        `alive_status`.`is_alive` as `is_alive`,
        `patient_cards`.`is_attached` as `is_attached_id`,
        `attach_status`.`is_attached` as `is_attached`,
        `patient_cards`.`surname` as `surname`,
        `patient_cards`.`firstname` as `firstname`,
        `patient_cards`.`secondname` as `secondname`,
        `patient_cards`.`gender` as `gender_id`,
        `gender`.`description` as `gender`,
        `patient_cards`.`date_birth` as `date_birth`,
        `patient_cards`.`telephone_number` as `telephone_number`,
        `patient_cards`.`email` as `email`,
        `patient_cards`.`insurance_certificate` as `insurance`,
        `patient_cards`.`policy_number` as `policy_number`,
        `patient_cards`.`insurance_company` as `insurance_company_id`,
        `insurance_companies`.`insurance_company_name` as `insurance_company`,
        `patient_cards`.`passport_serial` as `passport_serial`,
        `patient_cards`.`passport_number` as `passport_number`,
        `patient_cards`.`fms_department` as `fms_department`,
        `patient_cards`.`birth_certificate_serial` as `birth_certificate_serial`,
        `patient_cards`.`birth_certificate_number` as `birth_certificate_number`,
        `patient_cards`.`registry_office` as `registry_office`,
        `patient_cards`.`region` as `region_id`,
        `regions`.`region_name` as `region`,
        `patient_cards`.`district` as `district_id`,
        `districts`.`district_name` as `district`,
        `patient_cards`.`locality` as `locality_id`,
        `localities`.`locality_name` as `locality`,
        `patient_cards`.`street` as `street_id`,
        `streets`.`street_name` as `street`,
        `patient_cards`.`house_number` as `house_number`,
        `patient_cards`.`apartment` as `apartment`,
        `patient_cards`.`work_place` as `work_place`,
        `patient_cards`.`profession` as `profession`,
        `patient_cards`.`notation` as `notation`
        FROM `patient_cards` 
        LEFT JOIN `gender` ON `patient_cards`.`gender` = `gender`.`id` 
        LEFT JOIN `regions` ON `patient_cards`.`region` = `regions`.`id` 
        LEFT JOIN `districts` ON `patient_cards`.`district` = `districts`.`id` 
        LEFT JOIN `localities` ON `patient_cards`.`locality` = `localities`.`id` 
        LEFT JOIN `insurance_companies` ON `patient_cards`.`insurance_company` = `insurance_companies`.`id` 
        LEFT JOIN `streets` ON `patient_cards`.`street` = `streets`.`id` 
        LEFT JOIN `alive_status` ON `patient_cards`.`is_alive` = `alive_status`.`id` 
        LEFT JOIN `attach_status` ON `patient_cards`.`is_attached` = `attach_status`.`id` 
        WHERE `patient_cards`.`id` = :id");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'id' => $id
        ]);
        if ($result->rowCount() > 0){
            while ($row = $result->fetch()){
                $this->_id = $row['id'];
                $this->_cardNumber = $row['card_number'];
                $this->_isAliveId = $row['is_alive_id'];
                $this->_isAlive = $row['is_alive'];
                $this->_isAttachedId = $row['is_attached_id'];
                $this->_isAttached = $row['is_attached'];
                $this->_surname = $row['surname'];
                $this->_firstName = $row['firstname'];
                $this->_secondName = $row['secondname'];
                $this->_genderId = $row['gender_id'];
                $this->_gender = $row['gender'];
                $this->_dateBirth = $row['date_birth'];
                $this->_telephone = $row['telephone_number'];
                $this->_email = $row['email'];
                $this->_insuranceCertificate = $row['insurance'];
                $this->_policyNumber = $row['policy_number'];
                $this->_insuranceCompanyId = $row['insurance_company_id'];
                $this->_insuranceCompany = $row['insurance_company'];
                $this->_passportSerial = $row['passport_serial'];
                $this->_passportNumber = $row['passport_number'];
                $this->_fmsDepartment = $row['fms_department'];
                $this->_birthCertificateSerial = $row['birth_certificate_serial'];
                $this->_birthCertificateNumber = $row['birth_certificate_number'];
                $this->_registryOffice = $row['registry_office'];
                $this->_regionId = $row['region_id'];
                $this->_region = $row['region'];
                $this->_districtId = $row['district_id'];
                $this->_district = $row['district'];
                $this->_localityId = $row['locality_id'];
                $this->_locality = $row['locality'];
                $this->_streetId = $row['street_id'];
                $this->_street = $row['street'];
                $this->_houseNumber = $row['house_number'];
                $this->_apartment = $row['apartment'];
                $this->_workPlace = $row['work_place'];
                $this->_profession = $row['profession'];
                $this->_notation = $row['notation'];
            }
            $this->_humanType = $this->getHumanType();
        }
        return $this;
    }

    public function update(array $updatingData) : StructuredResponse {
        try{
            $castedData = $this->prepareUpdatingData($updatingData);
            $query = ("UPDATE `patient_cards` 
        SET 
            `card_number` = :cardNumber,
            `is_alive` = :isAlive,
            `is_attached` = :isAttach,
            `surname` = :surname,
            `firstname` = :firstName,
            `secondname` = :secondName,
            `gender` = :gender,
            `date_birth` = :dateBirth,
            `telephone_number` = :telephoneNumber,
            `email` = :email,
            `policy_number` = :policyNumber,
            `insurance_company` = :insuranceCompany,
            `insurance_certificate` = :insuranceCertificate,
            `passport_serial` = :passportSerial,
            `passport_number` = :passportNumber,
            `fms_department` = :fmsDepartment,
            `birth_certificate_serial` = :birthCertificateSerial,
            `birth_certificate_number` = :birthCertificateNumber,
            `registry_office` = :registryOffice,
            `region` = :region,
            `district` = :district,
            `locality` = :locality,
            `street` = :street,
            `house_number` = :houseNumber,
            `apartment` = :apartment,
            `work_place` = :workPlace,
            `profession` = :profession,
            `notation` = :notation
        WHERE `patient_cards`.`id` = :id;");
            $result = $this->_dbConnection->prepare($query);
            if($result->execute([
                'id' => $castedData['id'],
                'isAlive' => $castedData['isAlive'],
                'isAttach' => $castedData['isAttach'],
                'cardNumber' => $castedData['cardNumber'],
                'surname' => $castedData['surname'],
                'firstName' => $castedData['firstName'],
                'secondName' => $castedData['secondName'],
                'gender' => $castedData['gender'],
                'dateBirth' => $castedData['dateBirth'],
                'telephoneNumber' => $castedData['telephone'],
                'email' => $castedData['email'],
                'policyNumber' => $castedData['policyNumber'],
                'insuranceCompany' => $castedData['insuranceCompany'],
                'insuranceCertificate' => $castedData['insuranceCertificate'],
                'passportSerial' => $castedData['passportSerial'],
                'passportNumber' => $castedData['passportNumber'],
                'fmsDepartment' => $castedData['fmsDepartment'],
                'birthCertificateSerial' => $castedData['birthCertificateSerial'],
                'birthCertificateNumber' => $castedData['birthCertificateNumber'],
                'registryOffice' => $castedData['registryOffice'],
                'region' => $castedData['region'],
                'district' => $castedData['district'],
                'locality' => $castedData['locality'],
                'street' => $castedData['street'],
                'houseNumber' => $castedData['houseNumber'],
                'apartment' => $castedData['apartment'],
                'workPlace' => $castedData['workplace'],
                'profession' => $castedData['profession'],
                'notation' => $castedData['notation'],
            ])){
                $this->setEditable($castedData['id']);
                $response = new StructuredResponse();
                $message = $response->message('success', 'Обновлено');
                $response->success()->complete('message', $message);
            }
            return $response;
        }catch (\Exception $e){
            /**
             * Пока что я не отслеживаю ошибку по коду и не разбираю варианты действий через switch, case
             * Я знаю пока о существовании всего одной ошибки на дублирование записи "on duplicate key"
             * Ее я и обрабатываю
             */
            $response = new StructuredResponse();
            $response->failed();
            $errorInfo = $result->errorInfo(); //[23000, 1062, "Duplicate entry ..."]
            if (preg_match_all('/\'([^\']+)+\'/', $errorInfo[2], $matches)) {
                $fields = ['policy-number' => 'полисом', 'insurance-certificate' => 'СНИЛС'];
                $match =  $matches[1];
                $field = str_replace('_', '-', $match[1]);
                $fieldValue = $match[0];
                $message = $response->message('fail', "Карта с таким $fields[$field] уже существует");
            }
            $response->incomplete(
                'errors', ['message' => $message,
                'field' => $field,
                'fieldValue' => $fieldValue,
                'errorType' => 'Duplicate Key Entrance']);
            return $response;
        }
    }

    public function edit($patient_card_id) : StructuredResponse {
        $id = (int) $patient_card_id;
        $response = new StructuredResponse();
        /**
         * Получаю статус карты, кем редактируется или свободна и формирую ответ
         */
        switch ($this->getEditStatus($id)){
            case 'owner' :
                $response->success();
                $message = $response->message('success', 'Начато редактирование карты');
                $response->complete('content', ['message' => $message, 'cardId' => $id]);
                break;
            case 'other' :
                $response->failed();
                $message = $response->message('fail', 'Карта редактируется другим пользователем');
                $response->incomplete('errors', ['message' => $message, 'cardId' => $id]);
                break;
            default : //free
                $this->setOnEdit($id);
                $response->success();
                $message = $response->message('success', 'Начато редактирование карты');
                $response->complete('content', ['message' => $message, 'cardId' => $id]);
                break;
        }
        return $response;
    }

    public function add(array $addingData) : string {
        $castedData = $this->prepareAddingData($addingData);
        $query = ("INSERT INTO `patient_cards` 
        (`card_number`,  
         `surname`, 
         `firstname`, 
         `secondname`, 
         `gender`, 
         `date_birth`, 
         `insurance_certificate`, 
         `policy_number`) 
         VALUES (
        :cardNumber,
        :surname,
        :firstName,
        :secondName,
        :gender,
        :dateBirth,
        :insurance,
        :policyNumber)");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'cardNumber' => $castedData['cardNumber'],
            'surname' => $castedData['surname'],
            'firstName' => $castedData['firstName'],
            'secondName' => $castedData['secondName'],
            'gender' => $castedData['gender'],
            'dateBirth' => $castedData['dateBirth'],
            'insurance' => $castedData['insurance'],
            'policyNumber' => $castedData['policyNumber']
        ]);
        if ($result){
            return $this->_dbConnection->lastInsertId();
        }
    }

    public function delete($id){

    }

    /**
     * @return array
     */
    public function getGenders() : array {
        $query = ("SELECT * FROM `gender`");
        $result = $this->_dbConnection->prepare($query);
        $result->execute();
        return $result->fetchAll();
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->_id,
            'cardNumber' => $this->_cardNumber,
            'isAliveId' => $this->_isAliveId,
            'isAlive' => $this->_isAlive,
            'isAttachId' => $this->_isAttachedId,
            'isAttached' => $this->_isAttached,
            'humanType' => $this->_humanType,
            'surname' => $this->_surname,
            'firstName' => $this->_firstName,
            'secondName' => $this->_secondName,
            'genderId' => $this->_genderId,
            'gender' => $this->_gender,
            'dateBirth' => $this->_dateBirth,
            'telephone' => $this->_telephone,
            'email' => $this->_email,
            'policyNumber' => $this->_policyNumber,
            'insuranceCompanyId' => $this->_insuranceCompanyId,
            'insuranceCompany' => $this->_insuranceCompany,
            'insuranceCertificate' => $this->_insuranceCertificate,
            'passportSerial' => $this->_passportSerial,
            'passportNumber' => $this->_passportNumber,
            'fmsDepartment' => $this->_fmsDepartment,
            'birthCertificateSerial' => $this->_birthCertificateSerial,
            'birthCertificateNumber' => $this->_birthCertificateNumber,
            'registryOffice' => $this->_registryOffice,
            'regionId' => $this->_regionId,
            'region' => $this->_region,
            'districtId' => $this->_districtId,
            'district' => $this->_district,
            'localityId' => $this->_localityId,
            'locality' => $this->_locality,
            'streetId' => $this->_streetId,
            'street' => $this->_street,
            'houseNumber' => $this->_houseNumber,
            'apartment' => $this->_apartment,
            'workPlace' => $this->_workPlace,
            'profession' => $this->_profession,
            'notation' => $this->_notation
        ];
    }

}
