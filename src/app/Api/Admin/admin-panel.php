<?php

if ($telegramApi->getText() == "پنل ادمین" || $telegramApi->getText() == "بازگشت به پنل ادمین") {
    $text           = "به پنل مدیریت خوش امدید .\n لطفا برای ادامه کار یکی از دکمه های زیر رو انتخاب نمایید .";
    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => "مدیریت قرعه کشی",
                ],
                [
                    'text' => "🏡بازگشت به صفحه اصلی",
                ],
            ],
        ],
    ];
    $telegramApi->sendMessage($text, $reply_keyboard);
}
include_once "Event/event-manage.php";
