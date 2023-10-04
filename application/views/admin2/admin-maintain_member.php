<div class="main-header row">
    <div class="col-12">
        <label class="title"><?=$pagename?></label>
    </div>
</div>
<hr/>
<div class="main-body">
    <div class="table-responsive mb-5">
        <table id="table-test" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header">ผู้ใช้</td>
                    <td class="table-header">สถานะ</td>

                    <td class="table-header">ล๊อคอินล่าสุด</td>
                    <td class="table-header"></td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
				
					<tr class="table-row-detail">
						<td class="table-detail"><?=$value->username?></td>
						<td class="table-detail"><?=$value->user_noti==1?'<span style="color:red">กรุณาอัพเดทข้อมูล</a>':'-'?></td>
				
						<td class="table-detail"><?=$value->user_lastlogin?></td>
						<td class="table-detail">
							<a href="<?=base_url()?>admin2/maintain_member/edit/<?=$value->username?>" class="btn btn-bg-color btn-custom-sm" title="แก้ไข">
                                <i class="fas fa-edit"></i>	
                            </a>
						</td>
					</tr>
               
                <?php }?>
            </tbody>
        </table>
    </div>
	
</div>