<?php
namespace src\app\Api\Admin;

if (strpos($telegramApi->getText(), '/start') === 0 && $telegramApi->getText() == "return_to_home") {

    //// reply_markup
    // lottery register
    // invite link
    // admin panel

}

include_once "../Admin/admin-panel.php";
include_once "./InviteLink/invite-link.php";
include_once "./Lottery/lottery-register.php";
