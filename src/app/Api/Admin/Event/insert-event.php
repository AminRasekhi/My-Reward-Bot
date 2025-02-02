<?php

if ($telegramApi->getText() == "افزودن قرعه کشی") {
    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => "بازگشت به پنل ادمین",
                ],
            ],
        ],
    ];

    $text = "این بخش غیر فعال است . \nجهت ادامه فرایند لطفا یکی از گزینه های زیر را انتخاب نمایید .";
    $telegramApi->sendMessage($text, $reply_keyboard);
}
