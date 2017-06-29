<?php
/**
 * Created by Camilo Lozano III.
 * User: camilord
 * Date: 29 Jun 2017
 * Time: 11:44 AM
 */

namespace Camilo3rd\Util;


class ArrayUtil
{

    /**
     * @param $array_data
     * @return array|mixed|string
     */
    public static function cleanse($array_data) {
        if (is_array($array_data)) {
            foreach($array_data as $i => $array_item) {
                $array_data[$i] = ArrayUtil::cleanse($array_item);
            }
        } else {
            $array_data = ArrayUtil::cleanse_string($array_data);
        }

        return $array_data;
    }

    /**
     * Original Code: https://gist.github.com/gcoop/701814
     * @param $string
     * @param array $allowedTags
     * @return mixed|string
     */
    public static function cleanse_string($string, $allowedTags = array('<br>','<b>','<i>','<p>','<span>','<strong>'))
    {
        if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
        }

        $string = strip_tags($string, $allowedTags);

        // ============
        // Remove MS Word Special Characters
        // ============

        $search  = array('&acirc;€“','&acirc;€œ','&acirc;€˜','&acirc;€™','&Acirc;&pound;','&Acirc;&not;','&acirc;„&cent;');
        $replace = array('-','&ldquo;','&lsquo;','&rsquo;','&pound;','&not;','&#8482;');

        $string = str_replace($search, $replace, $string);
        $string = str_replace('&acirc;€', '&rdquo;', $string);

        $search = array("&#39;", "\xc3\xa2\xc2\x80\xc2\x99", "\xc3\xa2\xc2\x80\xc2\x93", "\xc3\xa2\xc2\x80\xc2\x9d", "\xc3\xa2\x3f\x3f");
        $replace = array("'", "'", ' - ', '"', "'");

        $string = str_replace($search, $replace, $string);

        $quotes = array(
            "\xC2\xAB"     => '"',
            "\xC2\xBB"     => '"',
            "\xE2\x80\x98" => "'",
            "\xE2\x80\x99" => "'",
            "\xE2\x80\x9A" => "'",
            "\xE2\x80\x9B" => "'",
            "\xE2\x80\x9C" => '"',
            "\xE2\x80\x9D" => '"',
            "\xE2\x80\x9E" => '"',
            "\xE2\x80\x9F" => '"',
            "\xE2\x80\xB9" => "'",
            "\xE2\x80\xBA" => "'",
            "\xe2\x80\x93" => "-",
            "\xc2\xb0"	   => "°",
            "\xc2\xba"     => "°",
            "\xc3\xb1"	   => "&#241;",
            "\x96"		   => "&#241;",
            "\xe2\x81\x83" => '&bull;'
        );
        $string = strtr($string, $quotes);

        // ============
        // END
        // ============

        return $string;
    }
}