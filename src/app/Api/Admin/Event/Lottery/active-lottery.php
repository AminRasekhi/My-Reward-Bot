<?php

if ($telegramApi->getText() == "لیست قرعه های  فعال") {

    $text = " بخش لیست قرعه های فعال .\n" . "این بخش غیر فعال است . \nجهت ادامه فرایند لطفا یکی از گزیینه های زیر را انتخاب نمایید .";
    $telegramApi->sendMessage($text);
}

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
        "resize_keyboard" => true,
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

//show user in lottery
if ($telegramApi->getText() == "لیست همه افراد شرکت کننده") {
    $lotteryID = end(explode("_", $userStep));

    $eventObj->setConnectEventTable('id', $lotteryID);
    //set step
    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['step'], ['Admin_panel|Active_Lottery_Show_Users']);

    $eventObj->showLotterUsers('events.id', $eventObj->getEventID());
}
