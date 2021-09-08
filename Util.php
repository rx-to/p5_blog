<?php

namespace Blog\Tools;

use \DateTime;

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
     * @param string $target Target URL
     * @param int    $delay  Delay in ms (1 second = 1000)
     */
    public static function redirect($target, $delay = 0)
    {
        return "<script>setTimeout(function(){document.location.href='$target'}, $delay);</script>";
    }

    /**
     * Generates an alert.
     * @param bool   $result `true` = success, `false` = error.
     * @param array  $errors  Contains error messages.
     * @param string $success Contains success message.
     * @return string
     */
    public static function generateAlert($errors, $success)
    {
        if (preg_match('/\<script\>/', $success)) {
            $alert = $success;
        } else {
            $alert = '<div class="alert alert-' . (empty($errors) ? 'success' : 'danger') . '">';

            if (!empty($errors)) {
                if (count($errors) == 1) {
                    $alert .= "<p>{$errors[0]}</p>";
                } else {
                    $alert .= '<ul class="mb-0">';
                    foreach ($errors as $error) {
                        $alert .= "<li>$error</li>";
                    }
                    $alert .= "</ul>";
                }
            } else {
                $alert .= "<p>$success</p>";
            }
            $alert .= '</div>';
        }

        return $alert;
    }

    /**
     * Uploads image.
     * @param array  $image
     * @param string $folder
     * @param string $name
     * @return mixed
     */
    public static function uploadImage($image, $folder, $name)
    {
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $name     .= '-' . date('YmdHis');
        $path      = "upload/$folder/$name.$extension";
        $errors    = [];

        // Checks extension.
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'bmp'];
        if (!in_array($extension, $allowedExtensions)) {
            $extensions = '';
            foreach ($allowedExtensions as $key => $extension) {
                $extensions .= "<strong>.$extension</strong>";
                $extensions .= isset($allowedExtensions[$key + 1]) ? ', ' : '.';
            }
            $errors[] = "Extensions prises en charge : $extensions";
        }

        if ($image['size'] > 3145728 || $image['error'] == 1)                      $errors[] = "L'image doit être inférieure à 3 Mo.";
        if (!move_uploaded_file($image['tmp_name'], $path) && $image['error'] > 1) $errors[] = 'Une erreur inattendue est survenue.';

        return empty($errors) ? "$name.$extension" : $errors;
    }

    /**
     * Deletes file.
     * @param string $path
     * @return mixed
     */
    public static function deleteFile($path)
    {
        $errors = [];

        // Checks if file exists.
        if (is_file($path)) {
            if (!unlink($path)) $errors[] = "Une erreur est survenue, veuillez réessayer ou contacter le webmaster si le problème persiste.";
        } else {
            $errors[] = "Le fichier <strong>`$path`</strong> n'existe pas.";
        }

        return empty($errors) ? true : $errors;
    }

    /**
     * Generates image input.
     * @param string $name
     * @return string
     */
    public static function generateInputFile($name)
    {
        return '<input type="file" id="' . $name . '" name="' . $name . '">' . "\n";
    }

    /**
     * Shortens a given string.
     * @param string $string
     * @param int    $max
     * @return string
     */
    public static function shortenString($string, $max = 100)
    {
        return substr($string, 0, $max) . (strlen($string) > $max ? '...' : '');
    }
}
