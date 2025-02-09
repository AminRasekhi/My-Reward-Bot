<?php

if (strpos($telegramApi->getText(), '/start') === 0 || $telegramApi->getText() == "🏡بازگشت به صفحه اصلی") {
    setStep('home');
    $text     = "😊کاربر $userFirstName عزیز!" . PHP_EOL . PHP_EOL ;
    $text .= "به صفحه اصلی خوش آمدید." . PHP_EOL . "جهت ادامه، از طریق منو بر روی یکی از دکمه ها کلیک کنید.";
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
            [
                'text' => '🎫تبدیل امتیاز به شانس',
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
    $reply_markup = ['keyboard' => $keyboard , "resize_keyboard" => true];

    $telegramApi->sendMessage($text, $reply_markup);
}

include_once "Lottery/lottery-register.php";
include_once '../Admin/admin-panel.php';
include_once "InviteLink/invite-link.php";
include_once "AccountInformation/account-information.php";
include_once "TokenExchange/token-exchange.php";

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
