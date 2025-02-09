<?php

if ($telegramApi->getText() == "مدیریت قرعه کشی") {
    setStep("admin-panel|event_manage");
    $text           = "به قسمت مدیریت قرعه کشی خوش آمدید . \n برای ادامه فرایند لطفا یکی از گزیینه های زیر رو انتخاب نمایید .";
    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => 'لیست تمام قرعه ها',
                ],
            ],
            [
                [
                    'text' => 'لیست قرعه های  فعال',
                ],
                [
                    'text' => 'لیست قرعه های غیر فعال',
                ],
            ],
            [
                [
                    'text' => "افزودن قرعه کشی",
                ],

            ],
            [
                [
                    'text' => "بازگشت به پنل ادمین",
                ],
            ],
        ],
        "resize_keyboard" => true,
    ];
    $telegramApi->sendMessage($text, $reply_keyboard);
    exit(1);
}
include_once "insert-event.php";
include_once "Lottery/all-lottery.php";
include_once "Lottery/active-lottery.php";
include_once "Lottery/Inactive-lottery.php";
