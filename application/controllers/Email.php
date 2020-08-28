<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('FormLibrary');
		$this->load->model('EmployeeModel');
		$this->load->model('EmailModel');
	}

	public function EmailAll()
	{
		$keyAPI = 'APITES';
		$api = $this->input->get('api');

		if($keyAPI==$api) {
			$recipients = array();

			$msg_html = "Dear All,<br><br>";
			//$msg_html.= "Web <b>http://mycompany.id/</b> sudah online kembali.<br>";
			//$msg_html.= "Terima Kasih<br><br>";
			//$msg_html.= "NB: ini bukan April Mop<br><br>";
			$msg_html.= "Jakarta, 01 April 2017<br><i>Web MyCompany.id Auto Email</i><br>(mohon tidak mereply email ini)";
			//die($msg_html);

			set_time_limit(600);
			$employees = $this->EmployeeModel->GetAllEmployeeEmail();
			$counter = 0;
			$allrecipients=array();
			foreach($employees as $e)
			{
				if ($counter<200)
				{
					$bool_cc = ((strpos($e->EMAIL, '@office')==false)? true:false);
					if ($bool_cc)
					{
						array_push($recipients, $e->EMAIL);
						array_push($allrecipients, $e->EMAIL);
						$counter = $counter + 1;
					}
				}
				else
				{
					$this->EmailModel->SendEmailToAll($msg_html, $recipients);
					$recipients = array();
					$counter = 0;
				}
			}

			if ($counter!=0)
			{
				$this->EmailModel->SendEmailToAll($msg_html, $recipients);
				$recipients = array();
			}

			$hasil = json_encode(array("sukses"=>"sukses", "recipients"=>$allrecipients));
			header('HTTP/1.1: 200');
			header('Status: 200');
			header('Content-Length: '.strlen($hasil));
			exit($hasil);
		}
		/*
		else {
			$data = array('nama'=>'Kode Salah');
			$hasil = json_encode($data);
			header('HTTP/1.1: 200');
			header('Status: 200');
			header('Content-Length: '.strlen($hasil));
			exit($hasil);
		}*/
	}

	public function EmailTes()
	{
		$keyAPI = 'APITES';
		$api = $this->input->get('api');
		$email = $this->input->get('email');

		if($keyAPI==$api) {
			set_time_limit(0);

			$msg_html= "INI ADALAH EMAIL TES";
			$subject = "EMAIL TEST";
			$alias = "Auto-Email My Company";

			$this->EmailModel->SendEmailToOne($msg_html, $email, $subject, $alias);
			

			$hasil = json_encode("sukses");
			header('HTTP/1.1: 200');	
			header('Status: 200');
			header('Content-Length: '.strlen($hasil));
			exit($hasil);
		}
		/*
		else {
			$data = array('nama'=>'Kode Salah');
			$hasil = json_encode($data);
			header('HTTP/1.1: 200');
			header('Status: 200');
			header('Content-Length: '.strlen($hasil));
			exit($hasil);
		}*/
	}	

	public function EmailNotification()
	{
		//WEBAPI & "Email/EmailNotification?key=" & aKey & "&msg=" & anErrMsg & "&email=" & anEmail & "&api=APITES"

		$keyAPI = 'APITES';
		$api = $this->input->get('api');
		$key = $this->input->get('key');
		$msg = $this->input->get('msg');
		$email = $this->input->get('email');

		$alias = "Auto-Email mycompany.id";

		if($keyAPI==$api) {
			set_time_limit(0);

			$msg_html = "";
			$msgs = explode("#", $msg);
			for ($i=0;$i<count($bodies);$i++)
			{
				$msg_html.= $msgs[$i];
				$msg_html.= "<br>";
			}

			$recipients = array();
			$dataEmail = explode(";", $email);
			for($r=0;$r<count($dataEmail);$r++)
			{
				array_push($recipients, $dataEmail[$r]);
			}

			$this->EmailModel->SendEmailToOne($msg_html, $recipients, $key, $alias);
			$recipients = array();				
			

			$hasil = json_encode("sukses");
			header('HTTP/1.1: 200');	
			header('Status: 200');
			header('Content-Length: '.strlen($hasil));
			exit($hasil);
		}
		/*
		else {
			$data = array('nama'=>'Kode Salah');
			$hasil = json_encode($data);
			header('HTTP/1.1: 200');
			header('Status: 200');
			header('Content-Length: '.strlen($hasil));
			exit($hasil);
		}*/
	}

}