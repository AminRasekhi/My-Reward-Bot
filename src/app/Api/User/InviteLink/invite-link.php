<?php

if ($telegramApi->getText() == '💰افزایش امتیاز') {
    $invite_link = $user['invite_link']; 
    
    $text = 'برای افزایش امتیاز خود دوستان خود را توسط لینک زیر به ربات دعوت کنید. به ازای هر دعوت ۱ امتیاز به شما تعلق خواهد گرفت.';
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
}
