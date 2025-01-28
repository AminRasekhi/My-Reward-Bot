<?php

namespace src\app\Api;

use src\app\Classes\DB;
use src\app\Classes\TelegramAPI;

require_once __DIR__ . "/../../../vendor/autoload.php";
require_once "../../core/initialize.php";

//TelegramAPI Instance
$telegramApi = new TelegramAPI;
// //DB Instance
$sql = new DB();

$user = $sql->table('users')->select()->where('user_id', $telegramApi->getUser_id())->first();
$userStep = $user['step'];

//create or update user 
include_once 'User/CreateUser/create-user.php';

//force join
include_once 'ForcedJoin/forced-join.php';
//User Panel
include_once 'User/user-panel.php';

if ($user['is_admin'] == 1) {
    //Admin Panel
    include_once 'Admin/admin-panel.php';
}