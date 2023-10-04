<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
require_once APPPATH."/third_party/tcpdf/tcpdf.php";
require_once APPPATH."/third_party/fpdi/fpdi.php";
class PDF extends FPDI 
{
	//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
    public function Header() {
		
		// Logo
		$image_file1 = base_url('assets/image_pdf/logo_3new.jpg');
		$this->Image($image_file1, 15, 5, 45, 0, 'JPG', '', 'T', false, 300,'', false, false, 0, false, false, false);
		// $image_file2 = base_url('assets/image_pdf/logo_nrct.jpg');
		// $this->Image($image_file2, 27, 5, 10, 0, 'JPG', '', 'T', false, 300,'', false, false, 0, false, false, false);
		// $image_file3 = base_url('assets/image_pdf/logo_nrct5G.jpg');
		// $this->Image($image_file3, 39, 5, 10, 0, 'JPG', '', 'T', false, 300,'', false, false, 0, false, false, false);
		// Set position
		$this->SetXY(65,6);
		// Set font
		$this->SetFont('thsarabunpsk', 'B', 18);
		// Title
		$this->SetTextColor(55, 104, 52);
		$this->Cell(0, 6, 'รายงานค่าฝุ่นละอองขนาดเล็ก (PM2.5) ไมโครกรัมต่อลูกบาศก์เมตร', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->SetXY(65,6);
		$this->SetFont('thsarabunpsk', 'B', 14);
		$this->SetTextColor(153, 191, 61);
		$this->Cell(0, 18, 'Air Quality Information Center', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->SetXY(15,12);
		$this->Cell(15, 18, '_________________________________________________________________________________________________', 0, false, 'L', 0, '', 0, false, 'T', 'M');

		// $this->writeHTMLCell('', 1, 15, 25, "<hr>", 0, 0, 0, true, '', true);
		// $this->Cell(23, 5, '       หน้า '.$this->getAliasNumPage(), 0, 0, '', 1, '', 0, false, 'T', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-20);
		// Set font
		$this->SetFont('thsarabunpskb', 'B', 12);
		// Page number
		$this->Cell(0, 10, 'ศูนย์เฝ้าระวังคุณภาพอากาศ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
		$this->Cell(0, 20, 'Air Quality Information Center: AQIC', 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
	var $files = array();
	public function setFiles($files) {
			$this->files = $files;
	}
	public function concat() {
			foreach($this->files AS $file) {
						$pagecount = $this->setSourceFile($file);
						for ($i=1;$i<=$pagecount;$i++) {
								$tplidx = $this->ImportPage($i);
								$s = $this->getTemplatesize($tplidx);
								$this->AddPage('P', array($s['w'], $s['h']));
								$this->useTemplate($tplidx);
						}
			}
	}
}