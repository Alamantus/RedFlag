<?php

/**
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * PHP 5.4.9
 *
 * Retrieved from:
 * https://naveensnayak.wordpress.com/2013/03/12/simple-php-encrypt-and-decrypt/
 *
 * this is a beginners template for simple encryption decryption
 * before using this in production environments, please read about encryption
 *
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */
class EasyCrypt
{
    private $encrypt_method = "AES-256-CBC";
    private $secret_key = 'website';
    private $secret_iv = 'encrypt that thing';

    function encrypt($string) {
        // hash
        $key = hash('sha256', $this->secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $this->secret_iv), 0, 16);

        $output = openssl_encrypt($string, $this->encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }

    function decrypt($string) {
        // hash
        $key = hash('sha256', $this->secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $this->secret_iv), 0, 16);

        return openssl_decrypt(base64_decode($string), $this->encrypt_method, $key, 0, $iv);
    }
}