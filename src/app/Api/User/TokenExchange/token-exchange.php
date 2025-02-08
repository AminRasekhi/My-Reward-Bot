<?php

if ($telegramApi->getText() == '🎫تبدیل امتیاز به شانس'){
    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['token_exchange']);
    $lottery_register = $sql->table('event_user')->select()->where('user_id', $user['id'])->get();
    
    $keyboard = [];
    $keyboard = [
        [
            [
                'text' => '🏡بازگشت به صفحه اصلی',
            ],
        ],
    ];

    if (empty($lottery_register) || (count($lottery_register) === 1 && empty($lottery_register[0]))) {
        $text = "شما در هیچ قرعه کشی شرکت نکرده اید !";
    }else {
        $available_lotteries = $sql->table('events')->select()->where('id', $lottery_register['id'])->get();
        
        $text = 'در زیر نام قرعه هایی که در آن شرکت کرده اید و فعال هستند آمده است. برای تخصیص امتیاز های خود به قرعه کشی یکی از قرعه کشی های زیر را که در آن شرکت کرده اید را انتخاب کنید : ';

        foreach ($available_lotteries as $item) {
            if ($item['status'] == 1) {
                $keyboard[] = [
                    [
                        'text' => '🔹 ' . $item['name'],
                    ],
                ];
            }
        }
    }

    $reply_markup = [
        'keyboard' => $keyboard
    ];

    $telegramApi->sendMessage($text, $reply_keyboard);
}


if (strpos($telegramApi->getText(), '🔹 ') === 0) {

    
    $lotteryName = explode('🔹 ', $telegramApi->getText())[1];

    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['token_exchange||'.$lotteryName]);
    
    $lotteryInfo = $sql->table('events')->select()->where('name', $lotteryName)->first();
    $event_user  = $sql->table('event_user')->select()->where('user_id', $user['id'])->where("event_id", $lotteryInfo['id'])->first();

    $text = 'موجودی امتیاز شما : ' . $user['tokens'] . PHP_EOL . PHP_EOL;
    $text .= 'لطفا مقدار امتیازی که میخواهید به شانس تبدیل کنید را برای این قرعه کشی وارد کنید : ' . PHP_EOL;
    $text .= '⚠️توجه کنید که مقدار وارد شده بین عدد 0 تا ' . $user['tokens'] . ' وارد کنید. درصورت عدم تمایل بر روی دکمه بازگشت کلیک کنید.';

    $keyboard = [
        [
            [
                'text' => '🏡بازگشت به صفحه اصلی',
            ],
        ],
    ];

    $reply_keyboard = [
        'keyboard' => $keyboard,
    ];

    $telegramApi->sendMessage($text, $reply_keyboard);
}

if (strpos($user['step'], 'token_exchange||') === 0){
    $score = $telegramApi->getText();
    $score = convertArabicToEnglish($score);
    $lotteryName = explode('|| ', $user['step'])[1];

    $lotteryInfo = $sql->table('events')->select()->where('name', $lotteryName)->first();
    $event_user  = $sql->table('event_user')->select()->where('user_id', $user['id'])->where("event_id", $lotteryInfo['id'])->first();

    if ($score > $user['tokens']) {
        $text = 'مقدار موجودی شما کافی نیست!';
    }elseif ($score < $user['tokens'] && $score > 0) {
        $text = "مقدار $score به قرعه $lotteryName اختصاص یافت.";
        $score = $score + $event_user['lottery_token'];

        $sql->table('event_user')->where('event_user', $event_user['event_id'])->update(['lottery_token'], [$score]);
    }

    $keyboard = [
        [
            [
                'text' => '🏡بازگشت به صفحه اصلی',
            ],
        ],
    ];

    $reply_keyboard = [
        'keyboard' => $keyboard,
    ];

    $telegramApi->sendMessage($text, $reply_keyboard);
}