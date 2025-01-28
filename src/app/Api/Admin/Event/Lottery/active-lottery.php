<?php

//all lottery
if ($telegramApi->getText() == "لیست قرعه های  فعال") {
    $lotteries = $sql->table('events')->select()->where('status', 1)->get();
    $text      = "به قسمت لیست قرعه های فعال خوش آمدید . \n لطفا یکی از گزیینه های زیر را انتخاب نمایید .";
    foreach ($lotteries as $lottery) {
        $buttons[] = [
            'text' => 'Active Lottery || ' . $lottery['name'],
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
if (strpos($telegramApi->getText(), "Active Lottery || ") === 0) {
    $lotteryName = explode("|| ", $telegramApi->getText())[1];

    //set step
    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['Admin_panel|Active_Lottery_' . $lottery['id']]);

    $eventObj->setConnectEventTable('name', $lotteryName);
    $eventObj->setLotteryUsers('event.id', $eventObj->getEventID());

    /// menu text
    $eventObj->lotteryManuText();

    /// buttons
    $eventObj->lotteryRelyMarkup();

}

include_once "show-user-in-lottery.php";
