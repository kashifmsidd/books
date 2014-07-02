<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторы");
?><p class="subHead">
	 Список авторов
</p>
 <?
require("../block_funcs.php");

?>

<form name="autors" action="" method="post">
    <div class="ListItem">
        <p class='Text'><b>Имя автора:</b> <input type="text" name="autorName"></p>
        <div style="padding: 10px"><input type="submit" name="addAutor" value="Добавить автора" onclick="autors.action='add_autor.php'">
        <input type="submit" name="searchAutor" value="Искать автора"></div>
    </div>
</form>

<?

//$filter = array();

if (isset($_SESSION['AutorMessage'])) {
    echo "<p class='Text'>".$_SESSION['AutorMessage']."</p>";
    unset($_SESSION['AutorMessage']);
}

if (isset($_POST['searchAutor']) && (!empty($_POST['autorName']))) {
    $autorName = $_POST['autorName'];
    echo "<p class='Text'>Результат поиска по имени: ".$autorName."</p>";
    //$autorName = "(?i){$autorName}";
    //$filter['UF_NAME'] = "#(?i){$autorName}#";
    //echo $filter['UF_NAME'];
}

//$requests = getList(1, array('ID','UF_NAME'), $filter);
$requests = getList(1, array('ID','UF_NAME'), array('UF_NAME'=>'ASC'), null);

foreach ($requests as $autor) {
    if (!empty($autorName) && (substr_count(strtolower($autor['UF_NAME']), strtolower($autorName)) < 1)) {
        continue;
    }
    $autorIdRequest = "?id_autor=".$autor['ID'];
    echo "<div style='float: right'><a href='../books/index.php".$autorIdRequest."'><img src='/bitrix/templates/books_template/images/autor_books.gif'></a>
        <a href='edit_autor.php".$autorIdRequest."'><img src='/bitrix/templates/books_template/images/edit.gif'></a>
        <a href='del_autor.php".$autorIdRequest."'><img src='/bitrix/templates/books_template/images/delete.gif'></a></div>
        <div class='ListItem'><p class='Text'><b>Имя автора:</b> </p>
        <p class='Text' style='padding-left: 120px'>".$autor['UF_NAME']."</p></div>";
}

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>