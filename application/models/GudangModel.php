<?php
class GudangModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	function GetListGudang($aktif="", $config)
	{
		$bhakti = $this->load->database($config,TRUE);
		//$query = " EXEC Master_GetDealer_2 '".$plg."'";
		$query = "select RTRIM(Kd_Gudang) as KD_GUDANG, RTRIM(Nm_Gudang) as NM_GUDANG, RTRIM(Alm_Gudang) as ALM_GUDANG,
					RTRIM(Jenis) as JENIS, RTRIM(Non_Aktif) as NON_AKTIF, RTRIM(Non_Aktif_Out) as NON_AKTIF_OUT,
					RTRIM(location) as LOCATION, RTRIM(wilayah) as WILAYAH, RTRIM(ISNULL(Kategori,'P')) as KATEGORI,
					RTRIM(isnull(TipeGudang,'B')) as TIPEGUDANG, RTRIM(isnull(Kd_GudangCacat,'')) as KD_GUDANGCACAT 
				from TblMsGudang Where Non_Aktif_Out='".(($aktif=="Y")?"N":"Y")."'
				Order By Kd_Gudang ";
		$res = $bhakti->query($query);
		if ($res->num_rows() > 0)		
			return $res->result();
		else
			return array();
	}


}
?>
