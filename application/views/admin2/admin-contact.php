<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
</div>
<div class="main-body">
    <div class="table-responsive mb-5">
        <table id="table-test" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header text-center">#</td>
                    <td class="table-header">หัวข้อ</td>
                    <td class="table-header">ผู้ติดต่อ</td>
                    <td class="table-header">วันที่ เวลา</td>
                    <td class="table-header text-center">ตั้งค่า</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $key=>$value) {$i++;?>  
                    <tr class="table-row-detail">
                        <td class="table-detail text-center"><?=number_format($i)?></td>
                        <td class="table-detail"><?=$value->contact_subject?></td>
                        <td class="table-detail"><?=$value->contact_name?></td>
                        <td class="table-detail"><?=$value->contact_datetime?></td>
                        <td class="table-detail text-center">
                            <a href="<?=base_url()?>admin2/contact/view/<?=$value->idcontact?>" class="btn btn-bg-color btn-custom-sm">
                                <i class="far fa-eye"></i>
                                ดูรายละเอียด
                            </a>
                            <a href="<?=base_url()?>admin2/contact/del/<?=$value->idcontact?>" class="btn btn-base-color btn-custom-sm" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
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