
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
                    <td class="table-header">รหัสเครื่อง</td>
                    <td class="table-header">ชื่อจุดติดตั้ง</td>
                    <td class="table-header">รูปแบบการเชื่อมต่อ</td>
                    <td class="table-header">วันที่</td>
                    <td class="table-header"></td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
				
					<tr class="table-row-detail">
						<td class="table-detail"><?=$value->dustboy_code?></td>
						<td class="table-detail"><?=$value->dustboy_name?></td>
						<td class="table-detail"><?=$value->dustboy_type?></td>
						<td class="table-detail text-center"><?=$value->createdate?></td>
						<td class="table-detail">
							<a href="<?=base_url('admin2/maintain_setup/view/'.$value->setup_id)?>" class="label label-secondary"> ดูข้อมูล </a>
						</td>
							
					</tr>
               
                <?php }?>
            </tbody>
        </table>
    </div>
	
</div>