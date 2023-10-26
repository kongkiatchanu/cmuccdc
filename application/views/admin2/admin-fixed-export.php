<?php 
//header("Content-type: application/vnd.ms-excel");
// header('Content-type: application/csv'); //*** CSV ***//
//header("Content-Disposition: attachment; filename=dustboy_date.xls");

?>
    <div class="table-responsive mb-5">
        <table id="table-test" class="table table-custom" style="width:100%">
            <thead style="text-align:center">
                <tr class="table-row-header">
                    <td class="table-header" width="80" rowspan="2">หมายเลขเครื่อง</td>
                    <td class="table-header" width="400" rowspan="2">จุดติดตั้ง</td>
                    <td class="table-header" width="70" rowspan="2">ประเภท</td>
                    <td class="table-header" width="300" colspan="2">วันที่ส่งเครื่องมาซ่อม</td>
                    <td class="table-header" width="300" colspan="2">วันที่รับเครื่อง</td>
                    <td class="table-header" width="450" colspan="3">วันที่ส่งซ่อม</td>
                    <td class="table-header" width="300" colspan="2">วันที่รับเครื่องหลังจากซ่อม</td>
                    <td class="table-header" width="300" colspan="2">วันที่ส่งคืน</td>
                    <td class="table-header" width="150" rowspan="2">รหัสไปรษณ์ย์</td>
                    <td class="table-header" width="150" rowspan="2">สถานะการส่งซ่อม</td>
                </tr>
                <tr>
                    <td class="table-header" width="150">วันที่</td>
                    <td class="table-header" width="150">หมายเหตุ</td>
                    <td class="table-header" width="150">วันที่</td>
                    <td class="table-header" width="150">หมายเหตุ</td>
                    <td class="table-header" width="150">วันที่</td>
                    <td class="table-header" width="150">หมายเหตุ</td>
                    <td class="table-header" width="150">ผู้ผลิต</td>
                    <td class="table-header" width="150">วันที่</td>
                    <td class="table-header" width="150">หมายเหตุ</td>
                    <td class="table-header" width="150">วันที่</td>
                    <td class="table-header" width="150">หมายเหตุ</td>

                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
				
					<!-- <tr class="table-row-detail">
						<td class="table-detail text-center"><?=$value->location_id?></td>
						<td class="table-detail"><?=$value->location_name?></td>
						<td class="table-detail text-center"><?=$value->fixed_type?></td>
						<td class="table-detail text-center"><?=$value->fixed_get_date=="0000-00-00"?'-':'<span title="'.$value->fixed_get_comment.'">'.$value->fixed_get_date.'<br/>'.$value->fixed_get_comment.'</span>'?></td>
						<td class="table-detail text-center"><?=$value->fixed_send_date=="0000-00-00"?'-':$value->fixed_send_date?></td>
						<td class="table-detail text-center"><?=$value->fixed_repair_date=="0000-00-00"?'-':$value->fixed_repair_date?></td>

					</tr> -->
                <?php }?>

            </tbody>
        </table>
	