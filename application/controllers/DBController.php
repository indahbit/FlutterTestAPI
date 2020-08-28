<?php 
header('Access-Control-Allow-Origin:*');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DBController extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('FormLibrary');
		$this->load->model('DBModel');
	}
	
	public function EncryptDbLogin()
	{
		$keyAPI = 'APITES';
		$api = urldecode($this->input->get("api"));
		$key = urldecode($this->input->get('key'));
		$server = urldecode($this->input->get('svr'));
		$database = urldecode($this->input->get('db'));
		$uid = urldecode($this->input->get("uid"));
		$pwd = urldecode($this->input->get("pwd"));
		include_once APPPATH."/includes/Conn.php";

		if($keyAPI==$api) {
			$array_data = array();
			if ($this->DBModel->EncryptDbLogin($key, $config)) {
				$result["result"] = "sukses";
				$result["ket"] = "Update db_user dan db_pwd Berhasil";
			} else {
				$result["result"] = "gagal";
				$result["ket"] = "Update db_user dan db_pwd Gagal";
			}
		} else {
			$result["result"] = "gagal";
			$result["error"] = "Kode API tidak sama";
		}
		$hasil = json_encode($result);
		header('HTTP/1.1: 200');
		header('Status: 200');
		header('Content-Length: '.strlen($hasil));
		exit($hasil);		
	}

	public function DecryptDbLogin()
	{
		$keyAPI = 'APITES';
		$api = urldecode($this->input->get("api"));
		$key = urldecode($this->input->get('key'));
		$server = urldecode($this->input->get('svr'));
		$database = urldecode($this->input->get('db'));
		$uid = SQL_UID;
		$pwd = SQL_PWD;
		include_once APPPATH."/includes/Conn.php";

		if($keyAPI==$api) {
			$array_data = array();
			$res = $this->DBModel->DecryptDbLogin($key, $config);
			if ($res["result"]=="sukses") {
				$result["result"] = "sukses";
				$result["uid"] = $res["uid"];
				$result["pwd"] = $res["pwd"];
				$result["ket"] = "Get db_user dan db_pwd Berhasil";
			} else {
				$result["result"] = "gagal";
				$result["uid"] = "";
				$result["pwd"] = "";
				$result["ket"] = "Get db_user dan db_pwd Gagal";
			}
		} else {
			$result["result"] = "gagal";
			$result["uid"] = "";
			$result["pwd"] = "";
			$result["error"] = "Kode API tidak sama";
		}
		$hasil = json_encode($result);
		header('HTTP/1.1: 200');
		header('Status: 200');
		header('Content-Length: '.strlen($hasil));
		exit($hasil);		
	}

}