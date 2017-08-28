<?php
namespace App\Helper;

class Tools
{
    /**
     * 日期生成器
     *
     * @param $start_day
     * @param $end_day
     * @return \Generator|void
     */
    public static function createDay($start_day, $end_day)
    {
        $end_date = strtotime($end_day);
        $start_date = strtotime($start_day);
        while ($start_date < $end_date) {
            $time = date("Y-m-d", $start_date);
            yield $time;
            $start_date = $start_date + 24*60*60;
        }
        return;
    }
}