<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('admin/template_header');?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<?php $this->load->view('admin/template_menu');?>
	<!-- BEGIN CONTENT -->
	 <?php $this->view("admin/".$pageview); ?>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('admin/template_footer');?>