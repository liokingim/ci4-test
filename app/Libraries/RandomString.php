<?php
function generateRandomString($length = 64) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length - 1; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $randomString = str_shuffle($randomString);
    $firstChar = substr($randomString, 0, 1);
    $randomString = $firstChar . substr($randomString, 1) . $characters[rand(0, 9)];
    return $randomString;
}