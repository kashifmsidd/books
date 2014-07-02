<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

require("../block_funcs.php");

$autorName = $_POST['autorName'];
if (isset($_POST['addAutor']) && !empty($autorName)) {
    $autorSearch = getList(1, array('ID'), null, array('UF_NAME'=>$autorName));
    if (!empty($autorSearch)) {
        $_SESSION['AddAutorMessage'] = "Автор с таким именем уже существует!";
        Header ("Location: /autors/");
    } else {
        $addItem = array('UF_NAME'=>$autorName);
        $result = addItem(1, $addItem);
        if ($result->isSuccess()) {
            $_SESSION['AddAutorMessage'] = "Автор ".$autorName." добавлен!";
        } else {
            $_SESSION['AddAutorMessage'] = "При добавлении произошла ошибка!";
        }
    }
}

Header ("Location: /autors/");

//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>