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
        return $this->event['id'];
    }

    //// set ////
    public function setConnectEventTable($column, $value)
    {
        $this->event = $this->sql->table('events')->select()->where($column, $value)->get();
    }
    public function setLotteryUsers($columnCondition = null, $value = null)
    {
        $this->lotteryUsers = $this->sql->table('events')->select()
            ->join('event_user')->on('events', 'id', 'events', 'id')
            ->join('users')->on('users', 'id', 'event_user', 'id')
            ->where($columnCondition ?? "null", $value ?? "null")->get();
    }

    public function lotteryManuText()
    {
        $text = "نمایش اطلاعات قرعه کشی " . $this->event['name'] .
        "\nوضعیت قرعه کشی : " . $this->event['status'] == 1 ? "فعال" : "غیر فعال" .
        "\nنام : " . $this->event['name'] .
        "\nتوضیحات : " . $this->event['description'] .
        "\nتعداد ثبت نام کنندگان :‌" . count($this->lotteryUsers) .
        "\nتاریخ شروع : " . $this->event['start_date'] .
        "\nتاریخ پایان : " . $this->event['end_date'];
    }
    public function lotteryRelyMarkup()
    {

        $buttons = [
            [
                [
                    'text' => 'لیست همه افراد شرکت کننده',
                ],
            ],
            [
                [
                    'text' => $this->event['id'] . '_ ویرایش قرعه کشی',
                ],
                [
                    'text' => $this->event['id'] . '_ حذف قرعه کشی',
                ],
            ],

        ];

        if ($this->event['status'] == 1) {
            $buttons[] = [
                [
                    'text' => $this->event['id'] . '_ غیر فعال کردن قرعه کشی',
                ],
            ];
        } else {
            $buttons[] = [
                [
                    'text' => $this->event['id'] . '_ فعال کردن قرعه کشی',
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
        $text = "لطفا برای ادامه فرایند یکی از گزیینه ها را انتخاب نمایید .";
        $this->telegramApi->sendMessage($text, $reply_keyboard);

    }
}
