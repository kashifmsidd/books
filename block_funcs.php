<?php
    // подключаем модули
    CModule::IncludeModule('iblock');
    CModule::IncludeModule('highloadblock');
    // необходимые классы
    use Bitrix\Highloadblock as HL;
    use Bitrix\Main\Entity;

    function connectToBlock($blockId) {
        $hlblock_requests = HL\HighloadBlockTable::getById($blockId)->fetch();//requests
        $entity_requests = HL\HighloadBlockTable::compileEntity($hlblock_requests);
        $entity_requests_data_class = $entity_requests->getDataClass();

        $main_query_requests = new Entity\Query($entity_requests_data_class);
        return $main_query_requests;
    }

    function getList($blockId, $fields, $filers) {
        $main_query_requests = connectToBlock($blockId);
        $main_query_requests->setSelect($fields);
        //$main_query_requests->setSelect(array('ID','UF_TITLE'));

        if (!empty($filers)) {
            $main_query_requests->setFilter($filers);
            /*$main_query_requests->setFilter(
                 array(
                     'UF_NAME'=>'Александр',
                 )
             );*/
        }

        $result_requests = $main_query_requests->exec();
        $result_requests = new CDBResult($result_requests);

        $requests = array();
        while ($row_requests=$result_requests->Fetch()) {
            $requests[] = $row_requests; //массив выбранных элементов
        }

        return $requests;
    }

    function addItem($blockId, $item) {

    }

    function editItem() {

    }

    function delItem() {

    }
?>