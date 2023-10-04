<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
require_once APPPATH."/third_party/tcpdf/tcpdf.php";
require_once APPPATH."/third_party/fpdi/fpdi.php";
class PDF2 extends FPDI 
{
	//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
    public function Header() {
		$this->SetFont('thsarabunb', 'B', 22,'',false);
		// Title
		// $this->SetTextColor(4, 102, 55);
		// $this->writeHTMLCell(150, 0, 30, 5,'โครงการห้องปลอดฝุ่นอุ่นใจ<br><span style="font-size:14pt">กรมอนามัย ศูนย์อนามัยที่ 1 เชียงใหม่</span>', 0, 0, 0, true, 'C', false);
		// $this->SetFont('sarabun', '', 14,'',false);

		// Logo
		$image_file1 = base_url('assets/image_pdf/podd/logo_public_health1.jpg');
		$this->Image($image_file1, 15, 5, 15, 0, 'JPG', '', 'T', false, 300,'', false, false, 0, false, false, false);
		// $image_file2 = base_url('assets/image_pdf/logo_nrct.jpg');
		// $this->Image($image_file2, 27, 5, 10, 0, 'JPG', '', 'T', false, 300,'', false, false, 0, false, false, false);
		// $image_file3 = base_url('assets/image_pdf/logo_nrct5G.jpg');
		// $this->Image($image_file3, 39, 5, 10, 0, 'JPG', '', 'T', false, 300,'', false, false, 0, false, false, false);
		// Set position
		$this->SetXY(15,6);
		// Set font
		$this->SetFont('thsarabunpsk', 'B', 18);
		// Title
		$this->SetTextColor(4, 102, 55);
		$this->Cell(0, 6, 'สถานการณ์ฝุ่นละอองขนาดเล็ก PM2.5 และการคาดการณ์ล่วงหน้า', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->SetXY(15,6);
		$this->SetFont('thsarabunpsk', 'B', 14);
		$this->SetTextColor(4, 102, 55);
		$this->Cell(0, 18, 'By Regional Health Promotion Center 1 Chiangmai', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$image_file2 = base_url('assets/image_pdf/podd/logo_public_health2.jpg');
		$this->Image($image_file2, 180, 5, 15, 0, 'JPG', '', 'T', false, 300,'', false, false, 0, false, false, false);
		$this->SetXY(15,12);
		$this->Cell(15, 20, '_________________________________________________________________________________________________', 0, false, 'L', 0, '', 0, false, 'T', 'M');

		// $this->writeHTMLCell('', 1, 15, 25, "<hr>", 0, 0, 0, true, '', true);
		// $this->Cell(23, 5, '       หน้า '.$this->getAliasNumPage(), 0, 0, '', 1, '', 0, false, 'T', 'M');
	}

	// Page footer
	public function Footer() {
		$this->SetY(-58);
		$image_file3 = base_url('assets/image_pdf/podd/bg-aqi6.jpg');
		$this->Image($image_file3, 0, '', 210, '', 'JPG', '', 'T', false, 300,'', false, false, 0, false, false, false);
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