<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторы");
?>
<p class="subHead">
    Список авторов
</p>
<?
require_once("../block_funcs.php");

$requests = getList(1, array('ID','UF_NAME'), null);

foreach ($requests as $autor) {
    echo "<div style='float: right'><a href='edit_autor.php'><img src='/bitrix/templates/books_template/images/edit.gif'></a>
        <a href='del_autor.php'><img src='/bitrix/templates/books_template/images/delete.gif'></a></div>
        <div class='ListItem'><p class='Text'><b>Имя автора:</b> </p>
        <p class='Text' style='padding-left: 120px'>".$autor['UF_NAME']."</p></div>";
}

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>