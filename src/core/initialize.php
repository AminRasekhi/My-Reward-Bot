<?php
namespace src\core;

if (! defined("TOKEN")) {
    define("TOKEN", '');
}
if (! defined("ODDS_RATIO")) {
    define("ODDS_RATIO", '1');
}
if (! defined("DOMAIN")) {
    define('DOMAIN', 'https://moblekhoshrang.ir/');
}
if (! defined('API')) {
    define('API', "https://api.telegram.org/bot" . TOKEN . "/");
}
if (! defined('BOT_USERNAME')) {
    define('BOT_USERNAME', '');
}
if (! defined('BOT_NAME')) {
    define('BOT_NAME', 'My Reward Bot');
}
//DB Config
if (! defined('DB_NAME')) {
    /// local ///
    define('DB_NAME', 'eventBot');

    /// host ///
    // define('DB_NAME', 'moblekho_eventBot');
}
if (! defined('DB_USERNAME')) {
    /// local ///
    define('DB_USERNAME', 'root');

    /// host ///
    // define('DB_USERNAME', 'moblekho_hmd');
}
if (! defined('DB_PASSWORD')) {
    /// local ///
    define('DB_PASSWORD', '');

    /// host ///
    // define('DB_PASSWORD', 'W!(ji}H(V$!e');
}
if (! defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}
if (! defined('PROFILE_BOT_ID')) {
    define('PROFILE_BOT_ID', "AgACAgQAAxkBAAIBFGcIR-2ZlaWt-dN3hqcqYU2bYIGNAAI_yjEbDdpIUPREWcXQ2S8eAQADAgADeAADNgQ");
}

// https://api.telegram.org/bot6690815299:AAEBLpCN_tuDe8ZpLwNvwUvOYlwAoRItqGc/
// https://api.telegram.org/bot6690815299:AAEBLpCN_tuDe8ZpLwNvwUvOYlwAoRItqGc/setWebHook?url=https://moblekhoshrang.ir/TelegramBot/src/app/Api/index.php
