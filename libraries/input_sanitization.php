<?php
//Reminder: MacOS and XAMPP bug, no file uploads on a MacOS Host. File Permissions Bug.
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function uploadFile($tagName, $filesAllowed, $sizeAllowed, $overWriteAllowed)
{
    $uploadOK = 1;
    $dir = "../store/item_picture/";
    $file = $dir . basename($_FILES[$tagName]["name"]);
    $fileType = pathinfo($file, PATHINFO_EXTENSION);
    $fileSize = $_FILES[$tagName]["size"];
    echo "File Size: " . $fileSize . " > Allowed Size: " . $sizeAllowed . "<br><br>";
    if ($fileSize >  $sizeAllowed) {
        echo "File size is too big, Maxmium 10Mb allowed. <br>";
        $uploadOK = 0;
    }
    if (!stristr($filesAllowed, $fileType)) {
        echo "This file type is not allowed <br>";
        $uploadOK = 0;
    }
    if (file_exists($file) && !$overWriteAllowed) {
        echo "File already exists. Please upload a diffrent file. <br>";
        $uploadOK = 0;
    }
    if ($uploadOK == 1) {
        if (!move_uploaded_file($_FILES[$tagName]["tmp_name"], $file)) {
            echo "Sorry, uploading failed in the moving process <br>";
            $uploadOK = 0;
        }
    }

    if ($uploadOK == 1) {
        return $file;
    } else {
        return false;
    }
}
?>