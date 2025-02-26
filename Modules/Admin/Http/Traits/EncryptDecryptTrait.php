<?php
namespace Modules\Admin\Http\Traits;

use Auth;
use Session;
use DB;
use Config;
Use App;
use SoapClient;
use Carbon\Carbon;

trait EncryptDecryptTrait {

	public function encryptId($id)
	{
        $ciphering = Config::get('admin.encrypt_decrypt.ciphering');
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options   = 0;
        $encryption_iv = Config::get('admin.encrypt_decrypt.encrypt_decrypt_iv');
        $encryption_key = Config::get('admin.encrypt_decrypt.encrypt_decrypt_key');
        $encryption = openssl_encrypt($id, $ciphering, $encryption_key, $options, $encryption_iv);
        return $encryption;
    }

    public function decryptId($id)
	{
        $decryption_iv = Config::get('admin.encrypt_decrypt.encrypt_decrypt_iv');
        $ciphering = Config::get('admin.encrypt_decrypt.ciphering');
        $decryption_key = Config::get('admin.encrypt_decrypt.encrypt_decrypt_key');
        $options   = 0;
        $decryption = openssl_decrypt($id, $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
    }

    public function getIpAddress()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
    
}