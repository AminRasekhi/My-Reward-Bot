<?php

if ($telegramApi->getText() == '💰افزایش امتیاز') {
    $invite_link = $user['invite_link']; 
    
    $text = 'شما میتوانید به ازای دعوت دوستان خود ' . ODDS_RATIO . ' شانس دریافت کنید.'; 
    $text .= $invite_link;

    $keyboard = 
    [
        [
            [
                'text' => '🏡بازگشت به صفحه اصلی',
            ],
        ],
    ];

    $reply_keyboard = [
        'keyboard' => $keyboard
    ];

    $telegramApi->sendMessage($text, $reply_markup);
}
