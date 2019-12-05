<?php


namespace Application\EMR\Talons\Domains;


use Application\EMR\Talons\Base\Talon;
use Engine\Database\Connectors\ConnectorInterface;
use Mpdf\Mpdf;

class OutpatientTalon extends Talon
{
    private $_dbConnection;

    public function __construct(ConnectorInterface $connector)
    {
        parent::__construct();
        $this->setTemplate('outpatient.talon');
        $this->_dbConnection = $connector::getConnection();
    }

    /**
     * Загрузка данных
     *
     * @return mixed
     */
    protected function getTalonData(int $cardId)
    {
        $query = ("SELECT `patient_cards`.`id`, `patient_cards`.`card_number`, `patient_cards`.`surname`, 
       `patient_cards`.`firstname`, `patient_cards`.`secondname`, `gender`.`description` as gender, 
       `patient_cards`.`insurance_certificate`, `patient_cards`.`date_birth`,`patient_cards`.`policy_number`, 
       `insurance_companies`.`insurance_company_name` as insurance_company, `insurance_companies`.`insurer_code`,
       `patient_cards`.`passport_serial`, `patient_cards`.`passport_number`, `patient_cards`.`fms_department`,
       `patient_cards`.`birth_certificate_serial`, `patient_cards`.`birth_certificate_number`, `patient_cards`.`registry_office`, 
       `regions`.`region_name` as `region`, `districts`.`district_name` as `district`, `localities`.`locality_name` as `locality`, 
       `streets`.`street_name` as `street`, `patient_cards`.`house_number`, `patient_cards`.`apartment`, 
       `patient_cards`.`work_place`, `patient_cards`.`profession`
       FROM `patient_cards` 
       LEFT JOIN `gender` ON `patient_cards`.`gender` = `gender`.`id`
       LEFT JOIN `insurance_companies` ON `patient_cards`.`insurance_company` = `insurance_companies`.`id`
       LEFT JOIN `regions` ON `patient_cards`.`region` = `regions`.`id`
       LEFT JOIN `districts` ON `patient_cards`.`district` = `districts`.`id`
       LEFT JOIN `localities` ON `patient_cards`.`locality` = `localities`.`id`
       LEFT JOIN `streets` ON `patient_cards`.`street` = `streets`.`id` 
       WHERE `patient_cards`.`id` = :id");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'id' => $cardId
        ]);
        if ($result->rowCount() > 0){
            $talonData = [];
            while ($row = $result->fetch()){
                $talonData['cardNumber'] = $row['card_number'];
                $talonData['fullName'] = $row['surname'].' '.$row['firstname'].' '.$row['secondname'];
                $talonData['gender'] = $row['gender'];
                $talonData['insuranceCertificate'] = $row['insurance_certificate'];
                $talonData['dateBirth'] = date('d.m.Y', strtotime($row['date_birth']));
                $talonData['policyNumber'] = $row['policy_number'];
                $talonData['insuranceCompany'] = $row['insurance_company'];
                $talonData['insurerCode'] = $row['insurer_code'];
                $talonData['passportSerial'] = $row['passport_serial'];
                $talonData['passportNumber'] = $row['passport_number'];
                $talonData['fmsDepartment'] = $row['fms_department'];
                $talonData['birthCertificateSerial'] = $row['birth_certificate_serial'];
                $talonData['birthCertificateNumber'] = $row['birth_certificate_number'];
                $talonData['registryOffice'] = $row['registry_office'];
                $talonData['address'][0] = $row['region'];
                $talonData['address'][1] = $row['district'];
                $talonData['address'][2] = $row['locality'];
                $talonData['address'][3] = $row['street'];
                $talonData['address'][4] = $row['house_number'];
                $talonData['address'][5] = $row['apartment'];
                $talonData['address'] = implode(', ', array_diff($talonData['address'], array('', null)));
                $talonData['workplace'] = $row['workplace'];
                $talonData['profession'] = $row['profession'];
            }
            return $talonData;
        }
    }

    /**
     * Вывод на печать готового PDF талона
     *
     * @return mixed
     */
    public function makePdf(int $cardId) : Mpdf
    {
        $talonData = $this->getTalonData($cardId);
        $html = $this->prepareHtml($talonData);
        $mpdf = new Mpdf([
            'format' => 'A5-P',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
        ]);
        $stylesheet = file_get_contents($this->_talonStyle);
        $mpdf->SetTitle('Карта № '.$talonData['cardNumber']);
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($html,2);
        return $mpdf;
    }
}
