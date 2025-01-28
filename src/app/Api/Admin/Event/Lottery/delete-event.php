<?php

$pattern = "/^\d+-حذف قرعه کشی$/u";
if (preg_match($pattern, $telegramApi->getText())) {
    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => "بازگشت به پنل ادمین",
                ],
            ],
        ],
    ];

    $text = "بخش حذف قرعه\n" . "این بخش غیر فعال است . \nجهت ادامه فرایند لطفا یکی از گزیینه های زیر را انتخاب نمایید .";
    $telegramApi->sendMessage($text, $reply_keyboard);
}
