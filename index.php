<?php
/**
 * Created by PhpStorm.
 * User: vato
 * Date: 5/30/16
 * Time: 2:59 PM
 */

include_once "functions/template.php";
global $template;
global $file_count;
$template = new template();

//Reads upload history from json file
$str = file_get_contents("upload_history.json");
$json = json_decode($str, true);

//Splits template and generates list body
$item = $template->split_template("templates/status_list.html", "list_item");
$loop_html = "";

foreach ($json as $key => $value) {
    $value['index'] = $key;
    $text = $template->generate_loop_html($value, $item);
    $loop_html = $text . $loop_html;
}

if (isset($_GET['ajax_reload'])) {
    //Writes $loop_html if request is sent by ajax for update
    echo $loop_html;
} else {
    $loop_html = $template->replace_split_template("templates/status_list.html", "list_item", $loop_html);
    $array = array("status_list" => $loop_html);
    $html = $template->generate_html($array, "basic.html");

    echo $html;
}
