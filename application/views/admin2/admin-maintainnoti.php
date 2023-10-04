<?php 
 $ar_index = array(
	'fixed'	=> 'แจ้งเครื่องเสีย',
	'location'	=> 'แจ้งย้ายจุดติดตั้ง',
	'coordinator'	=> 'แจ้งเปลี่ยนชื่อผู้ประสานงาน'
 )

?>
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
                    <td class="table-header">ไอดี</td>
                    <td class="table-header">ประเภท</td>
                    <td class="table-header">จุดติดตั้ง</td>
                    <td class="table-header">วันที่</td>
                    <td class="table-header"></td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
				
					<tr class="table-row-detail" <?=$value->loc_view==0?'style="background-color: #d5e8f1;"':''?>>
						<td class="table-detail text-center"><?=$value->loc_db_id?></td>
						<td class="table-detail"><?=$ar_index[$value->loc_type]?></td>
						<td class="table-detail"><?=$value->loc_db_name?></td>
						<td class="table-detail text-center"><?=$value->createdate?></td>
						<td class="table-detail">
							<a href="<?=base_url('admin2/maintain_noti/view/'.$value->loc_id)?>" class="label label-secondary"> ดูข้อมูล </a>
						</td>
							
					</tr>
               
                <?php }?>
            </tbody>
        </table>
    </div>
	
</div>