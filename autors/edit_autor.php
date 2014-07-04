<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>

    <p class="subHead">
        Редактирование имени автора
    </p>

<?

require("../block_funcs.php");

$autorId = $_GET['id_autor'];
if (!empty($autorId)) {
    $autorNameSearch = getList(1, array('UF_NAME'), null, array('ID'=>$autorId));
    if (empty($autorNameSearch)) {
        LocalRedirect("/autors/");
    }
    $autorName = $autorNameSearch[0]['UF_NAME'];
} else {
    if (!isset($_POST['edit'])) {
        LocalRedirect("/autors/");
    }
}

?>

    <form name="editAutors" action="" method="post">
        <div class="ListItem">
            <p class='Text'><b>Имя автора:</b> <input type="text" name="autorName" value="<?=$autorName?>" class="Text"></p>
            <div style="padding: 10px"><input type="submit" name="edit" value="Сохранить">
            <input type="hidden" name="id" value="<?=$autorId?>"></div>
        </div>
    </form>

<?

if (isset($_SESSION['AutorMessage'])) {
    echo "<p class='Text'>".$_SESSION['AutorMessage']."</p>";
    unset($_SESSION['AutorMessage']);
}

$newAutorName = $_POST['autorName'];
if (isset($_POST['edit']) && !empty($autorName)) {
    if ($newAutorName == $autorName) {
        LocalRedirect("/autors/");
    }
    $autorSearch = getList(1, array('ID'), null, array('UF_NAME'=>$newAutorName));
    $autorId = $_POST['id'];
    if (!empty($autorSearch)) {
        $_SESSION['AutorMessage'] = "Автор с таким именем уже существует!";
        LocalRedirect("edit_autor.php?id_autor={$autorId}");
    }
    $editItem = array('UF_NAME'=>$newAutorName);
    $result = editItem(1, $autorId, $editItem);
    if ($result->isSuccess()) {
        $_SESSION['AutorMessage'] = "Имя автора ".$newAutorName." изменено!";
    } else {
        $_SESSION['AutorMessage'] = "При изменении имени автора произошла ошибка!";
    }
    LocalRedirect("/autors/");
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>