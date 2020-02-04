<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Search\DispositionSearch\Domains;


use Application\Base\AppDomain;
use Engine\Database\Connectors\ConnectorInterface;

/**
 * Один общий класс для поиска данных в полях относящихся к адресу
 *
 * Class DispositionSearch
 * @package Application\EMR\PatientCard\Domains
 */
class DispositionSearch extends AppDomain
{
    private $_limit = 5;
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    public function searchRegion(string $searchString){
        $searchString = $this->sanitize($searchString);
        if(!empty($searchString)){
            $query = ("SELECT * FROM `regions` WHERE `region_name` LIKE '%$searchString%' LIMIT $this->_limit;");
            $result = $this->_dbConnection->prepare($query);
            $result->execute();
            if ($result->rowCount() > 0){
                $i = 0;
                while ($row = $result->fetch()){
                    $data[$i]['id'] = $row['id'];
                    $data[$i]['value'] = $row['region_name'];
                    $i ++;
                }
                return $data;
            }
        }
        return null;//'Nothing found';
    }

    public function searchDistrict(array $searchData){
        $searchString = $this->sanitize($searchData['searchString']);
        if (!empty($searchString)){
            $searchId = $searchData['searchParams'];
            $query = ("SELECT * FROM `districts` WHERE `district_name` LIKE '%$searchString%' AND `region` = :searchId LIMIT $this->_limit;");
            $result = $this->_dbConnection->prepare($query);
            $result->execute([
                'searchId' => $searchId
            ]);
            if ($result->rowCount() > 0){
                $i = 0;
                while ($row = $result->fetch()){
                    $data[$i]['id'] = $row['id'];
                    $data[$i]['value'] = $row['district_name'];
                    $i ++;
                }
                return $data;
            }
        }
        return null;
    }

    public function searchLocality(array $searchData){
        $searchString = $this->sanitize($searchData['searchString']);
        if (!empty($searchString)){
            $searchId = $searchData['searchParams'];
            $query = ("SELECT * FROM `localities` WHERE `locality_name` LIKE '%$searchString%' AND `district` = :searchId LIMIT $this->_limit;");
            $result = $this->_dbConnection->prepare($query);
            $result->execute([
                'searchId' => $searchId
            ]);
            if ($result->rowCount() > 0){
                $i = 0;
                while ($row = $result->fetch()){
                    $data[$i]['id'] = $row['id'];
                    $data[$i]['value'] = $row['locality_name'];
                    $i ++;
                }
                return $data;
            }
        }
        return null;
    }

    public function searchStreet(array $searchData){
        $searchString = $this->sanitize($searchData['searchString']);
        if (!empty($searchString)){
            $searchId = $searchData['searchParams'];
            $query = ("SELECT `streets`.`id`, `streets`.`street_name` FROM `streets_localities`
                  INNER JOIN `streets` ON streets_localities.street_id = streets.id
                  WHERE `street_name` LIKE '%$searchString%' AND `locality_id` = :searchId");
            $result = $this->_dbConnection->prepare($query);
            $result->execute([
                'searchId' => $searchId
            ]);
            if ($result->rowCount() > 0){
                $i = 0;
                while ($row = $result->fetch()){
                    $data[$i]['id'] = $row['id'];
                    $data[$i]['value'] = $row['street_name'];
                    $i ++;
                }
                return $data;
            }
        }
        return null;
    }

}
