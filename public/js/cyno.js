/*
	Cyno - Secure Password Manager v0.1
 */

class Cyno {

	constructor() {
		// 
	}
	
	static async getSodium() {
		return new Promise(sodium => {
			setTimeout(() => {
				sodium(window.sodium)
			}, 1000);
		});
	}
	
	static async get(url) {
		let response = await fetch(url,{
			method: "get",
			headers: {
				"Content-Type": "application/json",
				"X-Requested-With": "XMLHttpRequest"
			}
		});
		if(response.ok) {
			let json = await response.json();
			return json;
		} else {
			console.log("HTTP_ERROR: " + response.status); // DEBUG
		}
	}

	static async post(url, data, jwt) {
		let response = await fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type':'application/json',
				"X-Requested-With": "XMLHttpRequest",
				"Authorization": `Bearer ${jwt}`
			},
			body: JSON.stringify(data)
		});
		if(response.ok) {
			let json = await response.json();
			return json;
		} else {
			console.log("HTTP_ERROR: " + response.status);
		}
	}

	static async generate_key(password, salt, difficulty) {
		console.log(password, salt, difficulty); // DEBUG
		let sodium = await this.getSodium();
		let _salt  = sodium.from_base64(salt, sodium.base64_variants.ORIGINAL);
		let _password = password;
		let ops_limit;
		let mem_limit;

		console.log(parseInt(difficulty)); // DEBUG
		switch(parseInt(difficulty)) {
			case 0: 
				ops_limit = sodium.crypto_pwhash_OPSLIMIT_INTERACTIVE;
				mem_limit = sodium.crypto_pwhash_MEMLIMIT_INTERACTIVE;
				break;

			case 1:
				ops_limit = sodium.crypto_pwhash_OPSLIMIT_MODERATE;
				mem_limit = sodium.crypto_pwhash_MEMLIMIT_MODERATE;
				break;

			case 2:
				ops_limit = sodium.crypto_pwhash_OPSLIMIT_SENSITIVE;
				mem_limit = sodium.crypto_pwhash_MEMLIMIT_SENSITIVE;
				break;

			default:
				break;
		}
		console.log(ops_limit, mem_limit); // DEBUG
		
		return sodium.to_base64(sodium.crypto_pwhash(
			32, 
			_password, 
			_salt,
			ops_limit,
			mem_limit,
			sodium.crypto_pwhash_ALG_ARGON2ID13
		), sodium.base64_variants.ORIGINAL);;
	}

	static async generate_bytes(mode=1) {
		let bytes = [];
		let sodium = await this.getSodium();
		if(mode) {
			bytes['salt'] = sodium.to_base64(
				sodium.randombytes_buf(sodium.crypto_pwhash_SALTBYTES),
				sodium.base64_variants.ORIGINAL
			);
			bytes['nonce'] = sodium.to_base64(
				sodium.randombytes_buf(sodium.crypto_aead_xchacha20poly1305_ietf_NPUBBYTES),
				sodium.base64_variants.ORIGINAL
			);
		} else {
			bytes['nonce'] = sodium.to_base64(
				sodium.randombytes_buf(sodium.crypto_box_NONCEBYTES),
				sodium.base64_variants.ORIGINAL
			);
		}
		return bytes;
	}

	static async encrypt(data, difficulty) {
		const sodium = await this.getSodium();
		const bytes = await Cyno.generate_bytes();
		
		const key = await Cyno.generate_key(
			data['master_key'], 
			bytes['salt'],
			difficulty
		);
		console.log('encrypting << ', data, difficulty); // DEBUG
		console.log('key << ', key); // DEBUG
		const encrypted = sodium.to_base64(sodium.crypto_aead_xchacha20poly1305_ietf_encrypt(
			data['password'],
			data['master_key_ad'],
			null,
			sodium.from_base64(bytes['nonce'], sodium.base64_variants.ORIGINAL),
			sodium.from_base64(key, sodium.base64_variants.ORIGINAL),
		), sodium.base64_variants.ORIGINAL);

		return {
			difficulty: difficulty,
			encrypted: encrypted,
			bytes: bytes
		};
	}


	static async decrypt(data, to_string=true) {
		let sodium 		= await this.getSodium();
		let decrypted 	= sodium.crypto_aead_xchacha20poly1305_ietf_decrypt(
			null,
			sodium.from_base64(data.cipher,sodium.base64_variants.ORIGINAL),
			data.masterkey_ad,
			sodium.from_base64(data.nonce,sodium.base64_variants.ORIGINAL),
			sodium.from_base64(data.key,sodium.base64_variants.ORIGINAL)
		);
		if(to_string) {
			return {
				decrypted: sodium.to_string(decrypted)
			};
		} else {
			return {
				decrypted: sodium.to_base64(decrypted, sodium.base64_variants.ORIGINAL)
			};
		}
	}

	static async box(data) {
		console.log(data);
		let sodium = await this.getSodium();
		let bytes = await Cyno.generate_bytes(0);
		let box = sodium.to_base64(sodium.crypto_box_easy(
			data.message,	
			sodium.from_base64(bytes['nonce'], sodium.base64_variants.ORIGINAL),
			sodium.from_base64(data.pk, sodium.base64_variants.ORIGINAL),
			sodium.from_base64(data.sk, sodium.base64_variants.ORIGINAL)
		), sodium.base64_variants.ORIGINAL);
		return {
			encrypted: box,
			nonce: bytes['nonce']
		};
	}	

	static async open_box(data) {
		console.log(data);
		let sodium = await this.getSodium();
		let opened = sodium.crypto_box_open_easy(
			sodium.from_base64(data.cipher, sodium.base64_variants.ORIGINAL),	
			sodium.from_base64(data.nonce, sodium.base64_variants.ORIGINAL),
			sodium.from_base64(data.pk, sodium.base64_variants.ORIGINAL),
			sodium.from_base64(data.sk, sodium.base64_variants.ORIGINAL)
		);
		return {
			decrypted: sodium.to_string(opened)
		};

	}

	static async setup(data, difficulty) {
		console.log(data);
		let sodium 	= await this.getSodium();
		let keypair	= sodium.crypto_box_keypair();

		let xchacha_bytes 	= await Cyno.generate_bytes(1);
		// let curve_bytes 	= await Cyno.generate_bytes(0); // DEBUG
		let key 			= await Cyno.generate_key(data.masterkey, xchacha_bytes['salt'], difficulty);
		
		let encrypted = sodium.to_base64(sodium.crypto_aead_xchacha20poly1305_ietf_encrypt(
			keypair.privateKey,
			data.masterkey_ad,
			null,
			sodium.from_base64(xchacha_bytes['nonce'], sodium.base64_variants.ORIGINAL),
			sodium.from_base64(key, sodium.base64_variants.ORIGINAL),
		), sodium.base64_variants.ORIGINAL);

		return {
			salt: xchacha_bytes['salt'],
			nonce: xchacha_bytes['nonce'],
			sk_unencrypted: sodium.to_base64(keypair.privateKey, sodium.base64_variants.ORIGINAL),
			sk_encrypted: encrypted,
			pk: sodium.to_base64(keypair.publicKey, sodium.base64_variants.ORIGINAL),
			difficulty: difficulty,
			key: key, // DEBUG
		};

	}

	static async hash(message) {
		let sodium = await this.getSodium();
		return sodium.to_base64(sodium.crypto_generichash(
			64, 
			sodium.from_string(message)
		), sodium.base64_variants.ORIGINAL);
	}
}
