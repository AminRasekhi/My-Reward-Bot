<?php

if ($telegramApi->getText() == "لیست همه افراد شرکت کننده") {

    $lotteryID = end(explode("_", $userStep));
    $lottery   = $sql->table('events')->select()->where('id', $lotteryID)->get();

    //set step
    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['Admin_panel|Lottery_Show_Users']);

    $usersInLottery = $sql->table('events')->select()
        ->join('event_user')->on('events', 'id', 'events', 'id')
        ->join('users')->on('users', 'id', 'event_user', 'id')
        ->where('events.id', $lottery['id'])->get();

    $usersInfo = "نمایش لیست کاربران ثبت نام شده در  " . $lottery['name'] . PHP_EOL . PHP_EOL . PHP_EOL;

    $usersInLottery = array_chunk($usersInLottery, 90);
    foreach ($users as $userPages) {
        foreach ($userPages as $user) {
            $usersInfo .= "Name : " . $user['first_name'] . " " . $user['last_name'] . PHP_EOL . "Username : " . "@" . $user['username'] . PHP_EOL . PHP_EOL;
        }
        $telegramApi->sendMessage($usersInfo);
        $usersInfo = "";
    }
    $text = "برای ادامه کار لطفا یکی از گزیینه های زیر را انتخاب نمایید";

    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => 'بازگشت به پنل ادمین',
                ],
            ],
        ],
    ];

    $telegramApi->sendMessage($text, $reply_markup);

}
