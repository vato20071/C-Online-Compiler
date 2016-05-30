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

    function replace_split_template($src, $split, $content, $file = 1) {
        if ($file == 1) {
            $src = file_get_contents($src);
        }
        $text_array = explode("[:$split:]", $src);
        return $text_array[0] . $content . $text_array[2];
    }

    function generate_loop_html($array, $src) {
        foreach ($array as $key => $value) {
            $src = str_replace("{{:$key:}}", $value, $src);
        }
        return $src;
    }
}