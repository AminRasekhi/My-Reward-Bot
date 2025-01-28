<?php

//all lottery
if ($telegramApi->getText() == "لیست تمام قرعه ها") {
    //set step
    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['Admin_panel|All_Lottery']);

    $lotteries = $sql->table('events')->select()->get();
    $text      = "به قسمت لیست تمام قرعه ها خوش آمدید . \n لطفا یکی از گزیینه های زیر را انتخاب نمایید .";
    foreach ($lotteries as $lottery) {
        $buttons[] = [
            'text' => 'All Lottery || ' . $lottery['name'],
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
if (strpos($telegramApi->getText(), "All Lottery || ") === 0) {
    $lotteryName = explode("|| ", $telegramApi->getText())[1];

    //set step
    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['Admin_panel|All_Lottery_' . $lottery['id']]);
   
    $lotteryName = explode("|| ", $telegramApi->getText())[1];
    $eventObj->setConnectEventTable('name', $lotteryName);
    $eventObj->setLotteryUsers('event.id' , $eventObj->getEventID());

    /// menu text
    $eventObj->lotteryManuText();

    /// buttons
    $eventObj->lotteryRelyMarkup();

}

include_once "show-user-in-lottery.php";
