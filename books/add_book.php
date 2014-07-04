<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>

    <p class="subHead">
        Информация о новой книге
    </p>

    <form name="addBook" action="" method="post">
        <div class="ListItem">
            <p class='Text'><b>Название:</b> <input type="text" name="bookTitle" class="Text"></p>
            <p class='Text'><b>Количество авторов:</b> <select name="autorCount">
                <?
                    for ($i = 0; $i < 6; $i++) {
                        echo "<option value='".$i."'>".$i."</option>";
                    }
                ?>
                </select></p>
            <div style="padding: 10px"><input type="submit" name="addAutorsToBook" value="Далее" onclick="addBook.action='add_autors_to_book.php'"></div>
        </div>
    </form>

<?

if (isset($_SESSION['BookMessage'])) {
    echo "<p class='Text'>".$_SESSION['BookMessage']."</p>";
    unset($_SESSION['BookMessage']);
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>