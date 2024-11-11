<?php
if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.<br>";
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    } else {
        echo "Your file was not uploaded.<br>";
    }
}
$images = array_diff(scandir($target_dir), array('..', '.'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Images</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #333;
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            max-width: 1000px;
            margin-top: 20px;
        }

        .gallery-container img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s;
        }

        .gallery-container img:hover {
            transform: scale(1.05);
        }

        
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.5);
        }

        
        .close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 2rem;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Uploaded Images</h1>
    <div class="gallery-container">
        <?php foreach ($images as $image): ?>
            <img src="uploads/<?php echo $image; ?>" alt="<?php echo $image; ?>" onclick="openLightbox('uploads/<?php echo $image; ?>')">
        <?php endforeach; ?>
    </div>

    
    <div class="lightbox" id="lightbox">
        <span class="close-btn" onclick="closeLightbox()">&times;</span>
        <img id="lightbox-img" src="" alt="Expanded Image">
    </div>

    <script>
        function openLightbox(src) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox').style.display = 'flex';
        }

        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
        }
    </script>
</body>
</html>
