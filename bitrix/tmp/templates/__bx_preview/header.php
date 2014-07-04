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
    <div class="LeftColumn">
        <div class="Menu">
            <? echo $APPLICATION->GetMenuHtml("left", true); ?>
        </div><!--.Menu-->
        <div class="Auth">
            <p class="Text">Пользователь</p>
            <?$APPLICATION->IncludeComponent("bitrix:system.auth.form","",Array(
                    "REGISTER_URL" => "register.php",
                    "FORGOT_PASSWORD_URL" => "",
                    "PROFILE_URL" => "profile.php",
                    "SHOW_ERRORS" => "Y"
                )
            );?>
            <?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", Array(
                    "REGISTER_URL" => "register.php",
                    "PROFILE_URL" => "profile.php",
                    "SHOW_ERRORS" => "Y"
                ),
                false
            );?>
        </div><!--.Auth-->
    </div><!--.LeftColumn-->
    <div class="Content">
