<?php 
    if(isset($_POST['submit'])){
        $allowed_ext = array('png','jpg','jpeg','gif');
        if(!empty($_FILES['upload']['name'])){
            $file_name = $_FILES['upload']['name'];
            $file_size = $_FILES['upload']['size'];
            $file_tmp = $_FILES['upload']['tmp_name'];
            $targetdir = "extras/{$file_name}";
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if(in_array($file_ext, $allowed_ext)){
                if($file_size <= 1000000){
                    // Move uploaded file to target directory
                    move_uploaded_file($file_tmp, $targetdir);

                    // Get original image size
                    list($original_width, $original_height) = getimagesize($targetdir);

                    // Compress image
                    if($file_ext == 'png'){
                        $image = imagecreatefrompng($targetdir);
                    } elseif(in_array($file_ext, array('jpg', 'jpeg'))){
                        $image = imagecreatefromjpeg($targetdir);
                    } elseif($file_ext == 'gif'){
                        $image = imagecreatefromgif($targetdir);
                    }

                    // Compression quality (0-100)
                    $compression_quality = 75;

                    // Save the compressed image
                    $compressed_file = "extras/compressed_{$file_name}";
                    if($file_ext == 'png'){
                        imagepng($image, $compressed_file, $compression_quality);
                    } elseif(in_array($file_ext, array('jpg', 'jpeg'))){
                        imagejpeg($image, $compressed_file, $compression_quality);
                    } elseif($file_ext == 'gif'){
                        imagegif($image, $compressed_file);
                    }

                    // Get compressed image size
                    list($compressed_width, $compressed_height) = getimagesize($compressed_file);
                    $compressed_size = filesize($compressed_file);

                    // Cleanup
                    imagedestroy($image);
                    // unlink($compressed_file);

                    $message = '<p style="color:green;">File Uploaded</p>';
                } else {
                    $message = '<p style="color:red;">File size is too large</p>';
                }
            } else {
                $message = '<p style="color:red;">Invalid file type</p>';
            }
        } else {
            $message = '<p style="color:red;">Please choose a file</p>';
        }
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload and Compression</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
            text-align: center;
        }
        img {
            max-width: 300px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Image Upload and Compression</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="upload">
            <button type="submit" name="submit">Upload Image</button>
            <input type="submit" name="logout" value="Logout">
        </form>
        
        <?php 

            if(isset($_POST["logout"])){
                session_destroy();
                header("Location: index.php");
            }
            if(isset($message)){
                echo $message;
            }
            if(isset($targetdir) && isset($compressed_file)){
                echo '<img src="' . $targetdir . '" width="' . $original_width . '" height="' . $original_height . '" /><br>';
                echo '<p>Original Size: ' . round($file_size / 1024, 2) . ' KB</p>';
               
            }

        ?>
    </div>
</body>
</html>
