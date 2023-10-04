<?php 
 $ar_index = array(
	'1'	=> 'ต่ออายุ',
	'2'	=> 'อัพเกรด',
	'3'	=> 'ไม่ต่อ'
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
                    <td class="table-header">รหัสเครื่อง</td>
                    <td class="table-header">จุดติดตั้ง</td>
                    <td class="table-header">ชื่อผู้ประสาน</td>
                    <td class="table-header">โทร</td>
                    <td class="table-header">ประสงค์</td>
                    <td class="table-header">หลักฐาน</td>
                    <td class="table-header">tracking</td>
                    <td class="table-header">บริษัท</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
				
					<tr class="table-row-detail">
						<td class="table-detail text-center"><?=$value->dustboy_code?></td>
						<td class="table-detail"><?=$value->dustboy_name?></td>
						<td class="table-detail"><?=$value->dustboy_co?></td>
						<td class="table-detail text-center"><?=$value->dustboy_mobile?></td>
						<td class="table-detail text-center"><?=$ar_index[$value->dustboy_type]?></td>
						<td class="table-detail text-center"><a target="_blank" href="<?=base_url('uploads/requests/'.$value->dustboy_img)?>">ดูหลักฐาน</a></td>
						<td class="table-detail"><?=$value->dustboy_send_code?></td>
						<td class="table-detail"><?=$value->dustboy_send_name?></td>

					</tr>
               
                <?php }?>
            </tbody>
        </table>
    </div>
	
</div>