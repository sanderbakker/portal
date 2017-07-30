<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 29-7-2017
 * Time: 22:46
 */
$iv = openssl_random_pseudo_bytes(16);
$textToEncrypt = "Sander";

$encryptionMethod = "AES-256-CBC";  // AES is used by the U.S. gov't to encrypt top secret documents.
$secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";

//To encrypt
$encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secretHash, 0, $iv);
var_dump($iv);
//To Decrypt
$decryptedMessage = openssl_decrypt($encryptedMessage, $encryptionMethod, $secretHash, 0,  $iv);
var_dump($decryptedMessage);
var_dump($iv);
//Result
echo "Encrypted: $encryptedMessage <br>Decrypted: $decryptedMessage";