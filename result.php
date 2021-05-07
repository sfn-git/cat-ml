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
    echo "<img height='50%' src='$imgURL'><br>";
    $result = shell_exec($command);
    
    if(!$type){
        echo nl2br($result);
    }else{
        echo "<h3>Cat type:". $_GET['type']."</h3>";
        $calculateRes = explode("\n", $result);
        for($i=0; $i<count($calculateRes); $i++){
            if($i == 0){
                if(strcmp($calculateRes[$i], $type)){
                    echo "<span style='color: green;'>".$calculateRes[$i]."</span>";
                }else{
                    echo "<span style='color: red;'>".$calculateRes[$i]."</span>";
                }
            }else{
                echo $calculateRes[$i];
            }
            echo "<br>";
        }
    }
    
    echo "<p>Each class was trained with 195 images. Dataset originally contained 200 images but 5 were taken from each class as separate confirmation.</p>";

}else{
    echo "Could not find that file :(. Please try again.";
}


?>