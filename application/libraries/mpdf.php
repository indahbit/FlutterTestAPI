<?php
  	if (!defined('BASEPATH')) exit('No direct script access allowed');  
   
  	require_once APPPATH."/third_party/mpdf/mpdf.php";
  
	class m_pdf extends mpdf {
	  	public function __construct() {
	          parent::__construct();
	  	}
		
		function load($param=NULL)
		{
		    include_once APPPATH.'/third_party/mpdf/mpdf.php';
		     
		    if ($params == NULL)
		    {
		        $param = '"en-GB-x","A4","","",10,10,10,10,6,3';           
		    }
		    return new mPDF();
		}
	}	