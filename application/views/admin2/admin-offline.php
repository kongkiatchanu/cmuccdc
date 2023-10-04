<?php 
$target = array();
foreach($rsDBList as $item){
	if (in_array($item->source_id, $rsList)){
		array_push($target, $item);
	}
}

$data = array();
foreach($json_setting as $k=>$item){
	$data[$k] = $item;
}

?>
<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
</div>

<div class="main-body row">
    <div class="col-md-12 ">
		<div class="alert alert-info">
			เลือกจุดติดตั้งที่ต้องการให้แจ้งเตือนในกรณีที่เครื่องออฟไลน์เกิน 1 วัน
		</div>
        <form class="custom-form" method="post" role="form">
		<?php foreach($target as $k=>$item){?>
			<input type="hidden" name="station[<?=$item->source_id?>]" value="0">
			<div class="form-check">
			  <input class="form-check-input" type="checkbox" value="1" name="station[<?=$item->source_id?>]" id="flexCheckDefault_<?=$k?>" <?=@$data[$item->source_id]=="1"?'checked':''?>/>
			  <label class="form-check-label" for="flexCheckDefault_<?=$k?>">
				[<?=$item->source_id?>]<?=$item->location_name?>
			  </label>
			</div>
			
		<?php }?>
			<hr/>
			<button type="submit" class="btn btn-primary">save</button>
        </form>
    </div>
</div>
