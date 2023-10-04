<?php 
	$id_section=1;
    $category_name="";
    $category_parent="";
    $id_category="";
    if($rs!=null){
        $category_name=$rs[0]->category_name;
        $category_parent=$rs[0]->idparent;
        $id_category=$rs[0]->id_category;
    }
?>


<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/category/" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-12 col-md-10 offset-md-1">
        <form class="custom-form" method="post" role="form" id="frm_slide">
            <div class="form-group">
                <label for="category_name">Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required value="<?=$category_name?>" title="Name is required">
            </div>
            <div class="form-group">
                <label for="id_category">หมวดหมู่</label>
                <select class="custom-select" name="id_category" id="id_category" required title="หมวดหมู่ is required" >
                    <option value=""> - select parrent - </option>
                    <?php  foreach ($category as $key => $value) {?>  
                        <?php if($value->id_section==$id_section){?>
                            <option value="<?=$value->id_category?>" <?=$category_parent==$value->id_category?'selected':''?>> <?=$value->category_name?> </option> 
                        <?php }?>
                    <?php } ?>
                </select>
            </div>
            <hr>
            <div class="form-group text-right mt-3">
                <input type="hidden" name="id_section" id="id_section" value="<?=$id_section?>">
                <input type="hidden" name="id_category" id="id_category" value="<?=$id_category?>">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
                <a href="javascript:history.back()" class="btn btn-custom btn-base-color">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>