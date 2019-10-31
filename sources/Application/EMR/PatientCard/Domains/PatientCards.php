<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Domains;


use Application\Base\AppDomain;
use Engine\Database\Connectors\ConnectorInterface;

class PatientCards extends AppDomain
{
    private $_limit = 10;
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    public function getCardsData(string $searchString, int $page){
        $searchString = $this->sanitize($searchString);
        $start = ($this->_limit*$page) - $this->_limit;
        $query = ("SELECT `id`, `card_number`, `is_alive`, `is_attached`, `surname`, `firstname`, `secondname`, `policy_number`, `insurance`
        FROM `patient_cards`
        WHERE `policy_number` LIKE '%$searchString%' OR CONCAT(`surname`, ' ', `firstname`, ' ', `secondname`) LIKE '%$searchString%' LIMIT :start, :offset");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'start' => $start,
            'offset' => $this->_limit + 1
        ]);
        if ($result->rowCount() > 0){
            $cards = $result->fetchAll();
            $cardsCount = count($cards);
            if($page === 1){
                if ($cardsCount > $this->_limit){
                    $data['status'] = 'first';
                    array_pop($cards);
                }elseif($cardsCount === $this->_limit){
                    $data['status'] = 'single';
                }
                $data['cards'] = $cards;
            }elseif ($cardsCount <= $this->_limit){
                $data['status'] = 'last';
                $data['cards'] = $cards;
            }else{
                array_pop($cards);
                $data['status'] = 'middle';
                $data['cards'] = $cards;
            }
            return $data;
        }
    }
}
