<div class="main-header row">
    <div class="col-12">
        <label class="title"><?=$pagename?></label>
    </div>
</div>
<div class="main-body">
    <div class="table-responsive mb-5">
        <table id="table-test" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header">ชื่อ</td>
                    <td class="table-header">หน่วยงาน</td>
                    <td class="table-header">โทรศัพท์</td>
                    <td class="table-header">อีเมล์</td>
					<td class="table-header">สถานะ</td>
                    <td class="table-header">วันที่</td>
                    <td class="table-header"></td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
				
					<tr class="table-row-detail">
						<td class="table-detail"><?=$value->request_name?></td>
						<td class="table-detail"><?=$value->request_agency?></td>
						<td class="table-detail"><?=$value->request_tel?></td>
						<td class="table-detail"><?=$value->request_email?></td>
						<td class="table-detail text-center">
							<?php if($value->request_active==0){?>
								<i class="fas fa-circle" style="color:#7e7e7e;"></i>
							<?php }else if($value->request_active==1){?>
								<i class="fas fa-circle" style="color:#15bf50;"></i>
							<?php }?>
						
						</td>
						
						
						<td class="table-detail text-center"><?=$value->request_time?></td>
						<td class="table-detail">
							<?php if($value->request_active==0){?>
								<a href="<?=base_url()?>admin2/maintain_member/add/<?=$value->request_key?>" class="btn btn-bg-color btn-custom-sm" title="เพิ่ม">
									<i class="fas fa-plus"></i>	
								</a>
							<?php }else if($value->request_active==1){?>
								<a href="<?=base_url()?>admin2/maintain_member/editt/<?=$value->request_key?>" class="btn btn-bg-color btn-custom-sm" title="แก้ไข">
									<i class="fas fa-edit"></i>	
								</a>
							<?php }?>
							
							<a href="<?=base_url()?>admin2/maintain_request/del/<?=$value->request_id?>" class="btn btn-base-color btn-custom-sm my-1" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
                                <i class="fas fa-trash-alt"></i>	
                            </a>
						</td>
					</tr>
               
                <?php }?>
            </tbody>
        </table>
    </div>
	
</div>