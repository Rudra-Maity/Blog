<?php
function encryptSessionID($session_id) {
    $encryption_key = "abc"; 
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($session_id, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv); // Return encrypted session with IV
}

function decryptSessionID($encrypted_session_id) {
    $encryption_key = "abc";  
    list($encrypted_data, $iv) = explode('::', base64_decode($encrypted_session_id), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}
