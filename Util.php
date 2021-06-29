<?php

class Util
{
    /**
     * Converts string to slug.
     * @param  string $str
     * @return string
     */
    public static function slugify($str = '')
    {
        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);
        $str = strtolower($str);
        $str = str_replace(["'", '-'], ' ', $str);
        $str = preg_replace('/[^a-zA-Z0-9 ]/', '', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        $str = str_replace(' ', '-', $str);
        $str = substr($str, -1) == '-' ? substr($str, 0, -1) : $str;
        return $str;
    }

    /**
     * Checks if strings has expected length.
     * @param string $string  
     * @param int    $minimum Minimum length.
     * @param int    $maximum Maximum length.
     * @return bool
     */
    public static function checkStrLen($string, $minimum = 0, $maximum = 0)
    {
        if ($minimum && $maximum)
            return strlen($string) >= $minimum && strlen($string) <= $maximum;
        elseif ($minimum)
            return strlen($string) >= $minimum;
        else
            return strlen($string) <= $maximum;
    }

    /**
     * Checks if password is strong enough.
     * @param string $password
     * @return bool
     */
    public static function checkPassword($password)
    {
        $uppercase    = preg_match('@[A-Z]@', $password);
        $lowercase    = preg_match('@[a-z]@', $password);
        $number       = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        return $uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8;
    }

    /**
     * Checks if age is 13 or older.
     * @param string $birtdate
     * @return bool
     */
    public static function checkAge($birthdate)
    {
        $today = intval(date('Ymd'));
        $birthdate = intval(date_format(new DateTime($birthdate), 'Ymd'));
        return ($today - $birthdate) / 10000 >= 13;
    }

    /**
     * Redirects to another page.
     * @param string $target
     * @param int    $delay
     */
    public static function redirect($target, $delay = 0) {
        return "<script>setTimeout(function(){document.location.href='$target'}, $delay);</script>";
    }
}
