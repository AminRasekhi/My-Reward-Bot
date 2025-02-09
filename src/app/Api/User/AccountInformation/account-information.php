<?php

if ($telegramApi->getText() == '📊اطلاعات حساب') {
    setStep('account_information');
    $text = '👤 اطلاعات حساب شما : ' . PHP_EOL . PHP_EOL;

    $InvitedUsers        = $sql->table('users')->select()->where('invited_by_user_id', $user['id'])->get();
    $countOfInvitedUsers = count($InvitedUsers);

    $lottery_register = $sql->table('event_user')->select()->where('user_id', $telegramApi->getUserID())->get();

    $text .= '🔸نام شما : ' . $user['first_name'] . PHP_EOL;
    $text .= '🔹تعداد دعوت شدگان : ' . $countOfInvitedUsers . PHP_EOL;
    $text .= '🔸شانس های شما : ' . $user['tokens'] . PHP_EOL . PHP_EOL;

    $text .= '📝وضعیت قرعه کشی های شما : ' . PHP_EOL . PHP_EOL;

    if (empty($lottery_register) || (count($lottery_register) == 1 && empty($lottery_register[0]))) {
        $text .= "شما در هیچ قرعه کشی شرکت نکرده اید !";
    } else {
        // join : event_user AND events
        $available_lotteries = $sql->table("events")->select(["events.name", "events.award", "events.description", "events.rules_description", "events.start_date", "events.end_date"])->join("event_user")->on("events", "id", "event_user", "event_id")->where("user_id", $user['id'])->get();
        // $available_lotteries = $sql->table('events')->select()->where('id', $lottery_register['event_id'])->get();
        foreach ($available_lotteries as $item) {
            $text .= '🪙 نام قرعه : ' . $item['name'] . PHP_EOL;
            $text .= '🪙 توضیحات : ' . $item['description'] . PHP_EOL;
            $text .= '🪙 قوانین : ' . $item['rules_description'] . PHP_EOL;
            $text .= '🪙 جوایز : ' . $item['award'] . PHP_EOL;
            $text .= '🪙 تاریخ شروع : ' . jalaliDate($item['start_date']) . PHP_EOL;                      // Convert Time stamp format to Real date
            $text .= '🪙 تاریخ پایان : ' . jalaliDate($item['end_date']) . PHP_EOL;                      // Convert Time stamp format to Real date
            $text .= '🪙 تعداد شانس اختصاص یافته به این قرعه : ' . PHP_EOL . PHP_EOL; // Write Token numbers
        }
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
        'keyboard' => $keyboard,
    ];

    $telegramApi->sendMessage($text, $reply_markup);
}
