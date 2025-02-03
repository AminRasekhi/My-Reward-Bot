<?php

if (strpos($telegramApi->getText(), '/start') === 0 || $telegramApi->getText() == "🏡بازگشت به صفحه اصلی") {

    $text     = "به صفحه ی اصلی خوش آمدید. برای ادامه یکی از گزینه های زیر را انتخاب کنید : ";
    $keyboard =
        [
        [
            [
                'text' => "🎰ثبت نام در قرعه کشی",
            ],
        ],
        [
            [
                'text' => '📊اطلاعات حساب',
            ],
        ],
        [
            [
                'text' => '💰افزایش امتیاز',
            ],
        ],
    ];
    if ($user['is_admin']) {
        $keyboard[] = [
            [
                'text' => "پنل ادمین",
            ],
        ];
    }
    $reply_markup = ['keyboard' => $keyboard];

    $telegramApi->sendMessage($text, $reply_markup);
}

include_once "Lottery/lottery-register.php";
include_once '../Admin/admin-panel.php';
include_once "InviteLink/invite-link.php";
include_once "AccountInformation/account-information.php";

/*
        [
            [
                'text' => 'افزایش امتیاز',
            ],
            [
                'text' => 'تبدیل امتیاز به شانس',
            ],
        ],
    */
