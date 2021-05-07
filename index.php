<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syed Nadeem CPS 5721 - HW3.1</title>
    <link rel="stylesheet" href="style.css">
    <script src="ajax.min.js"></script>
    <script defer src="hw3.js"></script>
</head>
<body>
    <h1>Syed Fahad Nadeem CPS5721 HW3.1</h1>
    <h3>Cat Breed Classifier</h3>
    <div class="container">
        <h2>Upload a picture of a cat to see what breed they classify as. Currently trained breeds are 
        <?php
            $confirmDIR = getcwd()."/confirm";
            $dir = new DirectoryIterator($confirmDIR);
            $i = 0;
            $len = 13;
            foreach($dir as $dirinfo){
                if(!$dirinfo->isDot()){
                    echo $dirinfo;
                    if($i == $len){
                        echo ".";
                    }else{
                        echo ", ";
                    }
                }
                $i++;
            }
        
        ?>
        </h2>
        <p><a href="https://www.kaggle.com/zippyz/cats-and-dogs-breeds-classification-oxford-dataset" target="_blank">Dataset Used.</a> Images of cats were retained in this dataset. Each class was trained with 195 images. Dataset originally contained 200 images but 5 were taken from each class as separate confirmation.</p>
        <h3 class='text-center'>Upload an image of a cat. (.png, .jpg, .jpeg)</h3>
        <input type="file" name="picture" id="picture"><br><br>
        <button type="submit" onclick="processImage()" style="width:20px; height: 100px; display: none;" id="uploadButton">Upload File!</button>
    </div>
    <h1 id="demo-images">Demo Images (Click an image)</h1>
    <div class="container">
	<h3>Demo images were not used in the training set.</h3>
    <?php

        $confirmDIR = getcwd()."/confirm";
        $dir = new DirectoryIterator($confirmDIR);
        echo "<div class='link-row'>";
        foreach($dir as $dirinfo){
            if(!$dirinfo->isDot()){
                echo "<a href='#$dirinfo'>$dirinfo</a> &nbsp;";
            }
        }
        echo "</div>";
        foreach($dir as $dirinfo){
            if(!$dirinfo->isDot()){
                $inDIR = getcwd()."/confirm/$dirinfo";
                $innerDir = new DirectoryIterator($inDIR);
                echo "<h2 id='$dirinfo'>$dirinfo</h2>";
                echo "<div class='image-row'>";
                foreach($innerDir as $fileinfo){
                    if(!$fileinfo->isDot()){
                        $filePath = "confirm/$dirinfo/$fileinfo";
                        echo "<img class='demo-image' src='$filePath' onclick='location.href = `result.php?image=$fileinfo&type=$dirinfo`'>";
                    }
                }
                echo "</div>";
                echo "<hr>";
            }
        }
    ?>
    </div>
</body>
</html>
