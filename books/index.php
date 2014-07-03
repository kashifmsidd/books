<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Книги");
?><p class="subHead">
	 Список книг
</p>

    <form name="books" action="" method="post">
        <div class="ListItem">
            <p class='Text'><b>Критерий поиска:</b>
                <select name="searchType">
                    <option value="searchByTitle">по названию</option>
                    <option value="searchByAutor">по автору</option>
                </select>
                <input type="text" name="searchValue">
                <input type="submit" name="searchBook" value="Искать книгу"></p>
            <a href="add_book.php"><p class="Text"><b>Добавить книгу</b></p></a>
        </div>
    </form>

<?
require_once("../block_funcs.php");

if (isset($_SESSION['BookMessage'])) {
    echo "<p class='Text'>".$_SESSION['BookMessage']."</p>";
    unset($_SESSION['BookMessage']);
}

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

if (isset($_POST['searchBook']) && (!empty($_POST['searchValue']))) {
    if ($_POST['searchType'] == "searchByTitle") {
        $bookSearch = $_POST['searchValue'];
        echo "<p class='Text'>Результат поиска по названию: ".$bookSearch."</p>";
    } else {
        $autorName = $_POST['searchValue'];
        echo "<p class='Text'>Результат поиска по автору: ".$autorName."</p>";
    }
}

if (!empty($autorName)) {
    $autorBooks = array();
    $requests = getList(1, array('ID','UF_NAME'), null, null);

    foreach ($requests as $autor) {
        if (substr_count(strtolower($autor['UF_NAME']), strtolower($autorName)) > 0) {
            $rq = getList(3, array('UF_ID_BOOK'), null, array('UF_ID_AUTOR'=>$autor['ID']));
            foreach ($rq as $bookItem) {
                $autorBooks[] = $bookItem['UF_ID_BOOK'];
            }
        }
    }
}

$requests = getList(2, array('ID','UF_TITLE'), array('UF_TITLE'=>'ASC'), null);

foreach ($requests as $book) {
    if (!empty($autorName) && !in_array($book["ID"], $autorBooks)) {
        continue;
    }

    if (!empty($bookSearch) && (substr_count(strtolower($book['UF_TITLE']), strtolower($bookSearch)) < 1)) {
        continue;
    }

    $filter['UF_ID_BOOK'] = $book["ID"];
    $autor_req = getList(3, array('UF_ID_AUTOR'), null, $filter);

    if (!empty($filter['UF_ID_AUTOR']) && empty($autor_req)) {
        continue;
    }

    $bookIdRequest = "?id_book=".$book['ID'];
    echo "<div style='float: right'><a href='edit_book.php".$bookIdRequest."'><img src='/bitrix/templates/books_template/images/edit.gif'></a>
        <a href='del_book.php".$bookIdRequest."'><img src='/bitrix/templates/books_template/images/delete.gif'></a></div>
        <div class='ListItem'><p class='Text'><b>Название:</b> </p><p class='Text' style='padding-left: 100px'>".$book['UF_TITLE']."</p>";

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