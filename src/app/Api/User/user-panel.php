<?php
namespace src\app\Api\Admin;

if (strpos($telegramApi->getText(), '/start') === 0 && $telegramApi->getText() == "بازگشت به صفحه اصلی") {

    $text = "به صفحه ی اصلی خوش آمدید. برای ادامه یکی از گزینه های زیر را انتخاب کنید : ";
    $keyboard = 
    [
        [
            [
                'text' => 'ثبت نام در قرعه کشی',
            ],
        ],
        [
            [
                'text' => 'افزایش امتیاز',
            ],
            [
                'text' => 'تبدیل امتیاز به شانس',
            ],
        ],
        [
            [
                'text' => 'اطلاعات حساب',
            ],
        ],
    ];
    $reply_markup = [ 'keyboard' => $keyboard ];
    // lottery register
    // invite link
    // admin panel

}

include_once "../Admin/admin-panel.php";
include_once "./InviteLink/invite-link.php";
include_once "./Lottery/lottery-register.php";
