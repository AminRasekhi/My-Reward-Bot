<?php

if ($telegramApi->getText() == '📊اطلاعات حساب') {
    $text = '👤 اطلاعات حساب شما : ' . PHP_EOL . PHP_EOL;

    $InvitedUsers        = $sql->table('users')->select()->where('invited_by_user_id', $user['id'])->get();
    $countOfInvitedUsers = count($InvitedUsers);
    $sql->table('users')->where('user_id', $telegramApi->getUser_id())->update(['tokens'], [$countOfInvitedUsers]);

    $text .= '🔸نام شما : ' . $user['first_name'] . PHP_EOL;
    $text .= '🔹تعداد دعوت شدگان : ' . $countOfInvitedUsers . PHP_EOL;
    $text .= '🔸شانس های شما : ' . ($countOfInvitedUsers * ODDS_RATIO) . PHP_EOL;

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
