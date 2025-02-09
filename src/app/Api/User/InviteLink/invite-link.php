<?php

if ($telegramApi->getText() == '💰افزایش امتیاز') {
    $invite_link = $user['invite_link'];

    $text = 'شما میتوانید به ازای دعوت دوستان خود ' . ODDS_RATIO . ' شانس دریافت کنید.';
    $text .= "\n\n" . $invite_link;

   $reply_markup = [
        'inline_keyboard' => [
            [
                [
                    'text' => 'اشتراک گذاری📤',
                    'switch_inline_query' => $text,
                ],
            ],
           
        ],
    ];

    $telegramApi->sendMessage($text, $reply_markup);
}
