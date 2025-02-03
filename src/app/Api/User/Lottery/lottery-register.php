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
            $text .= '🔹 ' . $lottery['name'] . PHP_EOL;
            //$text .= $lottery['name'] . ' : ' . $lottery['description'] . PHP_EOL;
            $keyboard = [
                [
                    'text' => '🔸 ' .  $lottery['name']
                ],
            ];
        }
    }

    $reply_keyboard = [
        'keyboard' => $keyboard
    ];

    $telegramApi->sendMessage($text, $reply_keyboard);
}


if (strpos($telegramApi->getText(), '🔸 ') === 0) {
    
    $lotteryName = explode('🔸 ', $telegramApi->getText())[1];
    $lotteryInfo = $sql->table('events')->select()->where('name', $lotteryName)->first();
    $event_user = $sql->table('event_user')->select()->where('user_id', $user['id'])->first();
    $lotteryID = $lotteryInfo['id'];
    $lotteryStart = $lotteryInfo['start_date'];
    $lotteryEnd = $lotteryInfo['end_date'];

    if ($event_user['event_id'] == $lotteryID && $event_user['user_id'] == $user['id']) {
        $text = 'شما قبلا در این قرعه کشی شرکت کرده اید!';
    }else {
        $fields = ['event_id', 'user_id'];
        $values = [$lotteryID, $user['id']];
        $result = $sql->table('event_user')->insert($fields, $values);

        $text = 'با موفقیت در قرعه کشی شرکت داده شدید.';
    }
    
    $keyboard = 
    [
        [
            [
                'text' => '🏡بازگشت به صفحه اصلی',
            ],
        ],
    ];

    $reply_keyboard = [
        'keyboard' => $keyboard
    ];

    $telegramApi->sendMessage($text, $reply_keyboard);
}
    //// reply_markup
    // register in lotteries
    //back to home page

