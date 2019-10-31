<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Domains;


use Application\Base\AppDomain;
use Engine\Database\Connectors\ConnectorInterface;

class PatientCards extends AppDomain
{
    private $_limit = 5;
    private $_dbConnection;

    public function __construct(ConnectorInterface $dbConnector)
    {
        $this->_dbConnection = $dbConnector->getConnection();
    }

    /**
     * Расчитывает количество страниц
     *
     * @return int
     */
    private function countPages(array $records) : int {
        $pagesCount = ceil( count($records) / $this->_limit);
        return (int) $pagesCount;
    }

    private function getCardsData(string $searchString){
        /**
         * 1) Метод ищет все совпадающие записи
         * 2) Метод возвращает записи для текущей страницы
         */
        $searchString = $this->sanitize($searchString);
        $query = ("SELECT `id`, `card_number`, `is_alive`, `is_attached`, `surname`, `firstname`, `secondname`, `policy_number`, `insurance`
        FROM `patient_cards`
        WHERE `policy_number` LIKE '%$searchString%' OR CONCAT(`surname`, ' ', `firstname`, ' ', `secondname`) LIKE '%$searchString%'");
        $result = $this->_dbConnection->prepare($query);
        $result->execute();
        if ($result->rowCount() > 0){
            $cards = $result->fetchAll();
            return $cards;
        }
    }

    public function getRecordsPage(string $searchString, int $page = 1) : array {
        $records = $this->getCardsData($searchString);
        $pagesCount = $this->countPages($records);
        $chunkedPages = array_chunk($records, $this->_limit);
        $keys = range(1, $pagesCount);
        $pages = array_combine($keys, $chunkedPages);
        $pageRecords = $pages[$page];
        /**
         * Теперь нужн овернуть все необходимые для отображения данные:
         * 1) Количество страниц для пагинации
         * 2) Записи с выбранной страницы
         */
        $data['pagesCount'] = $pagesCount;
        $data['pageRecords'] = $pageRecords;
        return $data;

    }

}
