<?php
function generateRandomString($length = 25)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function uploadImage($file, $dir)
{
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
    $imagename = generateRandomString() . "." . $ext;
    $filename = $dir . $imagename;
    if (move_uploaded_file($file["tmp_name"], $filename)) {
        return $imagename;
    }
    return null;
}
