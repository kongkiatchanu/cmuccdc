<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/section/1/add" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-plus"></i> เพิ่มข่าวสาร
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
                    <td class="table-header">หมวดหมู่</td>
                    <td class="table-header">วันที่</td>
                    <td class="table-header">สร้างโดย</td>
                    <td class="table-header">สถานะแสดง</td>
                    <td class="table-header text-center">ตั้งค่า</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($clist as $key=>$value) {$i++;?>  
                    <tr class="table-row-detail">
                        <td class="table-detail text-center"><?=number_format($i)?></td>
                        <td class="table-detail"><?=$value->content_title?></td>
                        <td class="table-detail"><?=$value->category_name?></td>
                        <td class="table-detail"><?=$value->content_created?></td>
                        <td class="table-detail"><?=$value->content_author?></td>
                        <td class="table-detail text-center"><?=$value->content_status==1?'<span class="btn btn-base-color btn-custom-sm">แสดง</span>':'<span class="btn btn-default btn-custom-sm">ซ่อน</span>'?></td>
                        <td class="table-detail text-center" style="width:10%">
                            <a href="<?=base_url()?>admin2/section/<?=$idsection?>/edit/<?=$value->idcontent?>" class="btn btn-bg-color btn-custom-sm my-1">
                                <i class="fas fa-edit"></i>	
                                แก้ไข
                            </a>
                            <a href="<?=base_url()?>admin2/section/<?=$idsection?>/del/<?=$value->idcontent?>" class="btn btn-base-color btn-custom-sm my-1" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
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