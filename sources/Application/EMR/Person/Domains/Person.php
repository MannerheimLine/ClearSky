<?php

declare(strict_types = 1);

namespace Application\EMR\Person\Domains;


use Application\Base\AppDomain;
use Engine\Database\Connectors\ConnectorInterface;

class Person extends AppDomain implements \JsonSerializable
{
    private $_dbConnection;
    private $_id;
    private $_cardNumber;
    private $_surname;
    private $_firstName;
    private $_secondName;
    private $_gender;
    private $_dateBirth;
    private $_policyNumber;
    private $_insuranceCertificate;
    private $_passportSerial;
    private $_passportNumber;
    private $_region;
    private $_district;
    private $_village;
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
     * @return Person
     */
    public function getPersonalData() : Person {
        $this->_id = 1;
        $this->_cardNumber = '12345';
        $this->_surname = 'Иванов';
        $this->_firstName = 'Юрий';
        $this->_secondName = 'Витальевич';
        $this->_gender = 'мужчина';
        $this->_dateBirth = '01.03.1967';
        $this->_policyNumber = '2549320879000095';
        $this->_insuranceCertificate = '043-971-390-72';
        $this->_passportSerial = '0502';
        $this->_passportNumber = '220551';
        $this->_region = 'Приморский край';
        $this->_district = 'Чугуевский район';
        $this->_village = 'Чугуевка';
        $this->_street = '50 лет Октября';
        $this->_houseNumber = '335';
        $this->_apartment = '1';
        $this->_workPlace = 'Отдел соцзащиты';
        $this->_profession = 'работник отдела кадров';
        return $this;

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
            'dateBirth' => $this->getDateBirth(),
            'policeNumber' => $this->getPolicyNumber(),
            'insuranceCertificate' => $this->getInsuranceCertificate(),
            'passportSerial' => $this->getPassportSerial(),
            'passportNumber' => $this->getPassportNumber(),
            'region' => $this->getRegion(),
            'district' => $this->getDistrict(),
            'village' => $this->getVillage(),
            'street' => $this->getStreet(),
            'houseNumber' => $this->getHouseNumber(),
            'apartment' => $this->getApartment(),
            'workPlace' => $this->getWorkPlace(),
            'profession' => $this->getProfession()
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
     * @return string
     */
    public function getPolicyNumber() : string
    {
        return $this->_policyNumber;
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
    public function getVillage() : string
    {
        return $this->_village;
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
