<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>

    <p class="subHead">
        Редактирование информации о книге
    </p>

<?
require("../block_funcs.php");

$bookId = $_GET['id_book'];
if (!empty($bookId)) {
    $bookTitleSearch = getList(2, array('UF_TITLE'), null, array('ID'=>$bookId));
    if (empty($bookTitleSearch)) {
        LocalRedirect("/books/");
    }
    $bookTitle = $bookTitleSearch[0]['UF_TITLE'];
} else {
    if (!isset($_POST['editBookTitle']) || !isset($_POST['editBookAutors'])) {
        LocalRedirect("/books/");
    }
}

?>

    <form name="editTitle" action="" method="post">
        <div class="ListItem">
            <p class='Text'><b>Название:</b> <input type="text" name="bookTitle" value="<?=$bookTitle?>" class="Text">
            <input type="submit" name="editBookTitle" value="Сохранить"></p>
            <input type="hidden" name="bookId" value="<?=$bookId?>">
            <input type="hidden" name="oldTitle" value="<?=$bookTitle?>">
        </div>
    </form>

    <form name="editAutors" action="" method="post">
        <div class="ListItem">
            <p class='Text'><b>Авторы:</b></p>
                <?
                    $autor_req = getList(3, array('UF_ID_AUTOR'), null, array('UF_ID_BOOK'=>$bookId));

                    if (empty($autor_req)) {
                        echo "&mdash;</p>";
                    } else {
                        echo "</p>";
                        foreach ($autor_req as $autorId) {
                            $autor_name = getList(1, array('UF_NAME'), null, array('ID' => $autorId["UF_ID_AUTOR"]));
                            echo "<p class='Text' style='padding-left: 100px'>".$autor_name[0]['UF_NAME']."
                                <input type='submit' name='autorDelete' value='Удалить'>
                                <input type='hidden' name='autorId' value='".$autorId['UF_ID_AUTOR']."'></p>";
                        }
                    }

                    $autors = getList(1, array('ID','UF_NAME'), array('UF_NAME'=>'ASC'), null);
                    echo "<p class='Text'><b>Новый автор:</b> </p><p class='Text' style='padding-left: 100px'><select name='newAutor'>";
                    foreach ($autors as $autor) {
                        echo "<option value='".$autor['ID']."'>".$autor['UF_NAME']."</option>";
                    }
                    echo "</select><input type='submit' name='addBookAutor' value='Добавить'></p>";
                ?>
            <input type="hidden" name="bookId" value="<?=$bookId?>">
            <input type="hidden" name="bookTitle" value="<?=$bookTitle?>">
        </div>
    </form>

<?

if (isset($_POST['editBookTitle'])) {
    $newTitle = $_POST['bookTitle'];
    if (($newTitle == $_POST['oldTitle']) || (empty($newTitle))) {
        LocalRedirect("/books/");
    }
    $editItem = array('UF_TITLE'=>$newTitle);
    $result = editItem(2, $_POST['bookId'], $editItem);
    if ($result->isSuccess()) {
        $_SESSION['BookMessage'] = "Название книги ".$newTitle." изменено!";
    } else {
        $_SESSION['BookMessage'] = "При изменении названия книги произошла ошибка!";
    }
    LocalRedirect("/books/");
}

if (isset($_POST['autorDelete'])) {
    $autorSearch = getList(3, array('ID'), null, array('UF_ID_BOOK'=>$_POST['bookId'], 'UF_ID_AUTOR'=>$_POST['autorId']));
    $result = delItem(3, $autorSearch[0]['ID']);
    if ($result->isSuccess()) {
        $_SESSION['BookMessage'] = "Список авторов книги ".$_POST['bookTitle']." изменен!";
    } else {
        $_SESSION['BookMessage'] = "При изменении списка авторов произошла ошибка!";
    }
    LocalRedirect("/books/");
}

if (isset($_POST['addBookAutor'])) {
    $add = array('UF_ID_AUTOR'=>$_POST['newAutor'], 'UF_ID_BOOK'=>$_POST['bookId']);
    $result = addItem(3, $add);
    if ($result->isSuccess()) {
        $_SESSION['BookMessage'] = "Список авторов книги ".$_POST['bookTitle']." изменен!";
    } else {
        $_SESSION['BookMessage'] = "При изменении списка авторов произошла ошибка!";
    }
    LocalRedirect("/books/");
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>