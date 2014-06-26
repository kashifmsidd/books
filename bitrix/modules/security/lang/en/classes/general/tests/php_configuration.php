<?
$MESS["SECURITY_SITE_CHECKER_PhpConfigurationTest_NAME"] = "PHP settings check";
$MESS["SECURITY_SITE_CHECKER_PHP_ENTROPY"] = "No additional entropy source for session ID is defined";
$MESS["SECURITY_SITE_CHECKER_PHP_ENTROPY_RECOMMENDATION"] = "Add the following line to the PHP settings:<br>session.entropy_file = /dev/urandom<br>session.entropy_length = 128";
$MESS["SECURITY_SITE_CHECKER_PHP_INCLUDE"] = "URL wrappers are enabled";
$MESS["SECURITY_SITE_CHECKER_PHP_INCLUDE_DETAIL"] = "This option is absolutely not recommended.";
$MESS["SECURITY_SITE_CHECKER_PHP_INCLUDE_RECOMMENDATION"] = "Add or edit the following line in the PHP settings:<br>allow_url_include = Off";
$MESS["SECURITY_SITE_CHECKER_PHP_FOPEN"] = "Read access for URL wrappers is enabled";
$MESS["SECURITY_SITE_CHECKER_PHP_FOPEN_DETAIL"] = "This option is not required, but may possibly be used by an attacker.";
$MESS["SECURITY_SITE_CHECKER_PHP_FOPEN_RECOMMENDATION"] = "Add or edit the following line in the PHP settings:<br>allow_url_fopen = Off";
$MESS["SECURITY_SITE_CHECKER_PHP_ASP"] = "ASP style tags are enabled";
$MESS["SECURITY_SITE_CHECKER_PHP_ASP_DETAIL"] = "Only a few developers know that this option exists. This option is redundant.";
$MESS["SECURITY_SITE_CHECKER_PHP_ASP_RECOMMENDATION"] = "Add or edit the following line in the PHP settings:<br>asp_tags = Off";
$MESS["SECURITY_SITE_CHECKER_LOW_PHP_VERSION_ENTROPY"] = "Version of php is outdated";
$MESS["SECURITY_SITE_CHECKER_LOW_PHP_VERSION_ENTROPY_DETAIL"] = "The current version of php does not support the installation of an additional source of entropy when creating a session ID";
$MESS["SECURITY_SITE_CHECKER_LOW_PHP_VERSION_ENTROPY_RECOMMENDATION"] = "Update php to version 5.3.3 or higher, ideally to the most recent stable version";
$MESS["SECURITY_SITE_CHECKER_PHP_ENTROPY_DETAIL"] = "The lack of additional entropy may be used to predict random numbers.";
$MESS["SECURITY_SITE_CHECKER_PHP_HTTPONLY"] = "Cookies are accessible from JavaScript";
$MESS["SECURITY_SITE_CHECKER_PHP_HTTPONLY_DETAIL"] = "Making cookies accessible from JavaScript will increase severity of successful XSS attacks.";
$MESS["SECURITY_SITE_CHECKER_PHP_HTTPONLY_RECOMMENDATION"] = "Add or edit the following line in the PHP settings:<br>session.cookie_httponly = On";
$MESS["SECURITY_SITE_CHECKER_PHP_COOKIEONLY"] = "Session ID's are saved in other storages besides cookies";
$MESS["SECURITY_SITE_CHECKER_PHP_COOKIEONLY_DETAIL"] = "Saving a session ID in places other than cookies may lead to session hijacking.";
$MESS["SECURITY_SITE_CHECKER_PHP_COOKIEONLY_RECOMMENDATION"] = "Add or edit the following line in the PHP settings:<br>session.use_only_cookies = On";
$MESS["SECURITY_SITE_CHECKER_PHP_MBSTRING_SUBSTITUTE"] = "Mbstring deletes invalid characters";
$MESS["SECURITY_SITE_CHECKER_PHP_MBSTRING_SUBSTITUTE_DETAIL"] = "The ability to delete invalid characters may be exploited for the so-called invalid byte sequence attacks.";
$MESS["SECURITY_SITE_CHECKER_PHP_MBSTRING_SUBSTITUTE_RECOMMENDATION"] = "In PHP settings, change the value of mbstring.substitute_character to anything but \"none\".";
?>