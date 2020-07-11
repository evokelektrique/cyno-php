<?php
namespace Config;

use CodeIgniter\Events\Events;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

use App\Models\EmailTokenModel;
// use App\Models\CategoryModel;


/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', function () {
    if (ENVIRONMENT !== 'testing') {
        while (\ob_get_level() > 0) {
            \ob_end_flush();
        }

        \ob_start(function ($buffer) {
            return $buffer;
        });
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (ENVIRONMENT !== 'production') {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        Services::toolbar()->respond();
    }
});


// Events::on('user_default_category', function($data) {
//     // $category_model = new CategoryModel();
//     // if(count($category_model->where('title', $data['title'])->where('user_id',$data['user_id'])->findAll()) == 0) {
//     //     return $category_model->insert($data);
//     // } else {
//     //     return FALSE;
//     // }
// });

// Send Verification Email
Events::on('user_registration', function ($data) {

    $mail = new PHPMailer(true);
    $model = new EmailTokenModel();
    try {
        $length = getenv('email.bytes_length');
        $bytes 	= random_bytes($length);
        $hash 	= bin2hex($bytes);
        $email_data = [
        	'hash' => $hash,
        	'user_id' => $data['user_id']
        ];
        $email_id = $model->insert($email_data);
        if($email_id > 0) {
	        // Server settings
	        // $mail->SMTPDebug = SMTP::DEBUG_OFF;
	        $mail->isSMTP();
	        $mail->Host = 'mail.cyno.ir';
	        $mail->SMTPAuth = true;
	        $mail->Username = 'noreply@cyno.ir';
	        $mail->Password = '1.Programmer@3412!1';
	        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	        $mail->Port = 465;

	        $mail->setFrom('noreply@cyno.ir', 'Cyno');
	        $mail->addAddress($data['email']);
	        $mail->isHTML(true);

	        $mail->Subject = 'Cyno - Email Verification Subject';
	        $mail->Body = view('mail/Verification', $email_data);

	        $mail->send();

	        return true;
        }
    } catch (Exception $e) {
        return false;
    }

});