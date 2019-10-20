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
    private $_isAlive;
    private $_isAttached;
    private $_surname;
    private $_firstName;
    private $_secondName;
    private $_gender_id;
    private $_gender;
    private $_dateBirth;
    private $_telephone;
    private $_email;
    private $_policyNumber;
    private $_insuranceCompany;
    private $_insuranceCertificate;
    private $_passportSerial;
    private $_passportNumber;
    private $_fmsDepartment;
    private $_region;
    private $_district;
    private $_locality;
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

    public function edit(int $id){
        return 'You wanna edit this id'.$id;
    }

    /**
     * @return PatientCard
     */
    public function getCardData($id) : PatientCard {
        $query = ("SELECT 
        `patient_cards`.`id`,
        `patient_cards`.`card_number` as `card_number`,
        `patient_cards`.`is_alive` as `is_alive`,
        `patient_cards`.`is_attached` as `is_attached`,
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
        `insurance_companies`.`insurance_name` as `insurance_company`,
        `patient_cards`.`passport_serial` as `passport_serial`,
        `patient_cards`.`passport_number` as `passport_number`,
        `fms_departments`.`fms_department_name` as `fms_department`,
        `regions`.`region_name` as `region`,
        `districts`.`district_name` as `district`,
        `localities`.`locality_name` as `locality`,
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
        WHERE `patient_cards`.`id` = :id");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'id' => $id
        ]);
        if ($result->rowCount() > 0){
            while ($row = $result->fetch()){
                $this->_id = $row['id'];
                $this->_cardNumber = $row['card_number'];
                $this->_isAlive = $row['is_alive'];
                $this->_isAttached = $row['is_attached'];
                $this->_surname = $row['surname'];
                $this->_firstName = $row['firstname'];
                $this->_secondName = $row['secondname'];
                $this->_gender_id = $row['gender_id'];
                $this->_gender = $row['gender'];
                $this->_dateBirth = $row['date_birth'];
                $this->_telephone = $row['telephone_number'];
                $this->_email = $row['email'];
                $this->_insuranceCertificate = $row['insurance'];
                $this->_policyNumber = $row['policy_number'];
                $this->_insuranceCompany = $row['insurance_company'];
                $this->_passportSerial = $row['passport_serial'];
                $this->_passportNumber = $row['passport_number'];
                $this->_fmsDepartment = $row['fms_department'];
                $this->_region = $row['region'];
                $this->_district = $row['district'];
                $this->_locality = $row['locality'];
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
            'isAlive' => $this->_isAlive,
            'isAttached' => $this->_isAttached,
            'surname' => $this->_surname,
            'firstName' => $this->_firstName,
            'secondName' => $this->_secondName,
            'genderId' => $this->_gender_id,
            'gender' => $this->_gender,
            'dateBirth' => $this->_dateBirth,
            'telephone' => $this->_telephone,
            'email' => $this->_email,
            'policyNumber' => $this->_policyNumber,
            'insuranceCompany' => $this->_insuranceCompany,
            'insuranceCertificate' => $this->_insuranceCertificate,
            'passportSerial' => $this->_passportSerial,
            'passportNumber' => $this->_passportNumber,
            'fmsDepartment' => $this->_fmsDepartment,
            'region' => $this->_region,
            'district' => $this->_district,
            'locality' => $this->_locality,
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
        return $this->_gender_id;
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
