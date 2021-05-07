<?php 

$fileString = $_POST["fileString"];
$fileName = $_POST["fileName"];
$fileExt = explode(".", $fileName)[1];
$base64 = explode(",", $fileString)[1];

$random = generateRandomString();
$outFileName = "$random.$fileExt";
$output_file = getcwd() ."/temp/$random." . $fileExt;

$file = fopen($output_file, "wb");
fwrite($file, base64_decode($base64));
fclose($file);

$file_parts = pathinfo($output_file);
if($file_parts["extension"] == "png" || $file_parts["extension"] == "jpg" || $file_parts["extension"] == "jpeg"){
    echo $outFileName;
}else{
    unlink($output_file);
    echo false;
}

function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>