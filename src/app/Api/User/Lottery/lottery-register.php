<?php


if ($telegramApi->getText() == '🎰ثبت نام در قرعه کشی') {
    
    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['lottery_register']);
    $lotteries = $sql->table('events')->select()->where('status', 1)->get();

    $keyboard = [];
    $keyboard = 
    [
        [
            [
                'text' => '🏡بازگشت به صفحه اصلی',
            ],
        ],
    ];

    if (empty($lotteries) || (count($lotteries) === 1 && empty($lotteries[0]))) {
        $text = "درحال حاضر قرعه کشی فعال وجود ندارد!";
    } else {
        $text = "قرعه کشی مورد نظر را انتخاب کنید : " . PHP_EOL . PHP_EOL;
        foreach ($lotteries as $lottery) {
            $text .= $lottery['name'] . ' : ' . $lottery['description'] . PHP_EOL;
            $keyboard = [
                [
                    'text' => '🔸' .  $lottery['name']
                ],
            ];
        }
    }

    $reply_keyboard = [
        'keyboard' => $keyboard
    ];

    $telegramApi->sendMessage($text, $reply_keyboard);
}

    //// reply_markup
    // register in lotteries
    //back to home page

