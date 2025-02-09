<?php

if ($telegramApi->getText() == '💰افزایش امتیاز') {
    $invite_link = $user['invite_link'];

    $text = "💳کاربر عزیز" . PHP_EOL;
    $text .= "شما میتوانید با استفاده از لینک مخصوص به خودتان دوستانتان را به ربات ما دعوت کنید و " . ODDS_RATIO . " تا امتیاز دریافت کنید." . PHP_EOL;

    $telegramApi->sendMessage($text);

    $text = "\n\n سلام دوست عزیز😊\nبا استفاده از لینک زیر میتونی به جمع ما ملحق بشی تا بتونی در قرعه کشی های مخلتفی که براتون در نظر گرفتیم شرکت کنی.\n شاید تو یکی از برنده های ما باشی" . PHP_EOL . PHP_EOL . "👇👇👇👇👇" . $invite_link;

    $reply_markup = [
        'inline_keyboard' => [
            [
                [
                    'text'                => 'اشتراک گذاری📤',
                    'switch_inline_query' => $text,
                ],
            ],

        ],
    ];

    $telegramApi->sendMessage($text, $reply_markup);
}
