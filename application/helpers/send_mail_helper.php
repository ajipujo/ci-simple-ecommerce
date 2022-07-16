<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('send_mail')) {
	function send_mail($params)
	{
		$api_key = getenv('API_KEY_SENDINBLUE');

		$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $api_key);

		$apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
			new GuzzleHttp\Client(),
			$config
		);
		$sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
		$sendSmtpEmail['subject'] = $params['subject'];
		$sendSmtpEmail['htmlContent'] = $params['content'];
		$sendSmtpEmail['sender'] = array('name' => 'Vavapedia', 'email' => getenv('SENDER_SENDINBLUE'));
		$sendSmtpEmail['to'] = array(
			array('email' => $params['email_recipient'], 'name' => $params['name_recipient'])
		);
		$sendSmtpEmail['replyTo'] = array('email' => getenv('SENDER_SENDINBLUE'), 'name' => 'Vavapedia');
		$sendSmtpEmail['headers'] = array('Some-Custom-Name' => 'unique-id-1234');
		$sendSmtpEmail['params'] = array('parameter' => 'My param value', 'subject' => 'New Subject');

		try {
			$apiInstance->sendTransacEmail($sendSmtpEmail);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
}
