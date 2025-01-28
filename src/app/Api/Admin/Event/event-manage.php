<?php

if ($telegramApi->getText() == "مدیریت قرعه کشی") {
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
                [
                    'text' => "ویرایش قرعه کشی",
                ],
            ],
            [
                [
                    'text' => "بازگشت به پنل کاربری",
                ],
            ],
        ],
    ];
    $telegramApi->sendMessage($text, $reply_keyboard);
}
include_once "insert-event.php";
include_once "edit-event.php";
