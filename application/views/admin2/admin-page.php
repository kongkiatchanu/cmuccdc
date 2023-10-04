<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/page/add" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-plus"></i> เพิ่มหน้า
            </a>
        </div>
    </div>
</div>
<div class="main-body">
    <div class="table-responsive mb-5">
        <table id="table-test" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header text-center">#</td>
                    <td class="table-header">ชื่อเรื่อง</td>
                    <td class="table-header">วันที่</td>
                    <td class="table-header text-center">ตั้งค่า</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
                    <tr class="table-row-detail">
                        <td class="table-detail text-center"><?=number_format($i)?></td>
                        <td class="table-detail"><?=$value->page_title?></td>
                        <td class="table-detail"><?=$value->page_create?></td>
                        <td class="table-detail text-center">
                            <a href="<?=base_url()?>admin2/page/edit/<?=$value->idpage?>" class="btn btn-bg-color btn-custom-sm">
                                <i class="fas fa-edit"></i>	
                                แก้ไข
                            </a>
                            <a href="<?=base_url()?>admin2/page/del/<?=$value->idpage?>" class="btn btn-base-color btn-custom-sm" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
                                <i class="fas fa-trash-alt"></i>	
                                ลบ
                            </a>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>