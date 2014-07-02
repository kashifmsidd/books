<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Книги");
?><p class="subHead">
	 Список книг
</p>
<?
require_once("../block_funcs.php");

$filter = array();

$searchAutorId = $_GET['id_autor'];
if (!empty($searchAutorId)) {
    $filter['UF_ID_AUTOR'] = $searchAutorId;
    $autor_name = getList(1, array('UF_NAME'), null, array('ID' => $searchAutorId));
    if (empty($autor_name)) {
        unset($searchAutorId);
    } else {
        echo "<p class='Text'>Автор: ".$autor_name[0]['UF_NAME']."</p>";
    }
}

$requests = getList(2, array('ID','UF_TITLE'), array('UF_TITLE'=>'ASC'), null);

foreach ($requests as $book) {
    $filter['UF_ID_BOOK'] = $book["ID"];
    $autor_req = getList(3, array('UF_ID_AUTOR'), null, $filter);

    if (!empty($filter['UF_ID_AUTOR']) && empty($autor_req)) {
        continue;
    }

    echo "<div class='ListItem'><p class='Text'><b>Название:</b> </p><p class='Text' style='padding-left: 100px'>".$book['UF_TITLE']."</p>";

    //$autor_req = getList(3, array('UF_ID_AUTOR'), null, null);
    echo "<p class='Text'><b>Авторы:</b> ";
    if (empty($autor_req)) {
        echo "&mdash;</p>";
    } else {
        echo "</p>";
        foreach ($autor_req as $autorId) {
            $autor_name = getList(1, array('UF_NAME'), null, array('ID' => $autorId["UF_ID_AUTOR"]));
            echo "<p class='Text' style='padding-left: 100px'>".$autor_name[0]['UF_NAME']."</p>";
        }
    }
    echo "</div>";
}

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>