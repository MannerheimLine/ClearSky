<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Domains;


use Application\Base\AppDomain;
use Engine\Database\Connectors\ConnectorInterface;

class PatientCard extends AppDomain implements \JsonSerializable
{
    private $_dbConnection;
    private $_id;
    private $_cardNumber;
    private $_isAliveId;
    private $_isAlive;
    private $_isAttachedId;
    private $_isAttached;
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
    private $_fmsDepartmentId;
    private $_fmsDepartment;
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
        $fullName = explode(' ',$updatingData['fullName']);
        $castedData['surname'] = $fullName[0];
        $castedData['firstName'] = $fullName[1];
        $castedData['secondName'] = $fullName[2];
        $castedData['gender'] = (int)$updatingData['gender'];
        $castedData['dateBirth'] = $updatingData['dateBirth'];
        $castedData['telephone'] = $updatingData['telephone'];
        $castedData['email'] = $updatingData['email'];
        $castedData['insuranceCertificate'] = $updatingData['insuranceCertificate'];
        $castedData['policyNumber'] = $updatingData['policyNumber'];
        $castedData['insuranceCompany'] = (int)$updatingData['insuranceCompany'];
        $castedData['passportSerial'] = $updatingData['passportSerial'];
        $castedData['passportNumber'] = $updatingData['passportNumber'];
        $castedData['fmsDepartment'] = (int)$updatingData['fmsDepartment'];
        $castedData['region'] = (int)$updatingData['region'];
        $castedData['district'] = (int)$updatingData['district'];
        $castedData['locality'] = (int)$updatingData['locality'];
        $castedData['street'] = (int)$updatingData['street'];
        $castedData['houseNumber'] = $updatingData['houseNumber'];
        $castedData['apartment'] = $updatingData['apartment'];
        $castedData['workplace'] = $updatingData['workplace'];
        $castedData['profession'] = $updatingData['profession'];
        $castedData['notation'] = $updatingData['notation'];
        return $castedData;
    }

    /**
     * @return PatientCard
     */
    public function getCardData($id) : PatientCard {
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
        `patient_cards`.`insurance` as `insurance`,
        `patient_cards`.`policy_number` as `policy_number`,
        `patient_cards`.`insurance_company` as `insurance_company_id`,
        `insurance_companies`.`insurance_name` as `insurance_company`,
        `patient_cards`.`passport_serial` as `passport_serial`,
        `patient_cards`.`passport_number` as `passport_number`,
        `patient_cards`.`fms_department` as `fms_department_id`,
        `fms_departments`.`fms_department_name` as `fms_department`,
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
        LEFT JOIN `fms_departments` ON `patient_cards`.`fms_department` = `fms_departments`.`id` 
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
                $this->_fmsDepartmentId = $row['fms_department_id'];
                $this->_fmsDepartment = $row['fms_department'];
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
        }
        return $this;
    }

    public function updateCardData(array $updatingData){
        $castedData = $this->prepareUpdatingData($updatingData);
        $query = ("UPDATE `patient_cards` 
        SET 
            `card_number` = :cardNumber,
            `surname` = :surname,
            `firstname` = :firstName,
            `secondname` = :secondName,
            `gender` = :gender,
            `date_birth` = :dateBirth,
            `telephone_number` = :telephoneNumber,
            `email` = :email,
            `policy_number` = :policyNumber,
            `insurance_company` = :insuranceCompany,
            `insurance` = :insuranceCertificate,
            `passport_serial` = :passportSerial,
            `passport_number` = :passportNumber,
            `fms_department` = :fmsDepartment,
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
            return 'Updated';
        }
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
            'isAttacheId' => $this->_isAttachedId,
            'isAttached' => $this->_isAttached,
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
            'fmsDepartmentId' => $this->_fmsDepartmentId,
            'fmsDepartment' => $this->_fmsDepartment,
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

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getCardNumber() : string
    {
        return $this->_cardNumber;
    }

    /**
     * @return mixed
     */
    public function getIsAlive() : int
    {
        return $this->_isAlive;
    }

    /**
     * @return mixed
     */
    public function getIsAttached() : int
    {
        return $this->_isAttached;
    }

    /**
     * @return string
     */
    public function getSurname() : string
    {
        return $this->_surname;
    }

    /**
     * @return string
     */
    public function getFirstName() : string
    {
        return $this->_firstName;
    }

    /**
     * @return string
     */
    public function getSecondName() : string
    {
        return $this->_secondName ?: '';
    }

    /**
     * @return int
     */
    public function getGenderId() : int
    {
        return $this->_genderId;
    }

    /**
     * @return string
     */
    public function getGender() : string
    {
        return $this->_gender;
    }

    /**
     * @return string
     */
    public function getDateBirth() : string
    {
        return $this->_dateBirth ?: '';
    }

    /**
     * @return mixed
     */
    public function getTelephone() : string
    {
        return $this->_telephone ?: '';
    }

    /**
     * @return mixed
     */
    public function getEmail() : string
    {
        return $this->_email ?: '';
    }

    /**
     * @return string
     */
    public function getPolicyNumber() : string
    {
        return $this->_policyNumber;
    }

    /**
     * @return mixed
     */
    public function getInsuranceCompany() : string
    {
        return $this->_insuranceCompany ?: '';
    }

    /**
     * @return string
     */
    public function getInsuranceCertificate() : string
    {
        return $this->_insuranceCertificate ?: '';
    }

    /**
     * @return string
     */
    public function getPassportSerial() : string
    {
        return $this->_passportSerial ?: '';
    }

    /**
     * @return string
     */
    public function getPassportNumber() : string
    {
        return $this->_passportNumber ?: '';
    }

    /**
     * @return mixed
     */
    public function getFmsDepartment() : string
    {
        return $this->_fmsDepartment ?: '';
    }

    /**
     * @return string
     */
    public function getRegion() : string
    {
        return $this->_region;
    }

    /**
     * @return string
     */
    public function getDistrict() : string
    {
        return $this->_district;
    }

    /**
     * @return string
     */
    public function getLocality() : string
    {
        return $this->_locality ?: '';
    }

    /**
     * @return string
     */
    public function getStreet() : string
    {
        return $this->_street ?: '';
    }

    /**
     * @return string
     */
    public function getHouseNumber() : string
    {
        return $this->_houseNumber ?: '';
    }

    /**
     * @return string
     */
    public function getApartment() : string
    {
        return $this->_apartment ?: '';
    }

    /**
     * @return string
     */
    public function getWorkPlace() : string
    {
        return $this->_workPlace ?: '';
    }

    /**
     * @return string
     */
    public function getProfession() : string
    {
        return $this->_profession ?: '';
    }

    /**
     * @return mixed
     */
    public function getNotation() : string
    {
        return $this->_notation ?: '';
    }

}
