<?php

if ($telegramApi->getText() == "افزودن قرعه کشی") {
    setStep("admin_panel|add_lottery");
    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => "بازگشت به پنل ادمین",
                ],
            ],
        ],
    ];

    $text = "لطفا یک نام برای قرعه کشی وارد نمایید .";
    $telegramApi->sendMessage($text, $reply_keyboard);
    exit(1);
}
// set lottery name AND send message for give description for lottery
if ($userStep == "admin_panel|add_lottery") {
    $lotteryName = $telegramApi->getText();
    $lotteryID   = $sql->table('events')->insert(['name'], [$lotteryName]);
    setStep("admin_panel|add_lottery_name-" . $lotteryID);

    $text = "لطفا توضیحات برای قرعه کشی وارد نمایید .";
    menuToSendMessage($lotteryID, $text, $telegramApi);
}
// set lottery description AND send message for give Rules_Description
if (strpos($userStep, "admin_panel|add_lottery_name") === 0) {
    $lotteryID          = explode("-", $userStep)[1];
    $lotteryDescription = $telegramApi->getText();
    $sql->table('events')->select()->where("id", $lotteryID)->update(['description'], [$lotteryDescription]);

    setStep("admin_panel|add_lottery_description-" . $lotteryID);
    $text = "لطفا قوانین برای این قرعه کشی را وارد نمایید .";
    menuToSendMessage($lotteryID, $text, $telegramApi);
}

// set lottery rules_description AND send message for give award
if (strpos($userStep, "admin_panel|add_lottery_description") === 0) {
    $lotteryID               = explode("-", $userStep)[1];
    $lotteryRulesDescription = $telegramApi->getText();
    $sql->table('events')->select()->where("id", $lotteryID)->update(['rules_description'], [$lotteryRulesDescription]);

    setStep("admin_panel|add_lottery_rules_description-" . $lotteryID);
    $text = "لطفا جوایز برای این قرعه کشی را وارد نمایید .";
    menuToSendMessage($lotteryID, $text, $telegramApi);
}

// set lottery award AND send message for give status
if (strpos($userStep, "admin_panel|add_lottery_rules_description") === 0) {
    $lotteryID    = explode("-", $userStep)[1];
    $lotteryAward = $telegramApi->getText();
    $sql->table('events')->select()->where("id", $lotteryID)->update(['award'], [$lotteryAward]);

    setStep("admin_panel|add_lottery_award-" . $lotteryID);
    $text = "لطفا وضعیت قرعه کشی را مشخص نمایید از روی منو  .\nدرصورتی که روی حالت فعال باشه و در بازه زمانی قرعه کشی باشد به کاربران نمایش داده خواهد شد .";

    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => "فعال",
                ],
                [
                    'text' => "غیر فعال",
                ],
            ],
            [
                [
                    'text' => "کنسل کردن قرعه کشی شماره " . "-" . $lotteryID,
                ],
            ],
        ],
    ];
    $telegramApi->sendMessage($text, $reply_keyboard);
    exit(1);
}

// set lottery status AND send message for give end_date
if (strpos($userStep, "admin_panel|add_lottery_award") === 0) {
    $lotteryID           = explode("-", $userStep)[1];
    $lotteryStatus       = $telegramApi->getText();
    $lotteryStatusNumber = $lotteryStatus == "فعال" ? 1 : 0;
    $sql->table('events')->select()->where("id", $lotteryID)->update(['status'], [$lotteryStatusNumber]);

    setStep("admin_panel|add_lottery_status-" . $lotteryID);
    $text = "این قرعه کشی بعد از چند روز به پایان برسد . لطفا فقط عدد وارد نمایید . (مثلا : ۱۰ یا ۲۰  یا ۱۰۰ یا ...)";
    menuToSendMessage($lotteryID, $text, $telegramApi);
}
// set lottery end_date AND execute
if (strpos($userStep, "admin_panel|add_lottery_status") === 0) {
    $lotteryID          = explode("-", $userStep)[1];
    $lotteryEndDateDays = $telegramApi->getText();
    if (! is_numeric($lotteryEndDateDays)) {
        $text = "لطفا فقط عدد وارد نمایید .";
        $telegramApi->sendMessage($text, $reply_keyboard);
        exit(1);
    }
    $lotteryEndDate = date("Y-m-d H:i:s", strtotime("now " . $lotteryEndDateDays . " days"));
    $sql->table('events')->select()->where("id", $lotteryID)->update(['end_date'], [$lotteryEndDate]);

    setStep("admin_panel|add_lottery_end_date-" . $lotteryID);
    $text           = "قرعه کشی شما با موفقیت ثبت شد .";
    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => "بازگشت به پنل ادمین",
                ],
            ],
        ],
    ];
    $telegramApi->sendMessage($text, $reply_keyboard);
    exit(1);
}

//cancel lottery
if (strpos($telegramApi->getText(), "کنسل کردن قرعه کشی شماره") === 0) {
    cancelLottery($sql, $telegramApi);
}

function cancelLottery($sql, $telegramApi, $text = "عملیات با موفقیت کنسل شد .")
{
    setStep("admin-panel|cancel_insert_lottery");
    $lotteryID = explode("-", $telegramApi->getText())[1];
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
    $telegramApi->sendMessage($text, $reply_keyboard);
    exit(1);
}

function menuToSendMessage($lotteryID, $text, $telegramApi)
{
    $reply_keyboard = [
        'keyboard' => [
            [
                [
                    'text' => "کنسل کردن قرعه کشی شماره " . "-" . $lotteryID,
                ],
            ],
        ],
    ];
    $telegramApi->sendMessage($text, $reply_keyboard);
    exit(1);
}
