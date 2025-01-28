<?php

//all lottery
if ($telegramApi->getText() == "لیست تمام قرعه ها") {
    $lotteries = $sql->table('events')->select()->get();
    $text      = "به قسمت لیست تمام قرعه ها خوش آمدید . \n لطفا یکی از گزیینه های زیر را انتخاب نمایید .";
    foreach ($lotteries as $lottery) {
        $buttons[] = [
            'text' => 'lottery || ' . $lottery['name'],
        ];
    }
    $buttons[] = [
        'text' => 'بازگشت به پنل ادمین',
    ];
    $reply_keyboard = [
        'keyboard' => $buttons,
    ];
    $telegramApi->sendMessage($text, $reply_keyboard);
}

//single lottery
if (strpos($telegramApi->getText(), "lottery || ") === 0) {
    $lotteryName    = explode("|| ", $telegramApi->getText())[1];
    $lottery        = $sql->table('events')->select()->where('name', $lotteryName)->get();
    $usersInLottery = $sql->table('events')->select()
        ->join('event_user')->on('events', 'id', 'events', 'id')
        ->join('users')->on('users', 'id', 'event_user', 'id')
        ->where('events.id', $lottery['id'])->get();
    $userCountInLottery = count($usersInLottery);

    $text = "نمایش اطلاعات قرعه کشی " . $lotteryName .
        "\nنام : " . $lottery['name'] .
        "\nتوضیحات : " . $lottery['description'] .
        "\nتعداد ثبت نام کنندگان :‌" . $userCountInLottery .
        "\nتاریخ شروع : " . $lottery['start_date'] .
        "\nتاریخ پایان : " . $lottery['end_date'];

    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => 'لیست افراد شرکت کننده',
                ],
            ],
            [
                [
                    'text' => 'ویرایش قرعه کشی',
                ],
                [
                    'text' => 'حذف قرعه کشی',
                ],
            ],
            [
                [
                    'text' => 'بازگشت به پنل ادمین',
                ],
            ],
        ],
    ];

    $telegramApi->sendMessage($text, $reply_keyboard);
}
