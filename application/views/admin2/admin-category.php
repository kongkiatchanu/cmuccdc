<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/category/add" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-plus"></i> เพิ่มหมวดหมู่
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
                    <td class="table-header">หมวดหมู่</td>
                    <td class="table-header">หมวดย่อย</td>
                    <td class="table-header text-center">ตั้งค่า</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($category as $key=>$value) {$i++;?>  
                    <tr class="table-row-detail">
                        <td class="table-detail text-center"><?=number_format($i)?></td>
                        <?php if($value->parent!=null){?>
                            <td class="table-detail">-</td>
                            <td class="table-detail"><?=$value->category_name?></td>
                        <?php }else{?>
                            <td class="table-detail"><?=$value->category_name?></td>
                            <td class="table-detail"><?=$value->parent?></td>
                        <?php }?>
                        <td class="table-detail text-center">
                            <a href="<?=base_url()?>admin2/category/edit/<?=$value->id_category?>" class="btn btn-bg-color btn-custom-sm">
                                <i class="fas fa-edit"></i>	
                                แก้ไข
                            </a>
                            <a href="<?=base_url()?>admin2/category/del/<?=$value->id_category?>" class="btn btn-base-color btn-custom-sm" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
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