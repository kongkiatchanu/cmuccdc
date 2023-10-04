<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
    include_once('assets/prophecy/pdf/Thaidate/Thaidate.php');
	include_once('assets/prophecy/pdf/Thaidate/thaidate-functions.php');
?>
<style>
	p.text_header{
		color:#000000;
		font-size: 14px;
		text-align: center;
		/* font-weight: bold; */
	}
	table{
		border-collapse: collapse;
		width: 100%;
		color: #000000;
	}
	table .subject{
		width: 25%;
	}
	table .content{
		width: 75%;
	}
	th,td{
		/* vertical-align: top; */
		/* text-align:left; */
		border: 2px solid #ffffff;
		font-size: 14px;
		/* border: none; */
	}
	table.in_table th,table.in_table td{
		border: none;
	}
	table thead th {
		text-align:left;
	}
	table th.title{
		/* background-color: #cdcdcd; */
		font-size: 14px;
		color: #000000;
	}
	.font12{
		font-size: 12px;
	}
	.color-title{
		background-color: #99bf3d;
	}
	.color{
		background-color: #dedede;
	}
	.text-center{
		text-align:center;
	}
	.align-mid{
		vertical-align:middle;
	}
	.w-100{
		width:100%;
	}
	.w-70{
		width:70%;
	}
	.w-60{
		width:60%;
	}
	.w-30{
		width:30%;
	}
	.w-20{
		width:20%;
	}
	.w-18{
		width:18%;
	}
	.w-10{
		width:10%;
	}
	.h-35{
		/* height: 3px; */
	}
	.text-underline{
		text-decoration: underline;
	}
</style>
<!-- <img style="width:950px;" src="https://www.cmuccdc.org/assets/image_pdf/bg-nrct.jpg" alt=""> -->
<p style="font-size:30pt;"> <?=$data[0][0]->temp?> </p>