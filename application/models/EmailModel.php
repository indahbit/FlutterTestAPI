<?php
class EmailModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('EmployeeModel');
		$this->load->model('LeaveRequestModel');
		$this->load->model('ConfigSysModel');
		$this->load->model('UserModel');
		$this->load->model('UserDivisionMappingModel');
	}

	public function ConfigGagal()
	{
		/*
		$email_config = Array(
		    'protocol'  => $configsys->mail_protocol,
		    'smtp_host' => $configsys->mail_host,
		    'smtp_port' => $configsys->mail_port,
		    'smtp_user' => $configsys->mail_user,
		    'smtp_pass' => $configsys->mail_pwd,
		    'mailtype'  => 'html',
		    'charset'   => 'utf-8',
		    'starttls'  => true,
		    'newline'   => '\r\n'
		);
		$this->load->library('email', $email_config);
		*/
	}

	public function Email()
	{
		return true;
	}

	public function SendEmailToOne($msg_html="", $recipients="", $subject="WEB MY COMPANY ANNOUNCEMENT", $alias="MYCOMPANY EMAIL")
	{
		set_time_limit(0);
		$configsys = $this->ConfigSysModel->Get(); 
		$this->load->library('email');
	
		$this->email->from($configsys->mail_user, $alias);
		$this->email->to($recipients);	

		$email_content = $msg_html;
		$this->email->subject($subject);
		$this->email->message($email_content);	
		if ($this->email->send())
			return true;
		else
			return false;		
	}
}
