<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>

<p class="subHead">
    Информация о новой книге
</p>

<?

require("../block_funcs.php");

if (isset($_POST['addAutorsToBook'])) {

    $autorCount = $_POST['autorCount'];
    $bookTitle = $_POST['bookTitle'];
    if (empty($bookTitle)) {
        $_SESSION['BookMessage'] = "Не введено название!";
        LocalRedirect("add_book.php");
    }
    if ($autorCount > 0) {
        if (isset($_POST['saveBookInfo'])) {
            $bookId = addNewBook($bookTitle);
            for ($i = 0; $i < $autorCount; $i++) {
                $newAutor = "autor".$i;
                $autorId = $_POST[$newAutor];
                $add = array('UF_ID_AUTOR'=>$autorId, 'UF_ID_BOOK'=>$bookId);
                $result = addItem(3, $add);
            }
            LocalRedirect("/books/");
        }
        $autors = getList(1, array('ID','UF_NAME'), array('UF_NAME'=>'ASC'), null);
        ?>
        <form name="addAutors" action="" method="post">
            <div class="ListItem">
                <?
                    for ($i = 0; $i < $autorCount; $i++) {
                        echo "<p class='Text'><b>Автор:</b> <select name='autor".$i."'>";
                        foreach ($autors as $autor) {
                            echo "<option value='".$autor['ID']."'>".$autor['UF_NAME']."</option>";
                        }
                        echo "</select></p>";
                    }
                ?>
                <div style="padding: 10px"><input type="submit" name="saveBookInfo" value="Сохранить"></div>
                <input type="hidden" name="bookTitle" value="<?=$bookTitle?>">
                <input type="hidden" name="autorCount" value="<?=$autorCount?>">
                <input type="hidden" name="addAutorsToBook" value="true">
            </div>
        </form>
        <?
    } else {
        addNewBook($bookTitle);
        LocalRedirect("/books/");
    }
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>