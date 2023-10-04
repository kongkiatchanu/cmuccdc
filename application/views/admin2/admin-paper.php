<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/paper/add" class="btn btn-custom-sm btn-bg-color">
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
                    <td class="table-header" width="100">เลขที่หนังสือ</td>
                    <td class="table-header">หัวข้อ</td>
                    <td class="table-header" width="100">วันที่</td>
                    <td class="table-header" width="50"></td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
				
					<tr class="table-row-detail">
						<td class="table-detail text-center"><?=$value->paper_no?></td>
						<td class="table-detail"><?=$value->paper_topic?></td>
						<td class="table-detail"><?=$value->paper_date?></td>
						
						<td class="table-detail text-center">
							<a href="<?=base_url()?>admin2/paper/edit/<?=$value->paper_id?>" class="btn btn-bg-color btn-custom-sm">
                                <i class="fas fa-edit"></i>	
                            </a>
						</td>
					</tr>
                <?php }?>

            </tbody>
        </table>
    </div>

</div>