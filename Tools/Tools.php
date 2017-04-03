<?php

class Tools
{

    /**
     * Pris sans regrets a PrestaShop.
     * Verifie les tableaux POST et GET (dans cet ordre) pour retrouver un parametre, et le purifie si necessaire.
     *
     * @param string $key Value key
     * @param mixed $default_value (optional)
     * @return mixed Value
     */
    public static function getValue($key, $default_value = false)
    {
        if (!isset($key) || empty($key) || !is_string($key)) {
            return false;
        }

        $ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default_value));

        if (is_string($ret)) {
            return stripslashes(urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret))));
        }

        return $ret;
    }

    /**
     * Renvoie la date du dernier lundi avant la date specifiee, au format dd-mm-yyyy.<br/>
     * Si la date est un lundi, renvoie la date du jour.
     *
     * @param string $date
     * @return false|string Le dernier lundi, ou false si la date est invalide
     */
    public static function getLastMonday($date = null)
    {
        $timestamp = $date ? strtotime($date) : time();
        if (date("w", $timestamp) !== "1") {
            return date('d-m-Y', strtotime("last monday", $timestamp));
        } else {
            return date('d-m-Y', $timestamp);
        }
    }

    /**
     * Verifie si une date respecte le format europeen d-m-Y
     * @return bool
     */
    public static function isValidDate($date)
    {
        return !empty($date) && preg_match('#\d{1,2}\-\d{1,2}\-\d{4}#', $date);
    }
}