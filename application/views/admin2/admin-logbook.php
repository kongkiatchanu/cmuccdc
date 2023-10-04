<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/logbook/add" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-plus"></i> เพิ่ม<?=$pagename?>
            </a>
        </div>
    </div>
</div>
<div class="main-body">
    <div class="table-responsive mb-5">
        <table id="table-test" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header" width="100">หมายเลขเครื่อง</td>
                    <td class="table-header" width="70">โมเดล</td>
                    <td class="table-header">ข้อความ</td>
                    <td class="table-header" width="100">ดำเนินการแก้ไข</td>
                    <td class="table-header" width="150">หมายเหตุ</td>
                    <td class="table-header" width="100"></td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
				
					<tr class="table-row-detail">
						<td class="table-detail text-center"><?=$value->source_id?></td>
						<td class="table-detail"><?=$value->db_model?></td>
						<td class="table-detail"><?=$value->log_comment?></td>
						<td class="table-detail text-center"><?=$value->log_status==0?'':'<i class="fa fa-check"></i>'?></td>
						
						<td class="table-detail text-center"><?=$value->log_note?><br/><?=$value->log_date?></td>
						<td class="table-detail text-center">
							<a href="<?=base_url()?>admin2/logbook/edit/<?=$value->log_id?>" class="btn btn-bg-color btn-custom-sm">
                                <i class="fas fa-edit"></i>	
                            </a>
							 <a href="<?=base_url()?>admin2/logbook/del/<?=$value->log_id?>" class="btn btn-base-color btn-custom-sm" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
                                <i class="fas fa-trash-alt"></i>	
          
                            </a>
						</td>
					</tr>
                <?php }?>

            </tbody>
        </table>
    </div>

</div>