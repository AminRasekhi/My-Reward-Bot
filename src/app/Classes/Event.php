<?php
namespace src\app\Classes;

class Event
{
    private $event        = null;
    private $lotteryUsers = null;
    private $sql          = null;
    private $telegramApi  = null;

    public function __construct($sql = null, $telegramApi = null, $column = null, $value = null)
    {
        if (isset($sql)) {
            $this->sql = $sql;
        }
        if (isset($telegramApi)) {
            $this->telegramApi = $telegramApi;
        }

        if ($column !== null && $value !== null) {
            $this->event = $this->sql->table('events')->select()->where($column, $value)->get();
        }

    }

    //// get ////
    public function getEventID()
    {
        return $this->event[0]['id'];
    }

    //// set ////
    public function setConnectEventTable($column, $value)
    {
        $this->event = $this->sql->table('events')->select()->where($column, $value)->get();

    }
    public function setLotteryUsers($columnCondition = null, $value = null, $orderBy = null)
    {
        $this->lotteryUsers = $this->sql->table('events')->select()
            ->join('event_user')->on('events', 'id', 'event_user', 'event_id')
            ->join('users')->on('event_user', 'user_id', 'users', 'id')
            ->where($columnCondition ?? "null", $value ?? "null")->orderBy($orderBy ?? "null")->get();

        setManualLog("lottery lottery users : " . json_encode($this->lotteryUsers));

    }

    public function lotteryManuText()
    {
        $statusRes = $this->event[0]['status'] == 1 ? "فعال" : "غیر فعال";
        $text      = "نمایش اطلاعات قرعه کشی \"" . $this->event[0]['name'] . "\"" .
        "\n\nوضعیت قرعه کشی : " . $statusRes .
        "\nنام : " . $this->event[0]['name'] .
        "\nتوضیحات : " . $this->event[0]['description'] .
        "\nقوانین : " . $this->event[0]['rules_description'] .
        "\nجوایز : " . $this->event[0]['award'] .
        "\nتعداد ثبت نام کنندگان :‌" . count($this->lotteryUsers) .
        "\nتاریخ شروع : " . jalaliDate($this->event[0]['start_date']) .
        "\nتاریخ پایان : " . jalaliDate($this->event[0]['end_date']);
        return $text;
    }
    public function lotteryRelyMarkup($text = null)
    {

        $buttons = [
            [
                [
                    'text' => 'لیست همه افراد شرکت کننده',
                ],
            ],
            [
                [
                    'text' => 'ویرایش قرعه کشی',
                ],
                [
                    'text' => 'حذف قرعه کشی',
                ],
            ],

        ];

        if ($this->event[0]['status'] == 1) {
            $buttons[] = [
                [
                    'text' => 'غیر فعال کردن قرعه کشی',
                ],
            ];
        } else {
            $buttons[] = [
                [
                    'text' => 'فعال کردن قرعه کشی',
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
        $text .= "\n\n" . "لطفا برای ادامه فرایند یکی از گزیینه ها را انتخاب نمایید .";
        $this->telegramApi->sendMessage($text, $reply_keyboard);

    }
    public function showLotterUsers($columnConditionForLotteryUsers, $value, $orderBy = null)
    {
        $this->setLotteryUsers($columnConditionForLotteryUsers, $value, $orderBy);
        if ($this->lotteryUsers == null || count($this->lotteryUsers) == 0) {
            $this->telegramApi->sendMessage("تعداد افراد شرکت کننده : 0");
            exit(1);
        }

        if ($this->event == null) {
            exit(1);
        }

        $usersInfo = "نمایش لیست کاربران ثبت نام شده در  " . $this->event['name'] . PHP_EOL . PHP_EOL . PHP_EOL;

        $usersInLottery = array_chunk($this->lotteryUsers, 90);
        foreach ($usersInLottery as $userPages) {
            foreach ($userPages as $user) {
                $usersInfo .= "Name : " . $user['first_name'] . " " . $user['last_name'] . PHP_EOL . "Username : " . "@" . $user['username'] . PHP_EOL . "Tokens for this lottery : " . $user['lottery_token'] . PHP_EOL . PHP_EOL;
            }
            $this->telegramApi->sendMessage($usersInfo);
            $usersInfo = "";
        }
        $text = "برای ادامه کار لطفا یکی از گزیینه های زیر را انتخاب نمایید";

        $this->telegramApi->sendMessage($text);
        exit(1);
    }
}
