<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

?><script type="text/javascript">
var jsDLG_<?php echo $arParams['CONTROL_ID']?> = new BX.CDialog({
	'content_url': '<?php echo CUtil::JSEscape($arParams['~CONTENT_URL'])?>',
	'draggable': true,
	'resizable': true
});


</script><?php

if ('Y' == $arParams['SEPARATE_BUTTON'])
{
	?><div class="mea-cont"><?php
}
?><input class="mes-button" type="button" value="<?php echo ('' != $arParams['BUTTON_CAPTION'] ? $arParams['BUTTON_CAPTION'] : '...'); ?>" title="<?php echo ('' != $arParams['BUTTON_TITLE'] ? $arParams['BUTTON_TITLE'] : ''); ?>" onClick="jsDLG_<?php echo $arParams['CONTROL_ID']?>.Show();"><?php
if ('Y' == $arParams['SEPARATE_BUTTON'])
{
	?></div><?php
}