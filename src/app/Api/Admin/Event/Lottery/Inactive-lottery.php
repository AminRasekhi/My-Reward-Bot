<?php

if ($telegramApi->getText() == 'لیست قرعه های غیر فعال') {
    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => "بازگشت به پنل ادمین",
                ],
            ],
        ],
    ];

    $text = " بخش لیست قرعه های غیر فعال .\n" . "این بخش غیر فعال است . \nجهت ادامه فرایند لطفا یکی از گزیینه های زیر را انتخاب نمایید .";
    $telegramApi->sendMessage($text, $reply_keyboard);
}
