<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

require("../block_funcs.php");

$autorName = $_POST['autorName'];
if (isset($_POST['addAutor']) && !empty($autorName)) {
    $autorSearch = getList(1, array('ID'), null, array('UF_NAME'=>$autorName));
    if (!empty($autorSearch)) {
        $_SESSION['AutorMessage'] = "Автор с таким именем уже существует!";
        LocalRedirect("/autors/");
    }
    $addItem = array('UF_NAME'=>$autorName);
    $result = addItem(1, $addItem);
    if ($result->isSuccess()) {
        $_SESSION['AutorMessage'] = "Автор ".$autorName." добавлен!";
    } else {
        $_SESSION['AutorMessage'] = "При добавлении произошла ошибка!";
    }
}

LocalRedirect ("/autors/");

//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>