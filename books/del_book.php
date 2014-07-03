<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

require("../block_funcs.php");

$bookId = $_GET['id_book'];
if (!empty($bookId)) {
    $bookTitleSearch = getList(2, array('UF_TITLE'), null, array('ID'=>$bookId));
    if (empty($bookTitleSearch)) {
        LocalRedirect("/books/");
    }

    $booksSearch = getList(3, array('ID'), null, array('UF_ID_BOOK'=>$bookId));
    $bookTitle = $bookTitleSearch[0]['UF_TITLE'];
    foreach ($booksSearch as $book) {
        $result = delItem(3, $book['ID']);
    }

    $result = delItem(2, $bookId);
    if ($result->isSuccess()) {
        $_SESSION['BookMessage'] = "Книга ".$bookTitle." удалена!";
    } else {
        $_SESSION['BookMessage'] = "При удалении произошла ошибка!";
    }
}

LocalRedirect("/books/");

//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>