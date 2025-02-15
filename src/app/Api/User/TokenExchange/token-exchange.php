<?php

if ($telegramApi->getText() == '🎫تبدیل امتیاز به شانس') {
    setStep('token_exchange');
    $lottery_register = $sql->table('event_user')->select()->where('user_id', $telegramApi->getUserID())->get();

    $keyboard = [];
    $keyboard = [
        [
            [
                'text' => '🏡بازگشت به صفحه اصلی',
            ],
        ],
    ];

    if (empty($lottery_register) || (count($lottery_register) === 1 && empty($lottery_register[0]))) {
        $text = "🚫در حال حاضر در هیچ قرعه کشی شرکت نکرده اید!";
    } else {
            $available_lotteries = $sql->table('events')->select()->where('id', $lottery_register['event_id'])->get();

        $text = "🎰در زیر نام قرعه هایی که در آن شرکت کرده اید و فعال هستند آمده است. برای تخصیص امتیاز های خود به قرعه کشی یکی از قرعه کشی های زیر را که در آن شرکت کرده اید را انتخاب کنید : ";

        foreach ($available_lotteries as $item) {
            if ($item['status'] == 1 && strtotime($item['end_date']) > time()) {
                $keyboard[] = [
                    [
                        'text' => '🔹 ' . $item['name'],
                    ],
                ];
            }
        }
    }

    $reply_markup = [
        'keyboard' => $keyboard,
        "resize_keyboard" => true,
    ];

    $telegramApi->sendMessage($text, $reply_markup);
    exit(1);
}

if (strpos($telegramApi->getText(), '🔹 ') === 0) {

    $lotteryName = explode('🔹 ', $telegramApi->getText())[1];
    setStep('token_exchange||' . $lotteryName);

    $lotteryInfo = $sql->table('events')->select()->where('name', $lotteryName)->first();
    $event_user  = $sql->table('event_user')->select()->where('user_id', $user['id'])->where("event_id", $lotteryInfo['id'])->first();

    $text = '💳موجوودی حساب شما : ' . $user['tokens'] . PHP_EOL . PHP_EOL;
    $text .= 'لطفا مقدار امتیازی که میخواهید به شانس تبدیل کنید را برای این قرعه کشی وارد کنید : ' . PHP_EOL . PHP_EOL;
    $text .= '⚠️توجه کنید که مقدار وارد شده بین عدد 0 تا ' . $user['tokens'] . ' وارد کنید. درصورت عدم تمایل بر روی دکمه بازگشت کلیک کنید.' . PHP_EOL . PHP_EOL;
    $text .= '🚫توجه داشته باشید که تبدیل امتیاز به شانس قابل بازگشت نیست!' . PHP_EOL . PHP_EOL;

    $keyboard = [
        [
            [
                'text' => '🏡بازگشت به صفحه اصلی',
            ],
        ],
    ];

    $reply_markup = [
        'keyboard' => $keyboard,
        "resize_keyboard" => true,
    ];

    $telegramApi->sendMessage($text, $reply_markup);
    exit(1);
}

if (strpos($user['step'], 'token_exchange||') === 0) {
    $score       = $telegramApi->getText();
    $score       = convertArabicToEnglish($score);
    $score       = convertPersianToEnglish($score);
    $lotteryName = explode('||', $userStep)[1];
    setStep("successfuly_to_token_exchange");
    $lotteryInfo = $sql->table('events')->select()->where('name', $lotteryName)->first();
    $event_user  = $sql->table('event_user')->select()->where('user_id', $user['id'])->where("event_id", $lotteryInfo['id'])->first();

    (int) $token = $user['tokens'] ?? 0;
    if ($score > $token) {
        $text = '🚫مقدار موجودی شما کافی نیست!';
        exit(1);
    } elseif ($score <= $token) {
        $text = "مقدار $score به قرعه $lotteryName اختصاص یافت✅";
        (int) $lotteryScore += $score + $event_user['lottery_token'];

        $sql->table('event_user')->select()->where("id", $event_user['id'])->update(['lottery_token'], [$lotteryScore]);
        (int) $token -= $score;
        $sql->table('users')->select()->where('id', $user['id'])->update(['tokens'], [$token]);
    } else {
        $text = '🚫مقدار وارد شده صحیح نیست!';
    }

    $keyboard = [
        [
            [
                'text' => '🏡بازگشت به صفحه اصلی',
            ],
        ],
    ];

    $reply_markup = [
        'keyboard' => $keyboard,
        "resize_keyboard" => true,
    ];
    
    $telegramApi->sendMessage($text, $reply_markup);
    exit(1);
}
