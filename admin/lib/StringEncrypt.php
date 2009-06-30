<?php 
    
class StringEncrypt
{
    // Replace salt if you plan to use this class
    const SALT = 'U2FsdGVkX19qBb5gBOEUaw';
    
    public static function encrypt($text) 
    { 
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, StringEncrypt::SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))); 
    } 

    public static function decrypt($text) 
    { 
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, StringEncrypt::SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))); 
    } 
}
