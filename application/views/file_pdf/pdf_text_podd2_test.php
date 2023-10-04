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
		width: 4.545%;
		border: 1px solid #000000;
		font-size: 12px;
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
	<?php if($chk==0){?>
		เขตสุขภาพที่ <b style="color:red;"><?=$area?></b> วันที่รายงาน <b style="color:red;"><?php echo thaidate('j F Y'); ?></b>
	<?php }else{?>
		จังหวัด <b style="color:red;"><?=$chk[0]->province_name?></b> วันที่รายงาน <b style="color:red;"><?php echo thaidate('j F Y'); ?></b>
	<?php }?>
</p>
<p></p>
<p> </p>
<p> </p>
<p> </p>
<br>
<p style="width: 100%;font-size: 12px;text-align: right;"><span style="color:red;">หมายเหตุ PM2.5 = 51 ขึ้นไป (วัน) คือ จำนวนวันที่ค่า PM<sub>2.5</sub> เกิน 51 ขึ้นไปตั้งแต่ 2021-01-01 เป็นต้น. </span> ที่มา: https://www.cmuccdc.org/</p>

<table cellpadding="5">
	<thead>
		<tr>
			<th class="color-black text-center" rowspan="2" style="width: 43%"> จุดตรวจวัด </th>
			<th class="color-black text-center" rowspan="2" style="width: 7%"> PM2.5 = 51 ขึ้นไป (วัน) </th>
			<th class="color-black text-center" colspan="8" style="width: 36.36%"> <b>สถานการณ์ย้อนหลัง</b> </th> 
			<th class="color-white text-center" colspan="3" style="width: 13.635%"> <b>คาดการณ์</b> </th>
		</tr>
		<tr>
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
		<?php if(!empty($data)){ ?>
			<?php foreach ($data as $key => $value) {?>
				<?php if(!empty($value->stations)){ ?>
					<?php foreach ($value->stations as $k => $v) { $index++;?>
						<?php //if($index>=14){?>
							<tr>
								<td class="color" style="width: 43%">	
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
									<?php for($i=1;$i<=(8-count($v->pm25));$i++){?>
										<th class="text-center color"> <b>N/A</b> </th>
									<?php }?>
									<?php foreach($v->pm25 as $kk => $vv){?>
										<td class="text-center color" style="background-color:rgb(<?=color($vv->PM25);?>);"> <b><?= ceil($vv->PM25);?></b> </td>
									<?php }?>
								<?php }else{ ?>
									<?php for($i=1;$i<=8;$i++){?>
										<th class="text-center color"> <b>N/A</b> </th>
									<?php }?>
								<?php } ?>
								<?php if(!empty($v->weather)){ ?>
									<?php $i=0;foreach($v->weather as $kk=>$vv){ ?>
										<?php if($vv->ForecastDate>=date('Y-m-d h:i:s', strtotime(' + 1 days'))){ ?>
											<?php if(!empty($vv)){ ?>
												<th class="text-center" style="background-color:rgb(<?=color($vv->PM25);?>);"> 
													<b><?=floor($vv->PM25);?></b> 
												</th>
											<?php }else{ ?>
												<th class="text-center color"> 
													<b>N/A</b> 
												</th>
											<?php } ?>
										<?php $i++;} ?>
									<?php } ?>
									<?php if($i<3){ ?>
										<?php for($j=1;$j<=(3-$i);$j++){?>
											<th class="text-center color"> 
												<b>N/A</b> 
											</th>
										<?php } ?>
									<?php } ?>
								<?php }else{ ?>
									<th colspan="3" class="text-center color" style="width: 13.635%"> 
										<b>ไม่มีการพยากรณ์</b> 
									</th>
								<?php } ?>
							</tr>
						<?php //} ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		<?php }else{ ?>
			<tr>
				<td class="color text-center" colspan="13" style="width: 99.725%"> ไม่พบข้อมูลกรุณาลองใหม่ภายหลัง </td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<p style="width: 100%;font-size: 12px;text-align: right;">ที่มา: https://www.cmuccdc.org</p>
