<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    include_once APPPATH.'/third_party/mpdf/mpdf.php';
 
    class m_pdf {
 
    public $param;
    public $pdf;
    public function __construct($param = "'th', 'A4-L', '0', 'THSaraban'")
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
    }
}