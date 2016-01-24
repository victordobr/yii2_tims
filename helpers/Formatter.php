<?php
namespace app\helpers;

/**
 * Class Formatter
 * @package app\helpers
 * @author Alex Makhorin
 */
class Formatter extends \yii\i18n\Formatter
{
    /**
     * @param string $timezone
     * @return $this
     */
    public function setTimezone($timezone)
    {
        $this->timeZone = $timezone;

        return $this;
    }

    /**
     * @param string $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @param string $locale
     * @param callable $function
     * @return mixed
     */
    public function inLocale($locale, callable $function)
    {
        $oldLocale = $this->locale;
        $this->setLocale($locale);
        $result = call_user_func($function, $this);
        $this->setLocale($oldLocale);

        return $result;
    }

    /**
     * @param string $timezone
     * @param callable $function
     * @return mixed
     */
    public function inTimezone($timezone, callable $function)
    {
        $oldTimezone = $this->timeZone;
        $this->setTimezone($timezone);
        $result = call_user_func_array($function, [$this, $oldTimezone]);
        $this->setTimezone($oldTimezone);

        return $result;
    }

    /**
     * Money formatter.
     * @param string|int $value
     * @param null|int $afterDot number decimal after dot.
     * @return string value in decimal format.
     */
    public function asMoney($value, $afterDot = 2)
    {
        return number_format(self::formatAsFloatMoney($value), $afterDot);
    }

    /**
     * Money int formatter.
     * @param string|float $value money in decimal format.
     * @return null|string money in int format.
     */
    public function asIntMoney($value)
    {
        return number_format(self::formatAsIntMoney($value), 0, '', '');
    }

    /**
     * Second formatter.
     * @param string|int $value number seconds.
     * @param string $format return format. See php date function format.
     * @return bool|string value in day format.
     */
    public function asPeriod($value, $format = 'j')
    {
        $days = date($format, $value);

        return $days . ($days > 1 ? ' days.' : ' day.');
    }

    /**
     * Returns phone number in E.164 format.
     * @param string $phone number.
     * @return null|string date in requested format.
     */
    public function asPhone($phone)
    {
        // separate by extension
        $phone = preg_split('/\D?(ext|[,x#\/\\\\])\D{0,2}(?=\d{1,5}$)/', $phone);
        $number = '+' . self::normalizeNumber($phone[0]);

        if (isset($phone[1])) {
            $number .= ';ext=' . $phone[1];
        }

        return $number;
    }

    /**
     * Int to ip.
     * @param string $ip
     * @return int|string
     */
    public function asIntIp($ip)
    {
        $result = 0;

        if (!filter_var($ip = trim($ip), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $result = sprintf("%u", ip2long($ip));
        }

        return $result;
    }

    /**
     * Ip to int
     * @param int $number
     * @return string
     */
    public function asIp($number)
    {
        $number = trim($number);
        $result = '0.0.0.0';

        if ($number != '0') {
            return long2ip(-(4294967295 - ($number - 1)));
        }

        return $result;
    }


    /**
     * Format ssh key.
     * @param string $ssh ssh key.
     * @return string key.
     */
    public function asKey($ssh)
    {
        if (!empty($ssh) && ($key = explode(' ', $ssh)) && isset($key[1]) && (strlen($key[1]) == 372)) {
            $result = $key[1];
        } else {
            $result = null;
        }

        return $result;
    }

    /**
     * Returns money in decimal format.
     * @param int $value money in int.
     * @return string money in decimal format.
     */
    public static function formatAsFloatMoney($value)
    {
        $count = strlen($value);
        switch (true) {
            case $count > 6:
                $result = substr($value, 0, $decimalCount = $count - 6) . '.' . substr($value, $decimalCount);
                break;
            case $count <= 6 && $count >= 1:
                $result = '0.';

                for ($i = $count; $i < 6; $i++) {
                    $value = '0' . $value;
                }

                $result .= $value;
                break;
            default:
                $result = '0.000000';
        }

        return $result;
    }

    /**
     * Returns money in int format.
     * @param string|float $value money in decimal format.
     * @return null|string money in int format.
     */
    public static function formatAsIntMoney($value)
    {
        switch (true) {
            case preg_match('/\./', $value) :
                $afterDot = strstr($value, '.');
                $beforeDot = str_replace($afterDot, '', $value);
                $afterDot = substr($afterDot, 1);
                $count = strlen($afterDot);
                for ($i = $count; $i < 6; $i++) {
                    $afterDot = '0' . $afterDot;
                }
                $result = $beforeDot . $afterDot;
                break;
            case $value > 0 :
                $result = $value . '000000';
                break;
            default :
                $result = null;
        }

        return $result;
    }

    /**
     * @param $timestamp
     * @return string
     */
    public function asElapsedTime($timestamp)
    {
        if (empty($timestamp)) {
            return 'unknown';
        }

        $time = time() - $timestamp;

        if ($time < 1) {
            return '0 seconds';
        }

        $a = [
            365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];
        $a_plural = ['year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        ];

        foreach ($a as $secs => $str) {
            $d = $time / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }

    }


    /**
     * @param string $number number for format.
     * @return string formatted number.
     */
    private static function normalizeNumber($number)
    {
        return preg_replace('/\D/', '', $number);
    }
}