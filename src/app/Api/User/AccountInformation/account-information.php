<?php

if ($telegramApi->getText() == '📊اطلاعات حساب') {
    $text = '👤 اطلاعات حساب شما : ' . PHP_EOL . PHP_EOL;

    $InvitedUsers        = $sql->table('users')->select()->where('invited_by_user_id', $user['id'])->get();
    $countOfInvitedUsers = count($InvitedUsers);
    $score = $sql->table('users')->select('tokens')->where('user_id', $telegramApi->getUser_id())->first();

    $text .= '🔸نام شما : ' . $user['first_name'] . PHP_EOL;
    $text .= '🔹تعداد دعوت شدگان : ' . $countOfInvitedUsers . PHP_EOL;
    $text .= '🔸شانس های شما : ' . $score . PHP_EOL;

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
