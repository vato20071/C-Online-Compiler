<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 6/14/16
 * Time: 6:01 PM
 */

function compile($directory, $file_name, $input_dir="tests/") {
    $TIME_LIMIT = 2;
    $MEMORY_LIMIT = 65536;
    $upload_date = date("H:i:s");
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

//        exec("ulimit ")

        $output_file = $base_name . ".out";

        $file_list = scandir($input_dir);
        $test_num = 0;
        foreach ($file_list as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'in') {
                $test_num++;
                $input_name = $input_dir . "/" . $file;
                $input_base = basename($file, ".in");
                $output_file = $base_name . "." . $input_base . ".out";
                echo $output_file . "<br>";
                $command_run = "./$output <$input_name 1> $output_file 2> $error_name";
                shell_exec("ulimit -t $TIME_LIMIT; " . $command_run);
                $error_data = file_get_contents($error_name);
                if (strpos($error_data, "error") !== false) {
                    $arr = array(
                        "problem" => "A",
                        "status" => "CE",
                        "date" => $upload_date,
                        "test" => $test_num
                    );
                    return $arr;
                }
                if (strpos($error_data, "Killed") !== false) {
                    return array("problem" => "A", "status" => "TLE", "date" => $upload_date, "test" => $test_num);
                }
                $actual_data = file_get_contents($output_file);
                $correct_data = file_get_contents($base_name . "." . $input_base . ".a");
                unlink($output_file);
                if ($actual_data == $correct_data) continue;
                return array("problem" => "A", "status" => "WA", "date" => $upload_date, "test" => $test_num);
            }
        }

    } else {
        $arr = array(
            "problem" => "A",
            "status" => "CE",
            "date" => $upload_date,
            "test" => "N/A"
        );
        return $arr;
    }

    return array("problem" => "A", "status" => "OK", "date" => $upload_date, "test" => "N/A");

}