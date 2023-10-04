<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/slide/add" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-plus"></i> เพิ่มสไลด์
            </a>
        </div>
    </div>
</div>
<div class="main-body">
    <div class="table-responsive mb-5">
        <table id="table-test" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header">#</td>
                    <td class="table-header">รูปตัวอย่าง</td>
                    <td class="table-header">ชื่อสไลด์</td>
                    <td class="table-header">สถานะการแสดง</td>
                    <td class="table-header">วันที่สร้าง</td>
                    <td class="table-header">ตั้งค่า</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
                    <tr class="table-row-detail">
                        <td class="table-detail text-center"><?=$i?></td>
                        <td class="table-detail"><img src="<?=base_url().'uploads/images/'.$value->slide_path?>" width="300"></td>
                        <td class="table-detail"><?=$value->slide_name?></td>
                        <td class="table-detail text-center"><?=$value->slide_status==1?'<span class="btn btn-base-color btn-custom-sm">แสดง</span>':'<span class="btn btn-default btn-custom-sm">ซ่อน</span>'?></td>
                        <td class="table-detail"><?=$value->slide_create?></td>
                        <td class="table-detail text-center">
                            <a href="<?=base_url()?>admin2/slide/edit/<?=$value->slide_id?>" class="btn btn-bg-color btn-custom-sm">
                                <i class="fas fa-edit"></i>	
                                แก้ไข
                            </a>
                            <a href="<?=base_url()?>admin2/slide/del/<?=$value->slide_id?>" class="btn btn-base-color btn-custom-sm" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
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