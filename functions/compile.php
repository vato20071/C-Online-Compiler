<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 6/14/16
 * Time: 6:01 PM
 */

function compile($directory, $file_name, $input_dir="tests/") {
    $base_name = basename($file_name, ".cpp");

    $base_name = $directory . $base_name;
    $file_name = $base_name . ".cpp";
    $output = $base_name;
    $error_name = $base_name . ".err";
    $command = "g++ $file_name -o $output";
    $command_error = "$command 2> $error_name";

    exec("chmod 777 $file_name");
    exec("chmod 777 $error_name");

    shell_exec("$command_error");

    $error = file_get_contents($error_name);


    if (trim($error) == "") {

        exec("chmod 777 $output");

        $output_file = $base_name . ".out";

        $file_list = scandir($input_dir);

        foreach ($file_list as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'in') {
                $input_name = $input_dir . "/" . $file;
                $input_base = basename($file, ".in");
                echo $input_base . "<br>";
                echo $input_name . "<br>";
                $output_file = $base_name . "." . $input_base . ".out";
                echo $output_file;
                $command_run = "./$output <$input_name 1> $output_file";
                shell_exec($command_run);
            }
        }

    }

}