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

<p class="w-100 text-center">
	รายงานค่าฝุ่นละอองขนาดเล็ก (PM2.5) ไมโครกรัมต่อลูกบาศก์เมตรจากเครื่องวัดฝุ่นละออง DustBoy
	<br>
	<span>
		ประจำวันที่ <span style="color:red;"><?php echo thaidate('j F Y'); ?></span> 
		<!-- <b class="text-underline">ข้อมูลรายชั่วโมง ณ เวลา <span style="color:red;">00:00</span> น.</b> -->
	</span>
</p>
<p></p>
	<p> </p>
	<p> </p>
	<p> </p>
	<p> </p>
	<br>
<p style="width: 100%;font-size: 12px;text-align: right;">ที่มา: https://pm2_5.nrct.go.th</p>
<table cellpadding="5">
	<tr>
		<th class="title color text-center w-10 h-35" rowspan="2" style="background-color:#dedede;"><br><br>PM 2.5</th>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(0);?>);"> 0-25 ug/m<sup>3</sup> </th>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(26);?>);"> 26-37 ug/m<sup>3</sup> </th>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(38);?>);"> 38-50 ug/m<sup>3</sup> </th>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(51);?>);"> 51-90 ug/m<sup>3</sup> </th>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(91);?>);"> > 90 ug/m<sup>3</sup> </th>
	</tr>
	<tr>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(0);?>);"> อากาศดีมาก </th>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(26);?>);"> อากาศดี </th>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(38);?>);"> อากาศปานกลาง </th>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(51);?>);"> เริ่มมีผลกระทบต่อสุขภาพ </th>
		<th class="title text-center w-18 h-35" style="background-color:rgb(<?=color(91);?>);"> มีผลกระทบต่อสุขภาพ </th>
	</tr>
</table>
<p></p>
<table cellpadding="5">
	<thead>
		<tr>
			<th class="title text-center w-60"> </th>
			<th class="title text-center w-10"> <b>วันนี้</b> </th>
			<th class="title text-center w-30" colspan="3"> <b>คาดการณ์</b> </th>
		</tr>
		<tr>
			<th class="title text-center w-60"> <b>สถานนี</b> </th>
			<th class="title text-center w-10"> <b><?php echo thaidate('j') .' '.thaidate('M'); ?></b> </th>
			<th class="title text-center w-10"> <b><?php echo thaidate('j')+1 .' '.thaidate('M'); ?></b> </th>
			<th class="title text-center w-10"> <b><?php echo thaidate('j')+2 .' '.thaidate('M'); ?></b> </th>
			<th class="title text-center w-10"> <b><?php echo thaidate('j')+3 .' '.thaidate('M'); ?></b> </th>
		</tr>
	</thead>
	<tbody>
		<?php $index=0; ?>
		<?php foreach ($data as $key => $value) {?>
			<?php if(!empty($value->stations)){ $index++;?>
				<?php if($index<12){?>
					<tr>
						<td class="title color-title" colspan="5"><?=$value->province_name_th;?></td>
					</tr>
				<?php } ?>
				<?php foreach ($value->stations as $k => $v) { ?>
					<?php if(!empty($v->weather)){ $index++;?>
						<?php if($index<12){?>
							<tr>
								<td class="title color w-60"> <b><?= $v->location_name; ?></b> </td>
								<?php if($v->pm25->PM25!=null){ ?>
									<td class="text-center color font12 w-10" style="background-color:rgb(<?=color($v->pm25->PM25);?>);"> <b><?=$v->pm25->PM25;?></b> </td>
								<?php }else{ ?>
									<th class="text-center color font12 w-10"> <b>N/A</b> </th>
								<?php } ?>
								<?php for($i=0;$i<=2;$i++){ ?>
									<?php if(!empty($v->weather[$i])){ ?>
										<th class="text-center w-10" style="background-color:rgb(<?=color($v->weather[$i]->PM25);?>);"> 
											<b><?=floor($v->weather[$i]->PM25);?></b> 
										</th>
									<?php }else{ ?>
										<th class="text-center color font12 w-10"> 
											<b>N/A</b> 
										</th>
									<?php } ?>
								<?php } ?>
							</tr>
						<?php } ?>
					<?php }else{ $index++;?>
						<?php if($index<12){?>
							<tr>
								<td class="title color w-60"> <b><?= $v->location_name; ?></b> </td>
								<?php if($v->pm25->PM25!=null){ ?>
										<td class="text-center color font12 w-10" style="background-color:rgb(<?=color($v->pm25->PM25);?>);"> <b><?=$v->pm25->PM25;?></b> </td>
									<?php }else{ ?>
										<th class="text-center color font12 w-10"> <b>N/A</b> </th>
									<?php } ?>
								<th class="text-center color font12 w-30" colspan="3"> 
									<b>ไม่มีข้อมูลพยากรณ์</b> 
								</th>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</tbody>
</table>