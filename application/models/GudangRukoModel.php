<?php
	class GudangRukoModel extends CI_Model
	{
		// function __construct()
		// {
        //     parent::__construct();
        //     $CI = &get_instance();
		//     $this->gudangruko = $CI->load->database('gudangruko', TRUE);
		// }

		
		function GetUserLogin($config, $userid, $password, $jenis_gudang)
		{
            // $this->gudangruko->trans_start();
			$this->db = $this->load->database($config,TRUE);
			// echo $userid;
			if($jenis_gudang=='SPAREPART-RUKO'){
				$this->db->where('UserId', $userid);
				$this->db->where('Password', $password);
				$res = $this->db->get('t_usersp');
			}else{
				$this->db->where('UserId', $userid);
				$this->db->where('Password', $password);
				$res = $this->db->get('t_user');
			}

            // die($this->db->last_query());
            // print_r($res->result());die;
            // $this->gudangruko->trans_complete();

			if($res->num_rows() > 0)
				return $res->row();
			else
				return array();
		}
		
		function GetSettings($config)
		{
			$this->db = $this->load->database($config,TRUE);

			$str = "select * from T_Settings";
				
				$res = $this->db->query($str);
				// print_r($res->row());die;
				return $res->row();
		}

		function SaveSettings($config, $isFaktur, $isMutasi)
		{
			$this->db = $this->load->database($config,TRUE);
	
			$this->db->trans_start();
	
			// $data = array(
			// 	'isFaktur'	=>  $isFaktur, 
			// 	'isMutasi'=>  $isMutasi
			// );

			// $this->db->set("isFaktur", $isFaktur);
			// $this->db->set("isMutasi", $isMutasi);
			// $this->db->update('T_Settings', $data);
			$res = $this->db->query("update T_Settings SET isFaktur=$isFaktur,isMutasi=$isMutasi");
			// die($this->db->last_query());
			// die($res);
			// return $res;
				
	
			$this->db->trans_complete();

			return 'Sukses';
		}

		function GetTotalFakturGantung($config, $jenis_gudang)
		{
            // $this->gudangruko->trans_start();
			$this->db = $this->load->database($config,TRUE);

			if($jenis_gudang=='SPAREPART-RUKO'){
				$str = "select distinct No_Bukti from T_ListingSP where collected = 'N'";
			} else {
				$str = "select distinct No_Bukti from T_Listing where collected = 'N'";
			}

				$res = $this->db->query($str);
				// echo $res->num_rows();die;
				return $res->num_rows();
		}

		function GetCollectItems($config, $type_trans, $collected, $jenis_gudang)
		{
            // $this->gudangruko->trans_start();
			$this->db = $this->load->database($config,TRUE);

			if($jenis_gudang=='SPAREPART-RUKO'){	
				$str = "select  distinct a.No_Bukti, ISNULL(b.Nm_Plg,c.Nm_Gudang) as Nm_Plg from T_ListingSP a 
						left join TblMsDealerSP b on a.Kd_Plg = b.Kd_Plg
						left join TblMsGudangSP c on a.Kd_Plg = c.Kd_Gudang 
						where collected = '".$collected."'
						and type_trans in (".$type_trans.") 
						order by No_Bukti Asc";
			} else {
				$str = "select  distinct a.No_Bukti, ISNULL(b.Nm_Plg,c.Nm_Gudang) as Nm_Plg from T_Listing a 
						left join TblMsDealer b on a.Kd_Plg = b.Kd_Plg
						left join TblMsGudang c on a.Kd_Plg = c.Kd_Gudang 
						where collected = '".$collected."'
						and type_trans in (".$type_trans.") 
						order by No_Bukti Asc";
			}
				
			// echo $str;die;
				$res = $this->db->query($str);
				return $res->result();
		}

		function GetCollectItemDetails($config, $nomor, $jenis_gudang)
		{
            // $this->gudangruko->trans_start();
			$db = $this->load->database($config,TRUE);
			if($jenis_gudang=='SPAREPART-RUKO'){	
				$str = "select * from T_ListingSP where No_Bukti='".$nomor."'";
			} else {
				$str = "select * from T_Listing where No_Bukti='".$nomor."'";
			}	

			$res = $db->query($str);
			return $res->result();
		}

		function UpdateCollectedItems($config, $nomor, $jenis_gudang)
		{
			$this->db = $this->load->database($config,TRUE);
	
			$this->db->trans_start();
	
				// for ($i = 0; $i < count($nomors); $i++) {
					// echo $nomors[$i];die;
					if($jenis_gudang=='SPAREPART-RUKO'){	
						$this->db->where("No_Bukti", $nomor);
						$this->db->set("Collected", 'Y');
						$this->db->update("T_ListingSP");
					} else {
						$this->db->where("No_Bukti", $nomor);
						$this->db->set("Collected", 'Y');
						$this->db->update("T_Listing");
					}
					
					// return true;
				
				// }
	
			$this->db->trans_complete();
			return true;
		}

		function GetReturnItems($config, $type_trans, $collected, $jenis_gudang)
		{
            // $this->gudangruko->trans_start();
			$this->db = $this->load->database($config,TRUE);

			if($jenis_gudang=='SPAREPART-RUKO'){		
				$str = "select DISTINCT  a.No_Bukti, ISNULL(b.Nm_Plg,c.Nm_Gudang)  as Nm_Plg from T_ListingSP a 
						left join TblMsDealerSP b on a.Kd_Plg = b.Kd_Plg
						left join TblMsGudangSP c on a.Kd_Plg = c.Kd_Gudang 
						where collected = '".$collected."'
						and type_trans in (".$type_trans.") 
						order by No_Bukti Asc";
			} else {
				$str = "select DISTINCT  a.No_Bukti, ISNULL(b.Nm_Plg,c.Nm_Gudang)  as Nm_Plg from T_Listing a 
						left join TblMsDealer b on a.Kd_Plg = b.Kd_Plg
						left join TblMsGudang c on a.Kd_Plg = c.Kd_Gudang 
						where collected = '".$collected."'
						and type_trans in (".$type_trans.") 
						order by No_Bukti Asc";
			}
				

				$res = $this->db->query($str);
				return $res->result();
		}

		function GetReturnItemDetails($config, $nomor, $jenis_gudang)
		{
            // $this->gudangruko->trans_start();
			$db = $this->load->database($config,TRUE);
			if($jenis_gudang=='SPAREPART-RUKO'){	
				$str = "select * from T_ListingSP where No_Bukti='".$nomor."'";
			} else {
				$str = "select * from T_Listing where No_Bukti='".$nomor."'";
			}	

			$res = $db->query($str);
			return $res->result();
		}

		function UpdateReturnItems($config, $nomor, $jenis_gudang)
		{
			$this->db = $this->load->database($config,TRUE);
	
			$this->db->trans_start();
	
				// for ($i = 0; $i < count($nomors); $i++) {
					if($jenis_gudang=='SPAREPART-RUKO'){	
						$this->db->where("No_Bukti", $nomor);
						$this->db->set("Collected", 'N');
						$this->db->update("T_ListingSP");
					} else {
						$this->db->where("No_Bukti", $nomor);
						$this->db->set("Collected", 'N');
						$this->db->update("T_Listing");
					}

					
					
				
				// }
	
			$this->db->trans_complete();
			return true;
		}

		function GetListPotongStock($config, $jenis_gudang)
		{
            // $this->gudangruko->trans_start();
			$db = $this->load->database($config,TRUE);

			if($jenis_gudang=='SPAREPART-RUKO'){	
				$str = "
				select distinct a.No_Bukti, ISNULL(b.Nm_Plg,c.Nm_Gudang) as Nm_Plg from T_ListingSP a 
				left join TblMsDealerSP b on a.Kd_Plg = b.Kd_Plg
				left join TblMsGudangSP c on a.Kd_Plg = c.Kd_Gudang 
				where collected = 'Y'
						order by No_Bukti Asc";
			} else {
				$str = "
				select distinct a.No_Bukti, ISNULL(b.Nm_Plg,c.Nm_Gudang) as Nm_Plg from T_Listing a 
				left join TblMsDealer b on a.Kd_Plg = b.Kd_Plg
				left join TblMsGudang c on a.Kd_Plg = c.Kd_Gudang 
				where collected = 'Y'
						order by No_Bukti Asc";
			}
				

				$res = $db->query($str);
				return $res->result();
		}

		function GetPotongStockItemDetails($config, $nomor, $jenis_gudang)
		{
			
            // $this->gudangruko->trans_start();
			$db = $this->load->database($config,TRUE);
			if($jenis_gudang=='SPAREPART-RUKO'){	
				$str = "select * from T_ListingSP where No_Bukti='".$nomor."'";
			} else {
				$str = "select * from T_Listing where No_Bukti='".$nomor."'";
			}	

			$res = $db->query($str);
			return $res->result();
		}

		function PotongStock($config, $nomor, $jenis_gudang)
		{
            // $this->gudangruko->trans_start();
			$db = $this->load->database($config,TRUE);
			$db->trans_start();
				
			if($jenis_gudang=='SPAREPART-RUKO'){	
				$str = "insert into T_StockGudangSP select no_bukti, Tgl_Trans, Kd_Plg, Divisi, Type_Trans, Kd_SPAREPART-RUKO, Qty,
				Entry_Time, USER_NAME , Kd_Gudang , No_Ref  from T_ListingSP where No_Bukti='".$nomor."'";
			} else {
				$str = "insert into T_StockGudang select no_bukti, Tgl_Trans, Kd_Plg, Divisi, Type_Trans, Kd_SPAREPART-RUKO, Qty,
				Entry_Time, USER_NAME , Kd_Gudang , No_Ref  from T_Listing where No_Bukti='".$nomor."'";
			}

			$res = $db->query($str);

			$db->where('No_Bukti', $nomor);
			$db->delete('T_ListingSP');

			$db->trans_complete();
			return true;
		}

	}
