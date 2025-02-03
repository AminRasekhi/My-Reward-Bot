<?php
$channels = $sql->table('channels')->select(['channel_name', 'channel_id'])->get();

$channels_text = "برای استفاده از ربات لطفا در کانال های زیر عضو شوید" . PHP_EOL . PHP_EOL;

foreach ($channels as $channel) {
    $channels_text .= PHP_EOL . " ⭕ " . $channel['channel_id'];
}

$channels_text .= PHP_EOL . PHP_EOL . "و سپس  دکمه ی عضویت✅ را کلیک کنید";

function checkUserInChannels($channels)
{
    global $telegramApi;
    foreach ($channels as $channel) {

        $chat_member = $telegramApi->getChatMember($channel['channel_id'], $telegramApi->getUser_id());
        if ($chat_member['status'] != 'member' && $chat_member['status'] != 'administrator' && $chat_member['status'] != 'creator') {
            return false;
        }
    }
    return true;
}

if (!checkUserInChannels($channels)) {
    listForcedJoin($channels);
}

function listForcedJoin($channels)
{
    global $telegramApi;
    $text = ' برای استفاده از ربات ابتدا داخل چنل های زیر عضو شوید و سپس دکمه بررسی عضویت✅ را کلیک کنید.';

    $channel_keyboard = [];

    foreach ($channels as $channel) {
        $channel_keyboard[] = [
            'text' => $channel['channel_name'],
            'url' => str_replace('@', 'https://t.me/', $channel['channel_id']),
        ];
    }

    $channel_buttons = array_chunk($channel_keyboard, 1);
    $channel_buttons[] = [
        [
            'text' => '✅عضویت',
            'callback_data' => '/start',
        ],
    ];

    $reply_markup = [
        'inline_keyboard' => $channel_buttons,
    ];
    $telegramApi->sendMessage($text, $reply_markup);
    exit(400);
}
