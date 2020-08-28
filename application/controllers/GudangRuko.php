<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class GudangRuko extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('GudangRukoModel');
    }

    public function Login()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $userid = trim($this->input->post('userid'));
        $password = trim($this->input->post('password'));
        $database_name = trim($this->input->post('database'));
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;
        // print_r($userid);die;


        include_once APPPATH."/includes/Connections.php";
        if ($keyAPI == $key) {

            $userlogin = $userid;
            $userpass = $password;


            $user_login = $this->GudangRukoModel->GetUserLogin($config,$userlogin, $userpass, $jenis_gudang);
            $token = array();
            // print_r($user_login);
            // $token['nohp'] = $userlogin;
            if($user_login){
                $token['UserId'] = $user_login->UserId;
                
                $result = array(
                    'message' => 'success',
                    'token' => $token,
                    'error' => false,
                );
            }else{
                $result = array(
                    'error' => true,
                    'error_msg'=> 'Invalid credentitals'
                );

                $hasil = json_encode($result);
                header('HTTP/1.1: 403');
                header('Status: 403');
                header('Content-Length: ' . strlen($hasil));
                exit($hasil);
            }
            
        } else {
            $result = array(
                'error' => true,
                "error_msg"=> "Invalid credentitals"
            );

            $hasil = json_encode($result);
            header('HTTP/1.1: 403');
            header('Status: 403');
            header('Content-Length: ' . strlen($hasil));
            exit($hasil);
        }

        $hasil = json_encode($result);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function GetSettings()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;
        // print_r($userid);die;

        include_once APPPATH."/includes/Connections.php";
        if ($keyAPI == $key) {
            $settings = $this->GudangRukoModel->GetSettings($config);
  

            $token['isFaktur'] =  $settings->isFaktur;
            $token['isMutasi'] =  $settings->isMutasi;
            $token["result"] = "sukses";
            $data["token"] = $token;
            $data["error"]  = false;
            
        } else {
            $token["result"] = "gagal";
            $data["token"] = $token;
			$data["data"] = array();
			$data["error"] = "Kode API Salah";
        }

        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function SaveSettings()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $isFaktur = json_decode($this->input->post('isFaktur'));
        $isMutasi = json_decode($this->input->post('isMutasi'));
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;
        // print_r($userid);die;

        include_once APPPATH."/includes/Connections.php";

        if ($keyAPI == $key) {
            $results = $this->GudangRukoModel->SaveSettings($config, $isFaktur, $isMutasi);
            $token["result"] = "sukses";
            $data["token"] = $token;
            $data["error"]  = false;
		} else {
            $token["result"] = "gagal";
            $data["token"] = $token;
			$data["error"] = "Kode API Salah";
		}
		
        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);
    }

    public function TotalFakturGantung()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;
        // print_r($userid);die;

        include_once APPPATH."/includes/Connections.php";
        if ($keyAPI == $key) {
            $totalfaktur = $this->GudangRukoModel->GetTotalFakturGantung($config, $jenis_gudang);

            
            $token['data'] =  $totalfaktur;
            $token["result"] = "sukses";
            $data["token"] = $token;
            $data["error"]  = false;
            
        } else {
            $token["result"] = "gagal";
            $data["token"] = $token;
			$data["data"] = array();
			$data["error"] = "Kode API Salah";
        }

        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function CollectItems()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $type_trans =  $this->input->post('type_trans');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;
        // echo $type_trans;die;

        include_once APPPATH."/includes/Connections.php";
        if ($keyAPI == $key) {
            $items = $this->GudangRukoModel->GetCollectItems($config, $type_trans, 'N', $jenis_gudang);

            if (count($items)>0) 
			{
                $token['data'] =  $items;
                $token["result"] = "sukses";
                $data["token"] = $token;
                $data["error"]  = false;
			}
			else
			{
                $token["result"] = "gagal";
                $token["data"] = array();
                $data["token"] = $token;
                $data["error"] = "Tidak Ada Data";
			}
            
        } else {
            
            $token["result"] = "gagal";
            $data["token"] = $token;
			$data["data"] = array();
            $data["error"] = "Kode API Salah";
        }

        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function CollectItemDetails()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $nomor = $this->input->post('nomor');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;

        include_once APPPATH."/includes/Connections.php";
        if ($keyAPI == $key) {

            $items = $this->GudangRukoModel->GetCollectItemDetails($config, $nomor, $jenis_gudang);

            if (count($items)>0) 
			{
                $token['data'] =  $items;
                $token["result"] = "sukses";
                $data["token"] = $token;
                $data["error"]  = false;
			}
			else
			{
                $token["result"] = "gagal";
                $token["data"] = array();
                $data["token"] = $token;
                $data["error"] = "Tidak Ada Data";
            }
            
            
        } else {
            $data["result"] = "gagal";
			$data["data"] = array();
			$data["error"] = "Kode API Salah";
        }

        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function UpdateCollected()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $nomor = $this->input->post('nomor');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;
        // print_r($userid);die;
        // echo $nomor;die;

        include_once APPPATH."/includes/Connections.php";
        
        if ($keyAPI == $key) {
            $results = $this->GudangRukoModel->UpdateCollectedItems($config, $nomor, $jenis_gudang);
            $token["result"] = "sukses";
            $data["token"] = $token;
            $data["error"]  = false;
		} else {
            $token["result"] = "gagal";
            $data["token"] = $token;
			$data["error"] = "Kode API Salah";
        }
        
        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function ReturnItems()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $type_trans =  $this->input->post('type_trans');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;
        // print_r($userid);die;

        include_once APPPATH."/includes/Connections.php";
        if ($keyAPI == $key) {

            $items = $this->GudangRukoModel->GetReturnItems($config, $type_trans, 'Y', $jenis_gudang);

            if (count($items)>0) 
			{
                $token['data'] =  $items;
                $token["result"] = "sukses";
                $data["token"] = $token;
                $data["error"]  = false;
			}
			else
			{
                $token["result"] = "gagal";
                $token["data"] = array();
                $data["token"] = $token;
                $data["error"] = "Tidak Ada Data";
            }
            
            
        } else {
            $data["result"] = "gagal";
			$data["data"] = array();
			$data["error"] = "Kode API Salah";
        }

        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function ReturnItemDetails()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $nomor = $this->input->post('nomor');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;

        include_once APPPATH."/includes/Connections.php";
        if ($keyAPI == $key) {

            
            $items = $this->GudangRukoModel->GetReturnItemDetails($config, $nomor, $jenis_gudang);

            if (count($items)>0) 
			{
                $token['data'] =  $items;
                $token["result"] = "sukses";
                $data["token"] = $token;
                $data["error"]  = false;
			}
			else
			{
                $token["result"] = "gagal";
                $token["data"] = array();
                $data["token"] = $token;
                $data["error"] = "Tidak Ada Data";
            }

        } else {
            $data["result"] = "gagal";
			$data["data"] = array();
			$data["error"] = "Kode API Salah";
        }

        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function UpdateReturn()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $nomor = $this->input->post('nomor');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;
        // print_r($userid);die;

        include_once APPPATH."/includes/Connections.php";

        if ($keyAPI == $key) {
            $results = $this->GudangRukoModel->UpdateReturnItems($config, $nomor, $jenis_gudang);
            $token["result"] = "sukses";
            $data["token"] = $token;
            $data["error"]  = false;
		} else {
            $token["result"] = "gagal";
            $data["token"] = $token;
			$data["error"] = "Kode API Salah";
        }
		
        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function ListPotongStock()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;
        // print_r($userid);die;

        include_once APPPATH."/includes/Connections.php";
        if ($keyAPI == $key) {

            $items = $this->GudangRukoModel->GetListPotongStock($config, $jenis_gudang);

            if (count($items)>0) 
			{
                $token['data'] =  $items;
                $token["result"] = "sukses";
                $data["token"] = $token;
                $data["error"]  = false;
			}
			else
			{
                $token["result"] = "gagal";
                $token["data"] = array();
                $data["token"] = $token;
                $data["error"] = "Tidak Ada Data";
            }
            
        } else {
            $data["result"] = "gagal";
			$data["data"] = array();
			$data["error"] = "Kode API Salah";
        }

        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function PotongStockItemDetails()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $nomor = $this->input->post('nomor');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $keyAPI;

        include_once APPPATH."/includes/Connections.php";
        if ($keyAPI == $key) {

            $items = $this->GudangRukoModel->GetPotongStockItemDetails($config, $nomor, $jenis_gudang);

            if (count($items)>0) 
			{
                $token['data'] =  $items;
                $token["result"] = "sukses";
                $data["token"] = $token;
                $data["error"]  = false;
			}
			else
			{
                $token["result"] = "gagal";
                $token["data"] = array();
                $data["token"] = $token;
                $data["error"] = "Tidak Ada Data";
            }
            
        } else {
            $data["result"] = "gagal";
			$data["data"] = array();
			$data["error"] = "Kode API Salah";
        }

        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

    public function PotongStock()
    {
        $obj = json_decode(file_get_contents('php://input'));
        
        $key = $this->input->post('key');
        $nomor = $this->input->post('nomor');
        $database_name = $this->input->post('database');
        $server_source = trim($this->input->post('server'));
        $jenis_gudang =  trim($this->input->post('jenisgudang'));
		$sql_uid = SQL_UID;
        $sql_pwd = SQL_PWD;
        
        $keyAPI = 'APITES';
        // echo $nomor;die;
        // print_r($userid);die;

        include_once APPPATH."/includes/Connections.php";

        if ($keyAPI == $key) {
            $results = $this->GudangRukoModel->PotongStock($config, $nomor, $jenis_gudang);
            $token["result"] = "sukses";
            $data["token"] = $token;
            $data["error"]  = false;
		} else {
            $token["result"] = "gagal";
            $data["token"] = $token;
			$data["error"] = "Kode API Salah";
        }
		
        $hasil = json_encode($data);
        header('HTTP/1.1: 200');
        header('Status: 200');
        header('Content-Length: ' . strlen($hasil));
        exit($hasil);

        // echo json_encode($result);
    }

}
