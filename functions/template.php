<?php
/**
 * Created by PhpStorm.
 * User: vato
 * Date: 5/30/16
 * Time: 3:34 PM
 */
class template {

    /**
     * Generates replaces html keys with values from array
     * if $file is 1 then $src is location of file, text otherwise
     * @param $array
     * @param $src
     * @param int $file
     * @return mixed|string
     */
    function generate_html($array, $src, $file = 1) {
        if ($file == 1) {
            $src = file_get_contents($src);
        }
        foreach ($array as $key => $value) {
            $src = str_replace("{{:$key:}}", $value, $src);
        }
        return $src;
    }

    /**
     * Splits template on chunk and returns chunk contents for replacing with values
     * @param $src
     * @param $split
     * @param int $file
     * @return string
     */
    function split_template($src, $split, $file = 1) {
        if ($file == 1) {
            $src = file_get_contents($src);
        }
        $text_array = explode("[:$split:]", $src);
        if (count($text_array) < 1) {
            return "";
        }
        return $text_array[1];
    }

    /**
     * Replaces template chunk with $content
     * @param $src
     * @param $split
     * @param $content
     * @param int $file
     * @return string
     */
    function replace_split_template($src, $split, $content, $file = 1) {
        if ($file == 1) {
            $src = file_get_contents($src);
        }
        $text_array = explode("[:$split:]", $src);
        return $text_array[0] . $content . $text_array[2];
    }

    /**
     * Generates loop html from src and replaces fields with values
     * @param $array
     * @param $src
     * @return mixed
     */
    function generate_loop_html($array, $src) {
        foreach ($array as $key => $value) {
            $src = str_replace("{{:$key:}}", $value, $src);
        }
        return $src;
    }
}