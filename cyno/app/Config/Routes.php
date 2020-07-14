<?php
namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Landing');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */






// API
$routes->group('api', function ($routes) {
    $routes->group('v1', function ($routes) {
        $routes->group('login', ['namespace' => '\App\Controllers\Api\v1'], function ($routes) {
            $routes->get('/', 'Login::index');
            $routes->post('authenticate', 'Login::authenticate');
        });
        $routes->group('passwords', ['filter' => 'jwtauth', 'namespace' => '\App\Controllers\Api\v1'], function ($routes) {
            $routes->get('/', 'Passwords::index');
            $routes->post('save_encrypted', 'Passwords::save_encrypted');
            $routes->get('search', 'Passwords::search');
            $routes->post('exists', 'Passwords::exists');
            $routes->post('shared_decryption_bytes', 'Passwords::shared_decryption_bytes');
        });
    });
});




























$routes->get('/', 'Landing::index', ['as' => 'root']);
// $routes->cli('jobs/encrypt/(:segment)', 'Jobs::encrypt/$1');


// Authentication
$routes->group('auth', function ($routes) {
    // Login
    $routes->get('login', 'Login::index', ['as' => 'user_login']);
    $routes->post('login/validation', 'Login::validation', ['as' => 'user_login_validation']);

    // Registration
    $routes->get('register', 'Register::index', ['as' => 'user_register']);
    $routes->post('register', 'Register::create', ['as' => 'user_create']);

    // Email
    $routes->get('validate_email/(:hash)', 'Email::validate_email/$1', ['as' => 'user_validate_email']);
    $routes->post('resend_email', 'Email::resend_email', ['as' => 'user_resend_email']);
});



// Dashboard
$routes->group('dashboard', function($routes) {

    $routes->get('/', 'Dashboard::index', ['as' => 'dashboard']);

    // Setup
    $routes->group('setup', function($routes) {
        $routes->get('/', 'Setup::index', ['as' => 'dashboard_setup']);
        $routes->post('validation', 'Setup::validation', ['as' => 'dashboard_validation']);
    });


	// Profile
	$routes->group('profile', function($routes) {
		$routes->get('/', 'Profile::index', ['as' => 'dashboard_profile']);
        $routes->get('settings', 'Profile::settings', ['as' => 'dashboard_profile_settings']);
        $routes->put('validate_settings', 'Profile::validate_settings');
		$routes->delete('logout', 'Profile::logout', ['as' => 'dashboard_profile_logout']);
	});


    // Passwords
    $routes->group('passwords', function($routes) {
        $routes->get('/', 'Passwords::index', ['as' => 'dashboard_passwords']);
        $routes->get('new', 'Passwords::new', ['as' => 'dashboard_password_new']);
        $routes->post('create', 'Passwords::create', ['as' => 'dashboard_password_create']);
        $routes->get('(:hash)', 'Passwords::show/$1', ['as' => 'dashboard_password_show']);
        $routes->get('(:hash)/edit', 'Passwords::edit/$1', ['as' => 'dashboard_password_edit']);
        $routes->put('(:hash)', 'Passwords::update/$1', ['as' => 'dashboard_password_update']);
        $routes->delete('(:hash)', 'Passwords::delete/$1', ['as' => 'dashboard_password_delete']);

        // Ajax
        $routes->get('get_bytes/(:hash)', 'Passwords::get_bytes/$1', ['as' => 'dashboard_password_ajax_get_bytes']);
        $routes->post('decrypt/(:hash)', 'Passwords::decrypt/$1', ['as' => 'dashboard_password_ajax_decrypt']);
    });

    // Folders
    $routes->group('folders', function($routes) {
        $routes->get('/', 'Folders::index', ['as' => 'dashboard_folders']);
        $routes->get('new', 'Folders::new', ['as' => 'dashboard_folder_new']);
        $routes->post('create', 'Folders::create', ['as' => 'dashboard_folder_create']);
        $routes->get('(:hash)', 'Folders::show/$1', ['as' => 'dashboard_folder_show']);
        $routes->get('(:hash)/edit', 'Folders::edit/$1', ['as' => 'dashboard_folder_edit']);
        $routes->put('(:hash)', 'Folders::update/$1', ['as' => 'dashboard_folder_update']);
        $routes->delete('(:hash)', 'Folders::delete/$1', ['as' => 'dashboard_folder_delete']);
    });

    // Shared
    $routes->group('shared', function($routes) {
        // Shared to me
        $routes->group('me', function($routes) {
            $routes->get('/', 'Shared::index/me', ['as' => 'dashboard_shared_me']);
            $routes->get('(:hash)', 'Shared::show_me/$1', ['as' => 'dashboard_shared_me_show']);
        });
        // Shared to others
        $routes->group('others', function($routes) {
            $routes->get('/', 'Shared::index/others', ['as' => 'dashboard_shared_others']);
            $routes->get('(:hash)', 'Shared::show_others/$1', ['as' => 'dashboard_shared_others_show']);
            $routes->get('(:hash)/edit', 'Shared::edit/$1', ['as' => 'dashboard_shared_edit']);
            $routes->put('/', 'Shared::update', ['as' => 'dashboard_shared_update']);
            $routes->delete('(:hash)', 'Shared::delete/$1', ['as' => 'dashboard_shared_delete']);

        });

        $routes->post('create', 'Shared::create', ['as' => 'dashboard_shared_create']);
        $routes->post('decryption_bytes', 'Shared::decryption_bytes', ['as' => 'dashboard_shared_decryption_bytes']);
        $routes->post('get_bytes', 'Shared::get_bytes', ['as' => 'dashboard_shared_get_bytes']);
    });

    // Search
    $routes->group('search', function($routes) {
        $routes->get('/', 'Search::index', ['as' => 'dashboard_search']);
    });

    // Websites
    $routes->group('websites', function($routes) {
        $routes->get('/', 'Websites::index', ['as' => 'dashboard_websites']);
        $routes->get('(:hash)/passwords', 'Websites::passwords/$1', ['as' => 'dashboard_website_passwords']);
        $routes->get('(:hash)', 'Websites::show/$1', ['as' => 'dashboard_show_edit']);
        $routes->get('(:hash)/edit', 'Websites::edit/$1', ['as' => 'dashboard_website_edit']);
        $routes->put('(:hash)', 'Websites::update/$1', ['as' => 'dashboard_website_update']);
        $routes->delete('(:hash)', 'Websites::delete/$1', ['as' => 'dashboard_website_delete']);
    });

});







if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
