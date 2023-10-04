<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?> <?=$this->uri->segment(3)!=''?'['.$this->uri->segment(3).']':''?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/source/add" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-plus"></i> เพิ่มจุดตรวจวัดใหม่
            </a>
        </div>
    </div>
</div>
<div class="main-body">
    <div class="table-responsive mb-5">
        <table id="table-test" class="table table-custom" style="width:100%">
            <thead>
				<tr style="font-weight: 500;background-color: #333;color:#fff;">
					<th>WebID</th>
					<th>Name</th>
					<th>Url</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $i=0;foreach ($rsList as $value) {$i++;?>  
				<tr>
					<td><?=$value->source_id?></td>
					<td><?=$value->location_name?></td>
					<td><a href="<?=base_url($value->location_uri)?>" target="_blank"><?=$value->location_uri?></a></td>
					<td><?=$value->location_status==1?'<span class="btn btn-success btn-sm">Show</span>':'<span class="btn btn-default btn-sm">Hide</span>'?></td>	
					<td>
						<a href="<?=base_url()?>admin2/source/edit/<?=$value->source_id?>" class="btn btn-info btn-sm">
							<i class="fa fa-edit"></i>	แก้ไข
						</a>
					</td>
				</tr>
			<?php }?>
            </tbody>
        </table>
    </div>

	<div class="row">
		<div class="col-12">
			<p class="text-right">
				<span style="color:#7e7e7e"><i class="fas fa-circle" style="color:#7e7e7e"></i> รอติดตั้ง</span>
				<span style="color:#df6945"><i class="fas fa-circle" style="color:#df6945"></i> ส่งซ่อม/อัพเกรด</span>
				<span style="color:#15bf50"><i class="fas fa-circle" style="color:#15bf50"></i> ติดตั้งแล้ว</span>
			</p>
		</div>
	</div>
    <div class="alert alert-base-color">
        <p>หลังจากที่จัดการจุดติดตั้งทุกครั้งให้ สร้างข้อมูลโดยการคลิก url ด้านล่างนี่</p>
        <p><a class="url-revers-none" href="https://www-old.cmuccdc.org/assets/api/haze/pwa/genAllStation.php" target="_blank">https://www-old.cmuccdc.org/assets/api/haze/pwa/genAllStation.php</a></p>
        <p><a class="url-revers-none" href="https://www-old.cmuccdc.org/assets/api/haze/pwa/genAllStations.php" target="_blank">https://www-old.cmuccdc.org/assets/api/haze/pwa/genAllStations.php</a></p>
        <p><a class="url-revers-none" href="https://www-old.cmuccdc.org/assets/api/haze/pwa/genRegion.php" target="_blank">https://www-old.cmuccdc.org/assets/api/haze/pwa/genRegion.php</a></p>
        <p><a class="url-revers-none" href="https://www.cmuccdc.org/admin2/source/gen" target="_blank">https://www.cmuccdc.org/admin2/source/gen</a></p>
        <p>หลังจากนั้นสามารถตรวจสอบข้อมูลได้<a class="url-revers-none" href="https://www-old.cmuccdc.org//assets/api/haze/pwa/json/allstation.json" target="_blank"> ที่นี่</a></p>
        <p>ของแอดมิน<a class="url-revers-none" href="https://www.cmuccdc.org/uploads/json/station.json" target="_blank"> ที่นี่</a></p>
    </div>
</div>