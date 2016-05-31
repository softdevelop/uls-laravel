<?php namespace App\Services;
use Mail;
class MailService{

	public static function emailWelcome($template, $data = [], $function){
		Mail::send($template, $data, $function);
	}

	public static function send($template, $data = [], $function){
		// return true;
		try{
			Mail::send($template, $data, $function);
		}catch (\Swift_TransportException $STe) {
		}
		catch(\Exception $e){
			
		}
	}
	public static function queue($template, $data = [], $function){
		try{
			Mail::queue($template, $data, $function);
		}catch (\Swift_TransportException $STe) {
		}
		catch(\Exception $e){
			
		}
	}

	public static function later($time, $template, $data = [], $function){
		try{
			Mail::later($time, $template, $data, $function);
		}catch (\Swift_TransportException $STe) {
		}
		catch(\Exception $e){
			
		}
	}

	public static function checkEmail($email){
		// $emailsAllowed = ['john@rowboatllc.com','toan@httsolution.com', 'test@httsolution.com', 'phuong@httsolution.com', 'huy@httsolution.com','than@httsolution.com', 'tony@rowboatllc.com', 'toanho22@gmail.com'];
		// if(in_array($email, $emailsAllowed)){
		// 	return $email;
		// }
		return env('email_test', $email);
	}
}