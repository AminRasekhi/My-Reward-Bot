<?php

namespace src\app\Api\Admin;

if (strpos($telegramApi->getText(), '/start') === 0) {

    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['home']);

    if ($user['is_admin']) {
        $buttons[] = ['پنل ادمین'];

        $text = " به پنل ادمین خوش آمدید ";
    }
    else {
        $buttons = [
            ['👤 اطلاعات حساب', '💎 افزایش امتیاز'],
            ['💳 تبدیل امتیاز به شانس'],
            ['🎰 ثبت نام در قرعه کشی'],
        ];

        $text = " به پنل کاربر خوش آمدید ";
    }


    $telegramApi->sendMessage($text, $buttons);
    $telegramApi->sendMessage($text, $buttons);
} elseif ($telegramApi->getText() == 'بازگشت به صفحه اصلی') {
    
    $telegramApi->deleteMessage();

    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['home']);

    $text = ' ' . PHP_EOL . 'به منوی اصلی وارد شدی!🏡' . PHP_EOL;
    if ($user['is_admin']) {
        $buttons[] = ['پنل ادمین'];
    }
    else {
        $buttons = [
            ['👤 اطلاعات حساب', '💎 افزایش امتیاز'],
            ['💳 تبدیل امتیاز به شانس'],
            ['🎰 ثبت نام در قرعه کشی'],
        ];
    }
    
    $telegramApi->sendMessage($text, $buttons);
}

// invite-link
include_once "InviteLink/invite-link-manage.php";

//airdrop-task
include_once "AirdropTask/airdrop-tasks.php";

//news
include_once "News/news-manage.php";

//add-list
include_once "AddList/add-list-manage.php";

//support
include_once "Support/support-manage.php";

//help
include_once "Help/help.php";

//airdop link
include_once "AirdropLink/airdrop-link.php";

//firends list
include_once "Friend/friend-manage.php";