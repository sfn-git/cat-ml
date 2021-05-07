function processImage(){
    var fileInput = document.getElementById("picture");
    file = fileInput.files[0];
    fileExt = file.name.split(".")[1];
    if(fileExt == "png" || fileExt == "jpg" || fileExt == "jpeg"){
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = ()=>{
            var fileString = reader.result;
            $.ajax({
                url: "process.php",
                method: "post",
                data: {fileString, fileName: file.name},
                success: (res) =>{
                    console.log(res);
                    if(res){
                        location.href = `result.php?image=${res}`;
                    }else{
                        window.alert("Please upload a .png, .jpg, or .jpeg");
                    }
                },
                error: (err)=>{
                    console.log(err);
                    window.alert("Please upload a .png, .jpg, or .jpeg");
                }
            });
        };
    }else{
        window.alert("Please upload a .png, .jpg, or .jpeg");
    }
    
}

inputBox =  document.getElementById("picture");

inputBox.addEventListener("change", ()=>{
    var fileInput = document.getElementById("picture");
    file = fileInput.files[0];
    fileExt = file.name.split(".")[1];
    console.log(fileExt);
    if(fileExt == "png" || fileExt == "jpg" || fileExt == "jpeg"){
        document.getElementById("uploadButton").style.display = "block";
    }else{
        window.alert("Please upload a .png, .jpg, or .jpeg");
    }
    
});