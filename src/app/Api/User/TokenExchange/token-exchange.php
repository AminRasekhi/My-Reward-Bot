<?php

if ($telegramApi->getText() == '🎫تبدیل امتیاز به شانس'){
    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['token_exchange']);
    $lottery_register = $sql->table('event_user')->select()->where('user_id', $user['id'])->get();
    
    $keyboard = [];
    $keyboard =
        [
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
