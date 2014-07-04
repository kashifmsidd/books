<?
// This file is the template for one menu item iteration

// Set item mark: selected folder, folder, page
if ($ITEM_TYPE=="D")
{
    if ($SELECTED)
        $strDir = "<p class='MenuActive'>";
    else
        $strDir = "<p class='Menu'>";
}
else
{
    if ($SELECTED)
    {
        $strDir = "<p class='MenuActive'>";
        //$strDir_d = "<span class='MenuActive'>";
    }
    else
    {
        $strDir = "<p class='Menu'>";
        //$strDir_d = "<span class='Menu'>";
    }
}

// if $SELECTED then this item is current (active) item
/*if ($SELECTED)
    $strtext = "leftmenuact";
else
    $strtext = "leftmenu";*/

//if $PARAMS["SEPARATOR"]=="Y" this item should be shown with different style applied

/*if ($PARAMS["SEPARATOR"]=="Y")
{
    //$strstyle = " style='background-color: #D5ECE6; border-top: 1px solid #A6D0D7; border-bottom: 1px solid #A6D0D7; padding:8;'";
    $strDir = "<img height='13' src='//www.1c-bitrix.ru.images.1c-bitrix-cdn.ru/bitrix/templates/demo/images/1.gif' width='17' border='0'>";
    $strtext = "leftmenu";
}
else
    $strstyle = " style='padding:8;'";*/


// Content of variable $sMenuProlog is typed just before all menu items iterations
// Content of variable $sMenuEpilog is typed just after all menu items iterations
//$sMenuProlog = "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
//$sMenuEpilog = '<tr><td colspan=2 background="/bitrix/templates/demo/images/l_menu_border.gif"><img src="//www.1c-bitrix.ru.images.1c-bitrix-cdn.ru/bitrix/templates/demo/images/1.gif" width="1" height="1"></td></tr></table>';

// if $PERMISSION > "D" then current user can access this page
if ($PERMISSION > "D")
{
    $sMenuBody = $strDir.'<a href="'.$LINK.'">'.$TEXT.'</a></p>';
}
else
{
    $sMenuBody = $strDir.'<a href="'.$LINK.'" class="Closed">'.$TEXT.'</a></p>';

}
?>