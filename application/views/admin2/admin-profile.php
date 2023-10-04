<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
</div>
<div class="main-body row">
    <div class="col-12 col-md-10 offset-md-1">
        <form class="custom-form" method="post" role="form" id="form_profile">
            <?php if($this->uri->segment(3)=='fail'){?>
                <div class="msgalert alert alert-danger">
                    <h4>คำเตือน! รหัสผ่านไม่ถูกต้อง</h4>
                </div>
            <?php }?>
            <?php if($this->uri->segment(3)=='success'){?>
                <div class="msgalert alert alert-success">
                    <h4>เรียบร้อย! ระบบดำเนินการเปลี่ยนข้อมูลเรียบร้อย</h4>
                </div>
            <?php }?>
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้</label>
                <input type="text" class="form-control" id="username" name="username" required value="<?=$_user['username']?>" readonly title="ชื่อผู้ใช้ is required">
            </div>
            <div class="form-group">
                <label for="displayname">ชื่อที่แสดง</label>
                <input type="text" class="form-control" id="displayname" name="displayname" required value="<?=$_user['display']?>" title="ชื่อที่แสดง is required">
            </div>
            <div class="form-group">
                <label for="o_password">รหัสผ่านเดิม</label>
                <input type="password" class="form-control" id="o_password" name="o_password" required title="รหัสผ่านเดิม is required">
            </div>
            <div class="form-group">
                <label for="n_password">รหัสผ่านใหม่</label>
                <input type="password" class="form-control" id="n_password" name="n_password" required title="รหัสผ่านใหม่ is required">
            </div>
            <div class="form-group">
                <label for="c_password">ยืนยันรหัสผ่านใหม่</label>
                <input type="password" class="form-control" id="c_password" name="c_password" required title="ยืนยันรหัสผ่านใหม่ is required">
            </div>
            <hr>
            <div class="form-group text-right mt-3">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
                <a href="<?=base_url()?>admin2" class="btn btn-custom btn-base-color">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>