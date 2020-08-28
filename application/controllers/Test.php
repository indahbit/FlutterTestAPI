<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller 
{
	public $pdf_dir = "C:/PDF TEST/";
	public $nm_file = "pdf_test";

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('FormLibrary');
		$this->load->helper('directory');
		$this->load->helper('file');
		$this->load->library('email');
		$this->load->library('zip');
	}

	public function GetHeader()
	{
        $hdr = "<h2>List Dealer PT. BHAKTI IDOLA TAMA</h2>";
        $hdr.= "<h4>tes header baris ke-2</h4>";
        $hdr.= "<h4>tes header baris ke-3</h4>";
        return($hdr);
	}

	public function GetContent()
	{
		$style="border:1px solid #ccc;float:left;";
		//height:30px;line-height:15px;vertical-align:top;font-size:12px;

		$html = "<style>";
		$html.= "	.col { ".$style." }";
		$html.= "</style>";

		$html.= "<div>";
		$html.= "	<div class='col' style='width:7%;'>Kode</div>";
		$html.= "	<div class='col' style='width:15%;'>Nama</div>";
		$html.= "	<div class='col' style='width:35%;'>Alamat</div>";
		$html.= "	<div class='col' style='width:13%;'>Wilayah</div>";
		$html.= "	<div class='col' style='width:10%;'>No HP</div>";
		$html.= "	<div class='col' style='width:15%;'>Email</div>";
		$html.= "	<div style='clear:both;'></div>";
		$html.= "</div>";

		$html.= "<div>";
		$html.= "	<div class='col' style='width:7%;'>JKTA123</div>";
		$html.= "	<div class='col' style='width:15%;'>ABCDEF GHIJKL</div>";
		$html.= "	<div class='col' style='width:35%;'>JAKARTA BARAT</div>";
		$html.= "	<div class='col' style='width:13%;'>JAKARTA</div>";
		$html.= "	<div class='col' style='width:10%;'>0812-0813-0814</div>";
		$html.= "	<div class='col' style='width:15%;'>ABCDEF@BHAKTI.CO.ID</div>";
		$html.= "	<div style='clear:both;'></div>";
		$html.= "</div>";

		return($html);
	}

	public function Pdf($preview=0)
	{
    	require_once __DIR__ . '\vendor\autoload.php';
        $mpdf = new \Mpdf\Mpdf(array(
					'mode' => '',
					'format' => 'A4',
					'default_font_size' => 8,
					'default_font' => 'tahoma',
					'margin_left' => 10,
					'margin_right' => 10,
					'margin_top' => 20,
					'margin_bottom' => 10,
					'margin_header' => 0,
					'margin_footer' => 0,
					'orientation' => 'P'
				));

        $hdr = $this->GetHeader();
        $html= $this->GetContent();

		$mpdf->SetHTMLHeader($hdr);				//Yang diulang di setiap awal halaman  (Header)
        $mpdf->WriteHTML(utf8_encode($html));
        if ($preview==1) {
	        $mpdf->Output();
	    } else {
	        if (!is_dir($this->pdf_dir)) {
				mkdir($this->pdf_dir, 0777, TRUE);	
			}
			$mpdf->SetProtection(array(), 'AbcXyz123');
	        $mpdf->Output($this->pdf_dir."/".$this->nm_file.".pdf", \Mpdf\Output\Destination::FILE);
	    }
	}


	public function Email()
	{
		$data = array();
		$this->RenderView('TestEmail',$data);
	}

	public function TestEmail()
	{
		$post = $this->PopulatePost();
		$recipients = $post["EmailAddress"];

		$this->Pdf();

		$this->email->clear(true);
		$this->email->from("bitautoemail.noreply@gmail.com", "BitAutoEmail TEST");
		$this->email->to($recipients);
		$this->email->cc("itdev.dist@bhakti.co.id");
		$this->email->attach($this->pdf_dir."/".$this->nm_file.".pdf");

		$email_content = "Ini adalah email test Create dan Kirim Pdf";
		$this->email->subject("TEST EMAIL ".date("d-m-Y"));
		$this->email->message($email_content);
		if ($this->email->send()) {
			echo(json_encode("Email Sent"));
		} else {
			echo(json_encode("Email Not Sent"));
		}
	}

	public function Directory()
	{
		$dirpath = "";
		$dir = directory_map($dirpath);
		
		while (($subdir_name = current($dir)) !== FALSE) {
			$content_key = key($dir);
			if (is_array($dir[$content_key])) {
				echo $content_key." : folder<br />";
			} else {
				echo $dir[$content_key]." : file<br />";
			}
			next($dir);
		}
	}

	public function Zip()
	{
		$this->load->library('zip');
		//die(DIRPATH);

		$dirpath = "C:/ebilling/pdf_billing/";
		$dir = directory_map($dirpath);
		
		while (($subdir_name = current($dir)) !== FALSE) {
			$content_key = key($dir);
			if (is_array($dir[$content_key])) {
				echo $content_key." : folder<br />";
			} else {
				echo $dir[$content_key]." : file<br />";
				$this->zip->read_file($dirpath."/".$dir[$content_key],false);
				//echo substr($dir[$content_key],1,2)."<br />"; 
				//start : 0
			}
			next($dir);
		}

		// Write the zip file to a folder on your server. Name it "my_backup.zip"
		$this->zip->archive('C:/ebilling/tes.zip');

		// Download the file to your desktop. Name it "my_backup.zip"
		//$this->zip->download('D:/tes.zip');		
		exit ("Tes ZIP Selesai");	
	}


}