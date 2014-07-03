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

        return $entity_requests_data_class;
    }

    function getList($blockId, $fields, $order, $filers) {
        $entity_requests_data_class = connectToBlock($blockId);

        $main_query_requests = new Entity\Query($entity_requests_data_class);
        $main_query_requests->setSelect($fields);
        //$main_query_requests->setSelect(array('ID','UF_TITLE'));

        if (!empty($order)) {
            $main_query_requests->setOrder($order);
        }

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
        $entity_requests_data_class = connectToBlock($blockId);
        /*$result = $entity_requests_data_class::add(array( //добавляем элемент
            'UF_NAME'=>'Николай',
            'UF_PROJECT'=>'seo',
            'UF_ACTIVE'=>1
        ));*/
        return $entity_requests_data_class::add($item);
    }

    function editItem($blockId, $itemId, $newInfo) {
        $entity_requests_data_class = connectToBlock($blockId);
        /*$result = $entity_requests_data_class::update( //обновляем значения элемента
            $id,	//id элемента
            array(
                'UF_GROUP'=>$id_group,
                'UF_URL'=>$id_url
            )
        );*/
        return $entity_requests_data_class::update($itemId, $newInfo);
    }

    function delItem($blockId, $itemId) {
        //$result = $entity_requests_data_class::delete($id);	//удаляем элемент
        $entity_requests_data_class = connectToBlock($blockId);
        return $entity_requests_data_class::delete($itemId);
    }

    function addNewBook($title) {
        $addBook = array('UF_TITLE'=>$title);
        $result = addItem(2, $addBook);
        if ($result->isSuccess()) {
            $_SESSION['BookMessage'] = "Книга ".$title." добавлена!";
        } else {
            $_SESSION['BookMessage'] = "При добавлении книги произошла ошибка!";
        }
        return $result->getId();
    }
?>