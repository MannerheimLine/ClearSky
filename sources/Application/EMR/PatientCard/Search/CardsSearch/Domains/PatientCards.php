<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Search\CardsSearch\Domains;


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

    /**
     * @param string $searchString
     * @param int $selectedPage
     * @return array|null
     */
    public function getCardsData(string $searchString, int $selectedPage){
        $searchString = $this->sanitize($searchString);
        $start = ($this->_limit*$selectedPage) - $this->_limit;
        $query = ("SELECT `id`, `card_number`, `is_alive`, `is_attached`, `surname`, `firstname`, `secondname`, `policy_number`, `insurance_certificate`
        FROM `patient_cards`
        WHERE `policy_number` LIKE '%$searchString%' OR CONCAT(`surname`, ' ', `firstname`, ' ', `secondname`) LIKE '%$searchString%' LIMIT :start, :offset");
        $result = $this->_dbConnection->prepare($query);
        $result->execute([
            'start' => $start,
            'offset' => $this->_limit + 1   //Такой сдвиг нужен для сортировки специально, дабы определить порядок страницы
        ]);
        if ($result->rowCount() > 0){
            $cards = $result->fetchAll();
            $cardsCount = count($cards);
            /**
             * Банальное определение порядка страницы: первая, средняя, последняя либо единственная
             * Заолнение данными массива: карты, статус
             */
            if($selectedPage === 1){
                if ($cardsCount > $this->_limit){
                    $data['pageOrder'] = 'first';
                    array_pop($cards);
                }elseif($cardsCount === $this->_limit){
                    $data['pageOrder'] = 'single';
                }
                $data['cards'] = $cards;
            }elseif ($cardsCount <= $this->_limit){
                $data['pageOrder'] = 'last';
                $data['cards'] = $cards;
            }else{
                array_pop($cards);
                $data['pageOrder'] = 'middle';
                $data['cards'] = $cards;
            }
            return $data;
        }
        return null;
    }
}
