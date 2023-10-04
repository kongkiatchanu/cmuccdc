<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
    include_once('assets/prophecy/pdf/Thaidate/Thaidate.php');
	include_once('assets/prophecy/pdf/Thaidate/thaidate-functions.php');
?>
<style>
	/* @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap');
	.sarabun{
		font-family: 'Sarabun', sans-serif;
	} */
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
		width: 4.05%;
		border: 1px solid #000000;
		font-size: 10px;
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
	.color-forcast{
		background-color: #7030a0;
		color: #ffffff;
	}
	.color-black{
		background-color: #333333;
		color: #ffffff;
	}
	.color-white{
		background-color: #ffffff;
		color: #000000;
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
	.w-80{
		width:80%;
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
	.w-5{
		width:5%;
	}
	.h-35{
		/* height: 3px; */
	}
	.text-underline{
		text-decoration: underline;
	}
</style>

<p class="w-100 text-center" style="font-size: 16pt">
	เขตสุขภาพที่ <b style="color:red;"><?=$area?></b> วันที่รายงาน <b style="color:red;"><?php echo thaidate('j F Y'); ?> เวลา 06:00 น.</b>
</p>
<p></p>
	<p> </p>
	<p> </p>
	<p> </p>
	<br>
<p style="width: 100%;font-size: 12px;text-align: right;">ที่มา: https://pm2_5.nrct.go.th</p>

<table cellpadding="5">
	<thead>
		<!-- <tr>
			<th class="title text-center w-60"> </th>
			<th class="title text-center w-10"> <b>วันนี้</b> </th>
			<th class="title text-center w-30" colspan="3"> <b>คาดการณ์</b> </th>
		</tr>
		<tr>
			<th class="title text-center w-60"> <b>สถานนี</b> </th>
			<th class="title text-center w-10"> <b><?php //echo thaidate('j') ; ?></b> </th>
			<th class="title text-center w-10"> <b><?php //echo thaidate('j')+1 ; ?></b> </th>
			<th class="title text-center w-10"> <b><?php //echo thaidate('j')+2 ; ?></b> </th>
			<th class="title text-center w-10"> <b><?php //echo thaidate('j')+3; ?></b> </th>
		</tr> -->
		<tr>
			<th class="color-black text-center w-20" rowspan="2"> จุดตรวจวัด </th>
			<th class="color-black text-center" rowspan="2" style="width: 7%"> PM2.5 = 51 ขึ้นไป (วัน) </th>
			<th class="color-black text-center" colspan="15" style="width: 60.75%"> <b>สถานการณ์ย้อนหลัง</b> </th>
			<th class="color-white text-center" colspan="3" style="width: 12.15%"> <b>คาดการณ์</b> </th>
		</tr>
		<tr>
			<!-- <th class="color-black text-center"> จุดตรวจวัด</th> -->
			<!-- <th class="color-black text-center"> PM2.5 = 51 ขึ้นไป(วัน) </th> -->
			<th class="color-black text-center"> <b><?php echo	date('d', strtotime(' - 14 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 13 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 12 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 11 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 10 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 9 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 8 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 7 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 6 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 5 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 4 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 3 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 2 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d', strtotime(' - 1 days')); ?></b> </th>
			<th class="color-black text-center"> <b><?php echo  date('d'); ?></b> </th>
			<th class="color-forcast text-center"> <b><?php echo  date('d', strtotime(' + 1 days')); ?></b> </th>
			<th class="color-forcast text-center"> <b><?php echo  date('d', strtotime(' + 2 days')); ?></b> </th>
			<th class="color-forcast text-center"> <b><?php echo  date('d', strtotime(' + 3 days')); ?></b> </th>
		</tr>
	</thead>
	<tbody>
		<?php $index=0; ?>
		<?php foreach ($data as $key => $value) {?>
			<?php if(!empty($value->stations)){ ?>
				<?php foreach ($value->stations as $k => $v) { ?>
					<?php if(!empty($v->weather)){ $index++;?>
						<?php if($index<14){?>
							<tr>
								<td class="color w-20">	
									<b>
										<?php
											$p_text=null;$p_sub_text=null;
											$p_text = strrpos($v->location_name, "โรงพยาบาลส่งเสริมสุขภาพตำบล");
											echo str_replace(array('โรงพยาบาลส่งเสริมสุขภาพตำบล','โรงพยาบาล'),array('รพ.สต.','รพ.'),$v->location_name);
										?>
									</b> 
								</td>
								<td class="text-center" style="width: 7%"> <b><?=$v->pm25_51?></b> </td>
								<?php if($v->pm25!=null){ ?>
									<?php for($i=1;$i<=(7-count($v->pm25));$i++){?>
										<th class="text-center color"> <b>N/A</b> </th>
									<?php }?>
									<!-- <th class="text-center color"> <b><?=count($v->pm25)?></b> </th> -->
									<!-- <th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th>
									<th class="text-center color"> <b>N/A</b> </th> -->
									<?php 
										// echo '<pre>';
										// print_r($v->pm25->PM25);
										// echo '</pre>';									
									?>
									<?php foreach($v->pm25 as $kk => $vv){?>
										<td class="text-center color" style="background-color:rgb(<?=color($vv->PM25);?>);"> <b><?= ceil($vv->PM25);?></b> </td>
									<?php }?>
								<?php }else{ ?>
									<?php for($i=1;$i<=15;$i++){?>
										<th class="text-center color"> <b>N/A</b> </th>
									<?php }?>
								<?php } ?>
								<?php for($i=1;$i<=3;$i++){ ?>
									<?php if(!empty($v->weather[$i])){ ?>
										<th class="text-center" style="background-color:rgb(<?=color($v->weather[$i]->PM25);?>);"> 
											<b><?=floor($v->weather[$i]->PM25);?></b> 
										</th>
									<?php }else{ ?>
										<th class="text-center color"> 
											<b>N/A</b> 
										</th>
									<?php } ?>
								<?php } ?>
							</tr>
						<?php } ?>
					<?php }else{ $index++;?>
						<?php if($index<14){?>
							<tr>
								<td class="color w-20"> <b><?= $v->location_name; ?></b> </td>
								<td class="text-center" style="width: 7%"> <b>N/A</b> </td>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<th class="text-center color"> <b>N/A</b> </th>
								<?php if($v->pm25->PM25!=null){ ?>
										<td class="text-center color" style="background-color:rgb(<?=color($v->pm25->PM25);?>);"> <b><?=$v->pm25->PM25;?></b> </td>
									<?php }else{ ?>
										<th class="text-center color"> <b>N/A</b> </th>
									<?php } ?>
								<th class="text-center color" colspan="3"> 
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
<?php if($index_all<14){ ?>
	<p style="width: 100%;font-size: 12px;text-align: right;">ที่มา: https://www.cmuccdc.org</p>
<?php } ?>
