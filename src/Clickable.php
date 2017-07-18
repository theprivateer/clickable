<?php

namespace Privateer\Clickable;


class Clickable
{

    /**
     * @param $str
     * @return mixed|string
     */
    public static function parse($str)
    {
        $ret = ' ' . $str;
        // in testing, using arrays here was found to be faster
        $ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', ['static', 'make_url_clickable'], $ret);
        $ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', ['static', 'make_web_ftp_clickable'], $ret);
        $ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', ['static', 'make_email_clickable'], $ret);

        // this one is not in an array because we need it to run last, for cleanup of accidental links within links
        $ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
        $ret = trim($ret);
        return $ret;
    }

    /**
     * @param $matches
     * @return string
     */
    public static function make_url_clickable($matches) {
        $ret = '';
        $url = $matches[2];

        if ( empty($url) )
            return $matches[0];
        // removed trailing [.,;:] from URL
        if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
            $ret = substr($url, -1);
            $url = substr($url, 0, strlen($url)-1);
        }
        return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $ret;
    }

    /**
     * @param $matches
     * @return string
     */
    public static function make_web_ftp_clickable($matches) {
        $ret = '';
        $dest = $matches[2];
        $dest = 'http://' . $dest;

        if ( empty($dest) )
            return $matches[0];
        // removed trailing [,;:] from URL
        if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
            $ret = substr($dest, -1);
            $dest = substr($dest, 0, strlen($dest)-1);
        }
        return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>" . $ret;
    }

    /**
     * @param $matches
     * @return string
     */
    public static function make_email_clickable($matches) {
        $email = $matches[2] . '@' . $matches[3];
        return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
    }
}