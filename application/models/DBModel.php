<?php
class DBModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$CI = &get_instance();
	}

	function EncryptDbLogin($key,$configDB)
	{
		$EKey = ENCRYPT_KEY.$key;
		$Uid = $this->encrypt->encode($configDB["username"], $EKey);
		$Pwd = $this->encrypt->encode($configDB["password"], $EKey);

		$qry = "Update TblConfig Set db_user='".$Uid."', db_pwd='".$Pwd."'";
		$this->bkt = $this->load->database($configDB, TRUE);
		$res = $this->bkt->query($qry);
		return true;
	}

	function DecryptDbLogin($key,$configDB)
	{
		$EKey = ENCRYPT_KEY.$key;
		$result = array();

		$this->bkt = $this->load->database($configDB, TRUE);
		$res = $this->bkt->query("Select isnull(db_user,'') as db_user, isnull(db_pwd,'') as db_pwd From TblConfig");
		if ($res->num_rows()>0) {
			$result["result"] = "sukses";
			$result["uid"] = $this->encrypt->decode($res->row()->db_user, $EKey);
			$result["pwd"] = $this->encrypt->decode($res->row()->db_pwd, $EKey);
		} else {
			$result["result"] = "gagal";
			$result["uid"] = "";
			$result["pwd"] = "";			
		}
		return $result;
	}

	public function GetParamDB($key="", $svr="", $db="")
	{
		$server = $svr;
		$database = $db;
		$uid = SQL_UID;
		$pwd = SQL_PWD;
		include_once APPPATH."/includes/Conn.php";
		$this->bkt = $this->load->database($config, TRUE);
		$res = $this->bkt->query("Select db_user as DB_USER, db_pwd as DB_PWD From TblConfig");
		
		$EKey = COMPANY.$key;
		$config["username"] = $this->encrypt->decode($res->row()->DB_USER, $EKey);
		$config["password"] = $this->encrypt->decode($res->row()->DB_PWD, $EKey);


		return $config;
	}	
}
?>
