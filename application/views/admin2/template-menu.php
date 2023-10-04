    <div class="menu-hide">
        <div class="icon">
            <div id="anima-home-hide" class="anima-icon" 
                data-icon="<?=base_url('assets/admin2/')?>assets/icon/custom-icon/arrow2.json">
            </div>
        </div>
    </div>
    <div class="main-menu layout-left">
        <div class="slide-menu">
            <?php //if($page=="index"){?>
                <div class="icon">
                    <div id="anima-home" class="anima-icon" data-icon="<?=base_url('assets/admin2/')?>assets/icon/custom-icon/arrow2.json"></div>
                </div>
            <?php //}?>
            
            <div class="logo">
                <img src="<?=base_url('assets/admin2/')?>assets/image/logo_dustboy.png" alt="DustBoy">
            </div>

            <ul class="sidebar-navbar-nav navbar-nav" id="sidebar">
                <!--
				<li class="sidebar-nav-item nav-item <?=$page=="source"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="javacript:void(0)" data-toggle="collapse" data-target="#collapse1"
                        aria-expanded="false" aria-controls="collapse1">
                        <span><i class="fas fa-map-marker-alt mr-2"></i> จุดตรวจวัด</span>
                        <div class="anima-arrow anima-icon float-right" data-icon="<?=base_url('assets/admin2/')?>assets/icon/custom-icon/arrow.json"></div>
                    </a>
                    <div id="collapse1" class="collapse <?=$page=="source"?'show':''?>" aria-labelledby="collapse1">
                        <div class="collapse-inner rounded">
                            <ul class="collapse-navbar-nav navbar-nav">
                                <li class="collapse-nav-item nav-item <?=@$this->uri->segment(2)=="source"&&$this->uri->segment(3)==null?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/source">ALL Model</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
				-->
				<li class="sidebar-nav-item nav-item <?=$page=="source"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="<?=base_url()?>admin2/source"><i class="fas fa-map-marker-alt mr-2"></i> จุดตรวจวัด</a>
                </li>
				<li class="sidebar-nav-item nav-item <?=$page=="offline_alert"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="<?=base_url()?>admin2/offline_alert"><i class="fas fa-solid fa-bell mr-2"></i> Offline Alert</a>
                </li>
                <li class="sidebar-nav-item nav-item <?=$page=="dbdata"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="<?=base_url()?>admin2/dbdata"><i class="fas fa-chart-bar mr-2"></i> ตรวจเช็คข้อมูล</a>
                </li>
				<li class="sidebar-nav-item nav-item <?=$page=="fixed"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="<?=base_url()?>admin2/fixed"><i class="fas fa-list mr-2"></i> รายละเอียดการซ่อม</a>
                </li>
				<li class="sidebar-nav-item nav-item <?=$page=="logbook"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="<?=base_url()?>admin2/logbook"><i class="fas fa-book mr-2"></i> LogBook</a>
                </li>
				<li class="sidebar-nav-item nav-item <?=$page=="paper"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="<?=base_url()?>admin2/paper"><i class="fas fa-file mr-2"></i> หนังสือขอความอนุเคราะห์</a>
                </li>
                <li class="sidebar-nav-item nav-item <?=$page=="content"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="javacript:void(0)" data-toggle="collapse" data-target="#collapse2"
                        aria-expanded="false" aria-controls="collapse2">
                        <span><i class="fas fa-info mr-2"></i> ข่าวสาร</span>
                        <div class="anima-arrow anima-icon float-right" data-icon="<?=base_url('assets/admin2/')?>assets/icon/custom-icon/arrow.json"></div>
                    </a>
                    <div id="collapse2" class="collapse <?=$page=="content"?'show':''?>" aria-labelledby="collapse2">
                        <div class="collapse-inner rounded">
                            <ul class="collapse-navbar-nav navbar-nav">
                                <li class="collapse-nav-item nav-item <?=$pagesub=="content"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/section/1">ข่าวประชาสัมพันธ์</a>
                                </li>
                                <li class="collapse-nav-item nav-item <?=$pagesub=="category"?'active':''?>">
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/category">หมวดหมู่</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
				<li class="sidebar-nav-item nav-item <?=$page=="sinfo"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="javacript:void(0)" data-toggle="collapse" data-target="#collapse3"
                        aria-expanded="false" aria-controls="collapse3">
                        <span><i class="fas fa-info mr-2"></i> ข้อมูลเว็บไซต์</span>
                        <div class="anima-arrow anima-icon float-right" data-icon="<?=base_url('assets/admin2/')?>assets/icon/custom-icon/arrow.json"></div>
                    </a>
                    <div id="collapse3" class="collapse <?=$page=="sinfo"?'show':''?>" aria-labelledby="collapse3" >
                        <div class="collapse-inner rounded">
                            <ul class="collapse-navbar-nav navbar-nav">
                                <li class="collapse-nav-item nav-item <?=$pagesub=="page"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/page">หน้าแสดงข้อมูล</a>
                                </li>
                                <li class="collapse-nav-item nav-item <?=$pagesub=="slide"?'active':''?>">
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/slide">สไลด์หน้าแรก</a>
                                </li>
								<li class="collapse-nav-item nav-item <?=$pagesub=="vdo"?'active':''?>">
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/vdo">วิดีโอยูทูป</a>
                                </li>
								<li class="collapse-nav-item nav-item <?=$pagesub=="research"?'active':''?>">
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/research">บทความ / งานวิจัย</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="sidebar-nav-item nav-item <?=$page=="config"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="javacript:void(0)" data-toggle="collapse" data-target="#collapse4"
                        aria-expanded="false" aria-controls="collapse4">
                        <span><i class="fas fa-cog mr-2"></i> ตั้งค่าระบบ</span>
                        <div class="anima-arrow anima-icon float-right" data-icon="<?=base_url('assets/admin2/')?>assets/icon/custom-icon/arrow.json"></div>
                    </a>
                    <div id="collapse4" class="collapse <?=$page=="config"?'show':''?>" aria-labelledby="collapse4" >
                        <div class="collapse-inner rounded">
                            <ul class="collapse-navbar-nav navbar-nav">
                                <li class="collapse-nav-item nav-item <?=$pagesub=="profile"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/profile">เปลี่ยนรหัสผ่าน</a>
                                </li>
								 <li class="collapse-nav-item nav-item <?=$pagesub=="api"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/api">APIs</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
				<li class="sidebar-nav-item nav-item <?=$page=="maintain"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="javacript:void(0)" data-toggle="collapse" data-target="#collapse5"
                        aria-expanded="false" aria-controls="collapse5">
                        <span><i class="fas fa-cog mr-2"></i> DustBoy อาสา</span>
                        <div class="anima-arrow anima-icon float-right" data-icon="<?=base_url('assets/admin2/')?>assets/icon/custom-icon/arrow.json"></div>
                    </a>
                    <div id="collapse5" class="collapse <?=$page=="maintain"?'show':''?>" aria-labelledby="collapse5" >
                        <div class="collapse-inner rounded">
                            <ul class="collapse-navbar-nav navbar-nav">
                                <li class="collapse-nav-item nav-item <?=$pagesub=="maintain_request"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/maintain_request">คำขอติดตั้ง</a>
                                </li>
								<li class="collapse-nav-item nav-item <?=$pagesub=="maintain_noti"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/maintain_noti">แจ้งอัพเดทข้อมูล</a>
                                </li>
								<li class="collapse-nav-item nav-item <?=$pagesub=="maintain_setup"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/maintain_setup">แจ้งติดตั้งเครื่อง</a>
                                </li>
								<li class="collapse-nav-item nav-item <?=$pagesub=="maintain_renew"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/maintain_renew">แจ้งต่ออายุ</a>
                                </li>
								<!--
								<li class="collapse-nav-item nav-item <?=$pagesub=="maintain_updatedata"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/maintain_updatedata"></a>
                                </li>
								<li class="collapse-nav-item nav-item <?=$pagesub=="maintain_member"?'active':''?>" >
                                    <a class="collapse-nav-link nav-link" href="<?=base_url()?>admin2/maintain_member">รายชื่อสมาชิก</a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="sidebar-nav-item nav-item <?=$page=="contact"?'active':''?>">
                    <a class="sidebar-nav-link nav-link" href="<?=base_url()?>admin2/contact"><i class="fas fa-envelope mr-2"></i> ข้อมความติดต่อ</a>
                </li>
        </div>
    </div>