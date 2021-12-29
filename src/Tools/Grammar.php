<?php
namespace HtmlAcademy\Tools;

class Grammar {

    public static function getSuffix($number, $variant = "1")
    {
        $suffix = [
            '1' => [
                '0' => 'ов',
                '1' => '',
                '2' => 'а',
                '3' => 'а',
                '4' => 'а',
                '5' => 'ов',
                '6' => 'ов',
                '7' => 'ов',
                '8' => 'ов',
                '9' => 'ов'
            ],
            '2' => [
                '0' => 'ий',
                '1' => 'ие',
                '2' => 'ия',
                '3' => 'ия',
                '4' => 'ия',
                '5' => 'ий',
                '6' => 'ий',
                '7' => 'ий',
                '8' => 'ий',
                '9' => 'ий'
            ]
        ];

        $numberString = strval($number);

        $lastDigit = $numberString[-1];
        $secondLastDigit = (strlen($numberString) > 1) ? $numberString[-2] : null;

        if ($secondLastDigit === "1") {
            return $suffix[$variant]['0'];
        }

        return $suffix[$variant][$lastDigit];
    }

    public static function getYearsString($date, $prefix = "")
    {
        if (is_null($date) || empty($date)) {
            return "";
        }

        $yearsDeclination = [
            '0' => 'лет',
            '1' => 'год',
            '2' => 'года',
            '3' => 'года',
            '4' => 'года',
            '5' => 'лет',
            '6' => 'лет',
            '7' => 'лет',
            '8' => 'лет',
            '9' => 'лет'
        ];

        $years = date_diff(date_create(), date_create($date))->format("%y");

        $lastDigit = $years[-1];
        $secondLastDigit = (strlen($years) > 1) ? $years[-2] : null;

        if ($secondLastDigit === "1") {
            return $prefix.$years." лет";
        }

        return $prefix.$years." ".$yearsDeclination[$lastDigit];
    }
}
