<?php 
namespace App\Libraries;

class Vault {

	// protected $stuff;


	public function encrypt($data) {
		$config = [
			'size'      => SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES,			
			// 'salt'      => random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES),
			'salt' => $data['salt'],
			'nocne' => $data['nonce'],
			// 'nonce'     => random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES),
			'limit_ops' => SODIUM_CRYPTO_PWHASH_OPSLIMIT_MODERATE, // SODIUM_CRYPTO_PWHASH_OPSLIMIT_SENSITIVE,
			// 'limit_mem' => SODIUM_CRYPTO_PWHASH_MEMLIMIT_SENSITIVE, // Too much ram usage
			'limit_mem' => SODIUM_CRYPTO_PWHASH_MEMLIMIT_MODERATE, // 256MB
			'alg'       => SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13,
		];

		$key = sodium_crypto_pwhash(
			$config['size'],
			$data['masterkey'],
			$config['salt'],
			$config['limit_ops'],
			$config['limit_mem'],
			$config['alg'],
		);

		$cipher_text = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt(
			$data['cipher_text'],
			$data['masterkey_ad'],
			$config['nonce'],
			$key
		);

		return [
			'config' => array_map('base64_encode', $config),
			'encrypted' => base64_encode($cipher_text),
		];

	}

}