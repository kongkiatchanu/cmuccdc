<?php 
 $ar_index = array(
	'fixed'	=> 'แจ้งเครื่องเสีย',
	'location'	=> 'แจ้งย้ายจุดติดตั้ง',
	'coordinator'	=> 'แจ้งเปลี่ยนชื่อผู้ประสานงาน'
 )

?>
<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/maintain_noti/" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-12">
		<?php 
			$data = json_decode($rs[0]->loc_obj);
		
		?>
		<h5><?=$ar_index[$rs[0]->loc_type]?></h5>
		
		<?php if($rs[0]->loc_type=="fixed"){?>
			<p>รายละเอียด :<br/><?=$data->fixed_posture?></p>
			<p>ภาพประกอบ : <br/>
			<?=$data->fixed_img!=""?'<img src="/uploads/requests/'.$data->fixed_img.'" class="img-fluid">':'ไม่มี'?>
			</p>
		<?php }?>
		
		<?php if($rs[0]->loc_type=="location"){?>
			<p>ชื่อจุดติดตั้ง :<br/>
				TH: <?=$data->dustboy_name?><br/>
				EN: <?=$data->dustboy_name_en?><br/>
			</p>
			<p>พิกัด :<br/><?=$data->dustboy_lat?>, <?=$data->dustboy_lon?></p>

		<?php }?>
		
		<?php if($rs[0]->loc_type=="coordinator"){?>
			<p>ชื่อผู้ประสานงาน :<br/><?=$data->db_name?></p>
			<p>โทรศัพท์ :<br/><?=$data->db_mobile?></p>
			<p>อีเมล์ :<br/><?=$data->db_email?></p>
		<?php }?>
		
		
		<p>แจ้งเมื่อเวลา <?=$rs[0]->createdate?></p>
		<p><a class="btn btn-sm btn-info" href="<?=base_url('admin2/source/all/edit/'.$rs[0]->loc_db_id)?>" target="_blank">อัพเดทข้อมูลเครื่อง ไอดี <?=$rs[0]->loc_db_id?></a></p>
	</div>
</div>