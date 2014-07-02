<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

require("../block_funcs.php");

$autorId = $_GET['id_autor'];
if (!empty($autorId)) {
    $autorNameSearch = getList(1, array('UF_NAME'), null, array('ID'=>$autorId));
    if (empty($autorNameSearch)) {
        Header ("Location: /autors/");
    }

    $autorSearch = getList(3, array('ID'), null, array('UF_ID_AUTOR'=>$autorId));
    $autorName = $autorNameSearch[0]['UF_NAME'];
    if (!empty($autorSearch)) {
        $_SESSION['AutorMessage'] = "Невозможно удалить автора ".$autorName."!";
        Header ("Location: /autors/");
    } else {
        $result = delItem(1, $autorId);
        if ($result->isSuccess()) {
            $_SESSION['AutorMessage'] = "Автор ".$autorName." удален!";
        } else {
            $_SESSION['AutorMessage'] = "При удалении произошла ошибка!";
        }
    }
}

Header ("Location: /autors/");

//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>