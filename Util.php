<?php

class Util {
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
}