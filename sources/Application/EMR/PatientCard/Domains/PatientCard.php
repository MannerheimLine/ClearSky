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
    private $_surname;
    private $_firstName;
    private $_secondName;
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

    /**
     * person constructor.
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
        `patient_cards`.`surname` as `surname`,
        `patient_cards`.`firstname` as `firstname`,
        `patient_cards`.`secondname` as `secondname`,
        `gender`.`description` as `gender`
        FROM `patient_cards` 
        LEFT JOIN `gender` ON `patient_cards`.`gender` = `gender`.`id` 
        WHERE `patient_cards`.`id` = :id");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'id' => $id
        ]);
        if ($result->rowCount() > 0){
            while ($row = $result->fetch()){
                $this->_id = $row['id'];
                $this->_cardNumber = $row['card_number'];
                $this->_surname = $row['surname'];
                $this->_firstName = $row['firstname'];
                $this->_secondName = $row['secondname'];
                $this->_gender = $row['gender'];
                $this->_dateBirth = $row['date_birth'];
                $this->_telephone = $row['telephone_number'];
                $this->_emaile = $row['email'];
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
                $this->_houseNumber = $row['houseNumber'];
                $this->_apartment = $row['apartment'];
                $this->_workPlace = $row['work_place'];
                $this->_profession = $row['profession'];
            }
        }
        return $this;
        /*$this->_id = 1;
        $this->_cardNumber = '12345';
        $this->_surname = 'Иванов';
        $this->_firstName = 'Юрий';
        $this->_secondName = 'Витальевич';
        $this->_gender = 'мужчина';
        $this->_dateBirth = '01.03.1967';
        $this->_telephone = '89145432672';
        $this->_email = 'ivanov@mail.ru';
        $this->_policyNumber = '2549320879000095';
        $this->_insuranceCertificate = '043-971-390 72';
        $this->_passportSerial = '0502';
        $this->_passportNumber = '220551';
        $this->_region = 'Приморский край';
        $this->_district = 'Чугуевский район';
        $this->_locality = 'Чугуевка';
        $this->_street = '50 лет Октября';
        $this->_houseNumber = '335';
        $this->_apartment = '1';
        $this->_workPlace = 'Отдел соцзащиты';
        $this->_profession = 'работник отдела кадров';
        return $this;*/

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
            'id' => $this->getId(),
            'cardNumber' => $this->getCardNumber(),
            'surname' => $this->getSurname(),
            'firstName' => $this->getFirstName(),
            'secondName' => $this->getSecondName(),
            'gender' => $this->getGender(),
            /*'dateBirth' => $this->getDateBirth(),
            'telephone' => $this->getTelephone(),
            'email' => $this->getEmail(),
            'policeNumber' => $this->getPolicyNumber(),
            'insuranceCertificate' => $this->getInsuranceCertificate(),
            'passportSerial' => $this->getPassportSerial(),
            'passportNumber' => $this->getPassportNumber(),
            'region' => $this->getRegion(),
            'district' => $this->getDistrict(),
            'locality' => $this->getLocality(),
            'street' => $this->getStreet(),
            'houseNumber' => $this->getHouseNumber(),
            'apartment' => $this->getApartment(),
            'workPlace' => $this->getWorkPlace(),
            'profession' => $this->getProfession()*/
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
        return $this->_secondName;
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
        return $this->_dateBirth;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
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
    public function getInsuranceCompany()
    {
        return $this->_insuranceCompany;
    }

    /**
     * @return string
     */
    public function getInsuranceCertificate() : string
    {
        return $this->_insuranceCertificate;
    }

    /**
     * @return string
     */
    public function getPassportSerial() : string
    {
        return $this->_passportSerial;
    }

    /**
     * @return string
     */
    public function getPassportNumber() : string
    {
        return $this->_passportNumber;
    }

    /**
     * @return mixed
     */
    public function getFmsDepartment()
    {
        return $this->_fmsDepartment;
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
        return $this->_locality;
    }

    /**
     * @return string
     */
    public function getStreet() : string
    {
        return $this->_street;
    }

    /**
     * @return string
     */
    public function getHouseNumber() : string
    {
        return $this->_houseNumber;
    }

    /**
     * @return string
     */
    public function getApartment() : string
    {
        return $this->_apartment;
    }

    /**
     * @return string
     */
    public function getWorkPlace() : string
    {
        return $this->_workPlace;
    }

    /**
     * @return string
     */
    public function getProfession() : string
    {
        return $this->_profession;
    }




}
