document.addEventListener("turbolinks:load", () => {
	async function setup(data) {
		return new Promise(async resolve => {
			let setup = await Cyno.setup(data, data.difficulty);
			let payload = Object.assign(setup, {csrf_token_cyno: data.csrf_token_cyno});
			console.log(setup);
			Cyno.post(ROUTES.dashboard_validation, payload).then(function(result) {
				resolve(result);
			});
		});
	}
	
	// Sharing (One To One) 
	async function box(data, update=false) {
		console.log(data);
		let   box      = await Cyno.box(data);
		const _method  = (update) ? 'PUT' : 'POST'
		let response = await fetch((update) ? ROUTES.dashboard_shared_update : ROUTES.dashboard_shared_create, {
			method: _method,
			headers: {
				"Content-Type": "application/json",
				"X-Requested-With": "XMLHttpRequest",
			},
			body: JSON.stringify({
				cipher: box.encrypted,
				nonce: box.nonce,
				user_email: data.user_email,
				csrf_token_cyno: data.csrf_token_cyno,
				password_id: data.password_id,
			}),
		}
		);
		if (response.ok) {
			let json = await response.json();
			return json;
		} else {
			console.log("HTTP_ERROR: " + response.status);
		}
	}

	async function open_box(data) {
		let decrypted = await Cyno.open_box(data);
		return decrypted;
	}
	
	async function decrypt_sk(data) {
		let key = await Cyno.generate_key(data.masterkey, data.salt, data.difficulty);
		console.log(key);
		let _data = {
			key: key, 
			masterkey_ad: data.masterkey_ad, 
			nonce: data.nonce, 
			cipher: data.cipher 
		}
		// console.log(_data);
		let decrypted = await Cyno.decrypt(_data, false);
		return decrypted;
	}
	async function decrypt(form_data, bytes_url) {
		let bytes   = await Cyno.get(bytes_url);
		let key  = await Cyno.generate_key(form_data.masterkey, bytes.salt, form_data.difficulty);
		let data    = {
			key: key, 
			masterkey_ad: form_data.masterkey_ad, 
			nonce: bytes.nonce, 
			cipher: bytes.cipher
		}
		
		// csrf_token_cyno: form_data.csrf_token_cyno};
		let decrypted = await Cyno.decrypt(data);
		// let decrypt = await Cyno.post(nonce_url, data);
		return decrypted;
	}
	
	async function submit_decrypt(data, bytes_url) {
		let decrypted = await decrypt(
			data,
			bytes_url
			);
		return decrypted;
	}  
	
	async function encrypt(data, additional_data) {
		const encrypted = await Cyno.encrypt(data, data.difficulty);
		const date = new Date()-additional_data['analytics']['time'];
		const _additional_data = additional_data;
		_additional_data['analytics']['time'] = date;
		return {
			difficulty     : data.difficulty,
			encrypted      : encrypted,
			additional_data: _additional_data
		};
	}
	
	async function submit_encrypt(payload, encrypt_url) {
		let response = await Cyno.post(encrypt_url, {
			nonce          : payload['encrypted']['bytes']['nonce'],
			salt           : payload['encrypted']['bytes']['salt'],
			cipher         : payload['encrypted']['encrypted'],
			date           : payload['additional_data']['analytics']['time'],
			csrf_token_cyno: payload['additional_data']['csrf_token_cyno'],
			folder_id      : payload['additional_data']['folder_id'],
			title          : payload['additional_data']['title'],
			difficulty     : payload['difficulty']
		});
		return response;
	}
	
	function update_csrf(csrf) {
		document.getElementsByTagName('meta')["X-CSRF-TOKEN"].content = csrf;
	}
	
	function convert_form(form_data) {
		let object     = {};
		form_data.forEach(function(value, key) {
			object[key] = value;
		});
		return object;
	}
	
	
	
	
	

	
	
	
	
	
	
	
	

	////////////
	// Events //
	////////////

	// new folder event
	const new_folder_form         = document.getElementById('new_folder');
	const submit_new_folder_button = document.getElementById('submit_new_folder');
	if(new_folder_form != null) {
		new_folder_form.addEventListener('submit', e => {
			submit_new_folder.classList.add('is-loading');
			e.preventDefault();
			let form_data  = new FormData(new_folder_form);
			let data       = convert_form(form_data);
			Cyno.post(ROUTES.dasbhoard_folder_create, data).then(function(result) {
				update_csrf(result.csrf)
				console.log(result); // DEBUG
				submit_new_folder.classList.remove('is-loading');
				Turbolinks.visit(location.toString());
			});
		});
	}
	
	// Encryption event
	const encryption_form = document.getElementById('encryption_form');
	const submit_encrypt_button = document.getElementById('submit_encrypt');
	if(encryption_form != null) {
		encryption_form.addEventListener("submit", (e) => {
			e.preventDefault();
			submit_encrypt_button.classList.add('is-loading');
			const title           = document.getElementById('password_title').value;
			const password        = document.getElementById('password').value;
			const master_key      = document.getElementById('master_key').value;
			const master_key_ad   = document.getElementById('master_key_ad').value;
			const difficulty      = parseInt(document.getElementsByName('difficulty')[0].value);
			const additional_data = {
				csrf_token_cyno: document.getElementsByTagName("meta")["X-CSRF-TOKEN"].content,
				folder_id: document.getElementById("password_folder").value,
				title: title,
				analytics: {
					time: new Date(),
				},
			};
			
			// Encrypt Password
			encrypt({
				password     : password,
				master_key   : master_key,
				master_key_ad: master_key_ad,
				difficulty   : difficulty
			}, 
			additional_data,
			).catch((e) => {
				alert(e);
			}).then((result) => {
				console.log(result);
				submit_encrypt(result, ROUTES.dashboard_password_create).then(result => {
					submit_encrypt_button.classList.remove('is-loading');
					update_csrf(result.csrf);
					console.log(result);
					Turbolinks.visit(location.toString());
				});
			});
		});
	}

	// Update Encryption event
	const update_encryption_form = document.getElementById('update_encryption_form');
	const submit_update_encryption_form = document.getElementById('submit_update_encryption_form');
	if(update_encryption_form != null) {
		update_encryption_form.addEventListener("submit", (e) => {
			e.preventDefault();
			submit_update_encryption_form.classList.add('is-loading');
			// let form_data     = new FormData(update_encryption_form);
			// let update_password_form_data = convert_form(form_data);
			const password_id     = document.getElementsByName('password_id')[0].value;
			const password        = document.getElementById('password').value;
			const master_key      = document.getElementById('master_key').value;
			const master_key_ad   = document.getElementById('master_key_ad').value;
			const difficulty      = parseInt(document.getElementsByName('difficulty')[0].value);
			const additional_data = {
				csrf_token_cyno: document.getElementsByTagName("meta")["X-CSRF-TOKEN"].content,
				analytics: {
					time: new Date(),
				},
			};
			
			// Encrypt Password
			encrypt({
				password     : password,
				master_key   : master_key,
				master_key_ad: master_key_ad,
				difficulty   : difficulty
			},
			additional_data,
			).catch((e) => {
				alert(e);
			}).then((result) => {
				console.log(result);
				fetch(ROUTES.dashboard_password_update, {
					method: 'PUT',
					headers: {
						'Content-Type':'application/json',
						"X-Requested-With": "XMLHttpRequest",
					},
					body: JSON.stringify({
						nonce          : result['encrypted']['bytes']['nonce'],
						salt           : result['encrypted']['bytes']['salt'],
						cipher         : result['encrypted']['encrypted'],
						date           : result['additional_data']['analytics']['time'],
						csrf_token_cyno: result['additional_data']['csrf_token_cyno'],
						difficulty     : result['difficulty'],
						password_id    : password_id
					})
				}).then(response => response.json()).then(data => {
					console.log(data); // DEBUG
					submit_update_encryption_form.classList.remove('is-loading');
					update_csrf(data.csrf);
					Turbolinks.visit(location.toString());
				});
			});
		});
	}	


	// Decryption event
	const share = {
		password    : null,
		pk          : null,
		masterkey   : null,
		masterkey_ad: null,
		
		get getPassword() {
			return this.password;
		},
		set setPassword(value) {
			this.password = value;
		},
		
		get getMasterkey() {
			return this.masterkey;
		},
		set setMasterkey(value) {
			this.masterkey = value;
		},
		
		get getMasterkey_ad() {
			return this.masterkey_ad;
		},
		set setMasterkey_ad(value) {
			this.masterkey_ad = value;
		},
		
		get getPk() {
			return this.pk;
		},
		set setPk(value){
			this.pk = value;
		}
	}
	if(document.getElementById('decrypt_form') != null) {
		document.getElementById('decrypt_form').addEventListener("submit", function(e) {
			e.preventDefault();
			document.getElementById('submit_decrypt').classList.add('is-loading');
			let form_data  = new FormData(document.getElementById('decrypt_form'));
			let data       = convert_form(form_data);
			submit_decrypt(
				data,
				data.bytes_url
				).then(function(result) {
					share.setPassword       = result.decrypted;
					share.setMasterkey      = data.masterkey;
					share.setMasterkey_ad   = data.masterkey_ad;
					document.getElementById('decrypted_password').classList.remove('is-hidden');
					document.getElementById('submit_decrypt').classList.remove('is-loading');
					document.getElementById('decrypted_password_value').value = result.decrypted;
					document.getElementById('share_password_button').classList.remove('is-hidden');
				}).catch((error) => {
					document.getElementById('submit_decrypt').classList.remove('is-loading');
					console.log(error);
					alert('error');
				});
			});
	}
	// Share button event
	if(document.getElementById('share_password_button') != null) {
		document.getElementById('share_password_button').addEventListener('click', function(e) {
			e.preventDefault();
			document.getElementById('share_password_button').classList.add('is-loading');
			const share_modal = document.getElementById('share_modal');
			e.preventDefault();
			document.body.parentNode.classList.add('is-clipped')
			share_modal.classList.toggle('is-active');
			setInterval(() => {
				if(!share_modal.classList.contains('is-active')) {
					document.body.parentNode.classList.remove('is-clipped')
				}
			}, 10);
		})
	}
	
	// Share event
	if(document.getElementById('share_form') != null) {
		document.getElementById('share_form').addEventListener('submit', function(e) {
			e.preventDefault();
			const submit_share_button = document.getElementById('submit_share');
			submit_share_button.classList.add('is-loading');
			let form_data     = new FormData(document.getElementById('share_form'));
			let share_form_data = convert_form(form_data);
			Cyno.post(ROUTES.dashboard_shared_get_bytes, share_form_data).then(function(result) {
				if(result.error) {
					alert(result.error);
				} else {
					share.setPk = result.pk
					update_csrf(result.csrf);
					let data = {
						pk: share.getPk,
						nonce: result.nonce,       
						salt: result.salt,
						masterkey: share.getMasterkey,
						masterkey_ad: share.getMasterkey_ad,
						cipher: result.cipher,
						difficulty: result.difficulty
					}
					console.log(data,result); // DEBUG
					decrypt_sk(data).then(function(result) {
						let sk = result.decrypted;
						box({
							password_id: share_form_data.password_id,
							pk: data.pk,
							sk: sk,
							message: share.getPassword,
							user_email: share_form_data.user_email,
							csrf_token_cyno: document.getElementsByTagName('meta')["X-CSRF-TOKEN"].content
						}).then(function(result) {
							submit_share_button.classList.remove('is-loading');
							document.getElementById('share_password_button').classList.remove('is-loading');
							console.log(result); // DEBUG
							update_csrf(result.csrf);
						});
					});
				}
				
				
			});
		});
	}
	
	
	// Edit Share event
	const edit_share_form = document.getElementById('share_edit_form');
	if(edit_share_form != null) {
		edit_share_form.addEventListener('submit', function(e) {
			e.preventDefault();
			const submit_edit_share_button = document.getElementById('submit_edit_shared');
			submit_edit_share_button.classList.add('is-loading');
			let form_data            = new FormData(edit_share_form);
			let share_edit_form_data = convert_form(form_data);
			Cyno.post(ROUTES.dashboard_shared_get_bytes, share_edit_form_data).then(function(result) {
				if(result.error) {
					alert(result.error);
				} else {
					share.setPk = result.pk
					update_csrf(result.csrf);
					let data = {
						pk          : result.pk,
						nonce       : result.nonce,
						salt        : result.salt,
						masterkey   : share_edit_form_data.masterkey,
						masterkey_ad: share_edit_form_data.masterkey_ad,
						cipher      : result.cipher,
						difficulty  : result.difficulty
					}
					console.log(data,result); // DEBUG
					decrypt_sk(data).then(function(result) {
						let sk = result.decrypted;
						box({
							password_id    : share_edit_form_data.password_id,
							pk             : data.pk,
							sk             : sk,
							message        : share_edit_form_data.password,
							user_email     : share_edit_form_data.user_email,
							csrf_token_cyno: document.getElementsByTagName('meta')["X-CSRF-TOKEN"].content
						}, true).then(function(result) {
							submit_edit_share_button.classList.remove('is-loading');
							console.log(result); // DEBUG
							if(result.status) {
								Turbolinks.visit(location.toString()); // TODO: Change it later or think about it
							}
							// update_csrf(result.csrf);
						});
					});
				}
				
				
			});
		});
	}
	
	
	// Share Decryption event
	if(document.getElementById('share_decrypt_form') != null) {
		document.getElementById('share_decrypt_form').addEventListener('submit', function(e) {
			e.preventDefault();
			const submit_decrypt_shared = document.getElementById('submit_decrypt_shared');
			submit_decrypt_shared.classList.add('is-loading');
			
			let form_data     = new FormData(document.getElementById('share_decrypt_form'));
			let share_form_data = convert_form(form_data);
			share.setMasterkey      = share_form_data.masterkey;
			share.setMasterkey_ad   = share_form_data.masterkey_ad;
			Cyno.post(ROUTES.dashboard_shared_decryption_bytes, share_form_data).then(function(result) {
				console.log(result);
				share.setPk = result.pk;
				update_csrf(result.csrf);
				let data = {
					pk: share.getPk,
					nonce: result.nonce,    
					box_nonce: result.box_nonce,  
					salt: result.salt,
					masterkey: share.getMasterkey,
					masterkey_ad: share.getMasterkey_ad,
					cipher: result.cipher,
					difficulty: result.difficulty
				}
				decrypt_sk(data).then(function(result) {
					console.log(result);
					let sk = result.decrypted;
					open_box({
						pk: data.pk,
						sk: sk,
						cipher: share_form_data.cipher,
						nonce: data.box_nonce,
						user_email: share_form_data.user_email,
						// csrf_token_cyno: document.getElementsByTagName('meta')["X-CSRF-TOKEN"].content               
					}).then(function(result) {
						console.log(result);
						submit_decrypt_shared.classList.remove('is-loading');
						document.getElementById('decrypted_password').classList.remove('is-hidden');
						document.getElementById('decrypted_password_value').value = result.decrypted;
					});
					// box({
					//    pk: data.pk,
					//    sk: sk,
					//    message: share.getPassword,
					//    user_email: share_form_data.user_email,
					//    csrf_token_cyno: document.getElementsByTagName('meta')["X-CSRF-TOKEN"].content
					// }).then(function(result) {
					//    console.log(result);
					//    update_csrf(result.csrf);
					// });
				});
				
			});
		})
	}
	
	
	const submit_setup_button = document.getElementById('submit_setup_button');
	const setup_form = document.getElementById('setup_form');
	if(setup_form != null) {
		setup_form.addEventListener('submit', e => {
			submit_setup_button.classList.add('is-loading');
			e.preventDefault();
			let form_data  = new FormData(setup_form);
			let data       = convert_form(form_data);
			setup(data).then(result => {
				console.log(result);
				if(result.status === "SUCCESS") {
					submit_setup_button.classList.remove('is-loading');
					window.location.href = ROUTES.dashboard;
				}
			});
		});
	}
	
	
	// Event for modals close button
	function close_modal(element) {
		element.target.parentNode.classList.toggle('is-active');
		// console.log(element.target.parentNode.id); // DEBUG
		switch(element.target.parentNode.id) {
			case 'share_modal':
			document.getElementById('share_password_button').classList.remove('is-loading');
			break;
			
			default:
			break;
		}
	}
	
	const modal_close_buttons = document.getElementsByClassName('modal-close');
	const modal_backgrounds = document.getElementsByClassName('modal-background');
	if(modal_close_buttons.length > 0 || modal_backgrounds.length > 0) {
		Array.from(modal_close_buttons).forEach(close_button => close_button.addEventListener('click', e => close_modal(e)));
		Array.from(modal_backgrounds).forEach(background => background.addEventListener('click', e => close_modal(e)));
	}
	
	const new_password_button = document.getElementById('new_password_button');
	const new_password_modal = document.getElementById('new_password_modal');
	if(new_password_button != null) {
		new_password_button.addEventListener('click', e => {
			e.preventDefault();
			new_password_button.classList.toggle('is-loading');
			document.body.parentNode.classList.add('is-clipped')
			new_password_modal.classList.toggle('is-active');
			setInterval(() => {
				if(!new_password_modal.classList.contains('is-active')) {
					document.body.parentNode.classList.remove('is-clipped')
					new_password_button.classList.remove('is-loading');
				}
			}, 10);
		});
	}
	const new_folder_button = document.getElementById('new_folder_button');
	const new_folder_modal = document.getElementById('new_folder_modal');
	if(new_folder_button != null) {
		new_folder_button.addEventListener('click', e => {
			e.preventDefault();
			new_folder_button.classList.toggle('is-loading');
			document.body.parentNode.classList.add('is-clipped')
			new_folder_modal.classList.toggle('is-active');
			setInterval(() => {
				if(!new_folder_modal.classList.contains('is-active')) {
					document.body.parentNode.classList.remove('is-clipped')
					new_folder_button.classList.remove('is-loading');
				}
			}, 10);
		});
	}  
	
	// Event for notifications close button
	(document.querySelectorAll('.notification .delete') || []).forEach(deleteButton => {
		let notification = deleteButton.parentNode;
		
		deleteButton.addEventListener('click', () => {
			notification.parentNode.removeChild(notification);
		});
	});
	
	const copy_password_button = document.getElementById("copy_password");
	if(copy_password_button !== null) {
		copy_password_button.addEventListener('click', () => {
			// Get the text field
			var copy_password = document.getElementById("decrypted_password_value");
			
			// Select the text field
			copy_password.select();
			copy_password.setSelectionRange(0, 99999); // For mobile devices
			
			// Copy the text inside the text field
			document.execCommand("copy");
			
			// Alert the copied text
			alert("Copied the password: " + copy_password.value);
		});
	}

  // Get all "navbar-burger" elements
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }

});

// Confirm Popup
function show_alert(message) {
	if(!confirm(message)) {
		return false;
	}
	return true;
}


