<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/fixed/add" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-plus"></i> เพิ่ม<?=$pagename?>
            </a>
        </div>
    </div>
</div>
<div class="main-body">
    <div class="table-responsive mb-5">
        <table id="table-test2" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header" width="80">webid</td>
                    <td class="table-header" width="80">หมายเลขเครื่อง</td>
                    <td class="table-header">จุดติดตั้ง</td>
                    <td class="table-header" width="70">ประเภท</td>
                    <td class="table-header" width="70">ส่งเครื่องมาซ่อม</td>
                    <td class="table-header" width="70">วันที่รับ</td>
                    <td class="table-header" width="70">วันที่ส่งซ่อม</td>
                    <td class="table-header" width="70">วันที่รับคืน</td>
                    <td class="table-header" width="70">วันที่ส่งคืน</td>
                    <td class="table-header" width="100">หมายเลขไปรษณีย์</td>
                    <td class="table-header" width="50"></td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
				
					<tr class="table-row-detail">
						<td class="table-detail text-center"><?=$value->fixed_source_id?></td>
						<td class="table-detail text-center"><?=$value->location_id?></td>
						<td class="table-detail"><?=$value->location_name?></td>
						<td class="table-detail text-center"><?=$value->fixed_type?></td>
						<td class="table-detail text-center"><?=$value->fixed_come_date=="0000-00-00"?'-':'<span title="'.$value->fixed_come_comment.'">'.$value->fixed_come_date.'<br/>'.$value->fixed_come_comment.'</span>'?></td>
						<td class="table-detail text-center"><?=$value->fixed_get_date=="0000-00-00"?'-':'<span title="'.$value->fixed_get_comment.'">'.$value->fixed_get_date.'<br/>'.$value->fixed_get_comment.'</span>'?></td>
						<td class="table-detail text-center"><?=$value->fixed_send_date=="0000-00-00"?'-':$value->fixed_send_date?></td>
						<td class="table-detail text-center"><?=$value->fixed_repair_date=="0000-00-00"?'-':$value->fixed_repair_date?></td>
						<td class="table-detail text-center"><?=$value->fixed_public_date=="0000-00-00"?'-':$value->fixed_public_date?></td>
						<td class="table-detail text-center"><?=$value->fixed_public_post?></td>
						<td class="table-detail text-center">
							<a href="<?=base_url()?>admin2/fixed/edit/<?=$value->fixed_id?>" class="btn btn-bg-color btn-custom-sm">
                                <i class="fas fa-edit"></i>	
                            </a>
						</td>
					</tr>
                <?php }?>

            </tbody>
        </table>
		<p class="text-center"><a class="btn btn-success" href="<?=base_url('admin2/fixed_export')?>" target="_blank">Export Excel</a></p>
    </div>

</div>