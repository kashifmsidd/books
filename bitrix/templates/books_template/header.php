<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <?$APPLICATION->ShowHead()?>
    <title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
    <?$APPLICATION->ShowPanel();?>
    <div class="Header">
        <p id="headIndex" align="center">Электронная библиотека</p>
    </div><!--.Header-->
    <div class="Content">
        <div class="Menu">
            <? echo $APPLICATION->GetMenuHtml("left", true); ?>
        </div>