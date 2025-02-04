<?php

//all lottery
if ($telegramApi->getText() == "لیست تمام قرعه ها") {
    //set step
    setStep("Admin_panel|All_Lottery");

    $lotteries = $sql->table('events')->select()->get();
    $text      = "به قسمت لیست تمام قرعه ها خوش آمدید . \n لطفا یکی از گزیینه های زیر را انتخاب نمایید .";
    foreach ($lotteries as $lottery) {
        $buttons[] = [
            [
                'text' => 'All Lottery || ' . $lottery['name'],
            ],
        ];
    }
    $buttons[] = [
        [
            'text' => 'بازگشت به پنل ادمین',
        ],
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

    $eventObj->setConnectEventTable('name', $lotteryName);
    $eventObj->setLotteryUsers('events.id', $eventObj->getEventID());
    setStep("Admin_panel|All_Lottery_" . $eventObj->getEventID());

    /// menu text
    $text = $eventObj->lotteryManuText();

    /// buttons
    $eventObj->lotteryRelyMarkup($text);

}

//show user in lottery
if ($telegramApi->getText() == "لیست همه افراد شرکت کننده") {
    $lotteryID = end(explode("_", $userStep));
    setStep("admin_panel|show_all_user_in_lottery_" . $lotteryID);
    $eventObj->setConnectEventTable('id', $lotteryID);
    //set step

    $eventObj->showLotterUsers(null, null);
}

if ($telegramApi->getText() == "فعال کردن قرعه کشی") {
    $lotteryID = end(explode("_", $userStep));
    setStep("admin_panel|active_status_lottery_" . $lotteryID);
    $sql->table('events')->select()->where("id", $lotteryID)->update(["status"], [1]);

    showDefaultMenu($eventObj, $lotteryID);

}

if ($telegramApi->getText() == "غیر فعال کردن قرعه کشی") {
    $lotteryID = end(explode("_", $userStep));
    setStep("admin_panel|inactive_status_lottery_" . $lotteryID);
    $sql->table('events')->select()->where("id", $lotteryID)->update(["status"], [0]);

    showDefaultMenu($eventObj, $lotteryID);

}

if ($telegramApi->getText() == "حذف قرعه کشی") {
    $lotteryID = end(explode("_", $userStep));
    setStep("admin_panel|delete_lottery_" . $lotteryID);
    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    "text" => "بله (حذف شدن قرعه کشی)",
                ],

            ],
            [
                [
                    "text" => "خیر (حذف نشدن قرعه کشی)",
                ],
            ],
        ],
    ];
    $text = "آیا مطمئن هستید که میخواهید این قرعه کشی رو حذف کنید ؟ \n با حذف کردن این قرعه کشی تمام اطلاعات از جمله لیست افراد شرکت کننده حذف خواهد شد .";
    $telegramApi->sendMessage($text, $reply_keyboard);
}
if ($telegramApi->getText() == "بله (حذف شدن قرعه کشی)") {
    $lotteryID = end(explode("_", $userStep));
    setStep("admin_panel|confirm_delete_lottery_" . $lotteryID);
    $sql->table('events')->select()->where("id", $lotteryID)->delete();

    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => "بازگشت به پنل ادمین",
                ],

            ],
        ],
    ];
    $text = "قرعه کشی مد نظر شما با موفقیت حذف شد . \n برای ادامه فرایند یکی از گزیینه های زیر رو انتخاب نمایید .";
    $telegramApi->sendMessage($text, $reply_keyboard);
}
if ($telegramApi->getText() == "خیر (حذف نشدن قرعه کشی)") {
    $lotteryID = end(explode("_", $userStep));
    setStep("admin_panel|cancel_delete_lottery_" . $lotteryID);
    showDefaultMenu($eventObj, $lotteryID);
}

if ($telegramApi->getText() == "ویرایش قرعه کشی") {
    $lotteryID = end(explode("_", $userStep));
    setStep("admin_panel|edit_lottery_" . $lotteryID);

    $text = "این بخش غیر فعال است .";
    $telegramApi->sendMessage($text);
}

function showDefaultMenu($eventObj, $lotteryID)
{
    $eventObj->setConnectEventTable("id", $lotteryID);
    $eventObj->setLotteryUsers('events.id', $eventObj->getEventID());

    /// menu text
    $text = $eventObj->lotteryManuText();
    /// buttons
    $eventObj->lotteryRelyMarkup($text);
}
