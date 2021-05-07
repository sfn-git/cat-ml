<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat ML - Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<div class="container">
<?php

@$fileName = str_replace(" ", "\\ ",urldecode($_GET["image"]));
@$imgURL = $_GET["image"] or die("Please upload an image");
@$type = strtolower($_GET["type"]);
$cwd = getcwd();

$foundFile = false;

if($type == "" || $type == null){
    $tempDir = "$cwd/temp";
    $tempDirIt = new DirectoryIterator($tempDir);
    foreach($tempDirIt as $file){
        if(!$file->isDot()){
           if($file == $fileName){
                $foundFile = true;
                $imgURL = "temp/$file";
                $fileName = "$cwd/temp/$fileName";
                break;
           }
        }
    }
}else{
    $confirmDir = "$cwd/confirm";
    $confirmDirIt = new DirectoryIterator($confirmDir);
    foreach($confirmDirIt as $folder){
        if(!$folder->isDot()){
            $catDir = "$cwd/confirm/$folder";
            $catFolderIt = new DirectoryIterator($catDir);
            foreach($catFolderIt as $file){
                if(!$folder->isDot()){
                    if($file == $fileName){
                        $foundFile = true;
                        $imgURL = "confirm/$folder/$file";
                        $fileName = str_replace(" ", "\\ ","$cwd/confirm/$folder/$fileName");
                        break;
                    }
                }
            }
         }
    }
}


if($foundFile){

    $command = "python3 $cwd/label_image.py --graph=$cwd/IMG_graph.pb --labels=$cwd/IMG_label.txt --input_layer=Mul --output_layer=final_result --image=$fileName";
    
    echo "<img class='cat-pic' src='$imgURL'><br>";
    $result = shell_exec($command);

    $calculateRes = explode("\n", $result);
    echo "<div class='results'>";
    if($type){
        echo "<h3>Actual cat type: ". $_GET['type']."</h3>";
    }
    for($i=0; $i<count($calculateRes); $i++){
        if($i == 0){
            echo "<span style='color: green; font-size: x-large;'>".$calculateRes[$i]."</span>";
        }else{
            echo "<div>".$calculateRes[$i]."</div>";
        }
        echo "<br>";
    }
    echo "<p>Each class was trained with 195 images. Dataset originally contained 200 images but 5 were taken from each class as separate confirmation.</p>";
    echo "<a href='index.php'>Go back home</a>";
    echo "</div>";
}else{
    echo "Could not find that file :(. Please try again.";
}


?>
</div>
</body>
</html>