<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Главная");
?><h1>Электронная библиотека</h1>
<h2>Каталог книг</h2>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog",
	"",
	Array(
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>