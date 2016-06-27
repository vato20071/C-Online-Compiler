<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/30/16
 * Time: 4:37 PM
 * @param $command
 */

include "functions/compile.php";

function execute($command) {
    print_r("Executing: $command<br>");
    $output = [];
    shell_exec($command);
    print_r($output);
    echo "<br>";
}

$target_dir = "uploads/";
$str = file_get_contents("upload_history.json");
$json = json_decode($str, true);
$file_count = count($json);
$file_name = basename($_FILES["fileToUpload"]["name"], ".cpp") . $file_count . ".cpp";
$target_file = $target_dir . $file_name;

$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
if(isset($_POST["submit"])) {

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        $data = compile($target_dir, $file_name);
        array_push($json, $data);
        file_put_contents("upload_history.json", json_encode($json));
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
<script>
    alert("File upload completed. Redirecting automatically");
    function redirect() {
        window.location.href = "index.php";
    }
    setTimeout(redirect, 5000);

</script>

