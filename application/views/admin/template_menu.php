<!-- BEGIN SIDEBAR -->
	<?php $shop = $this->session->userdata('logged_in_shop');?>
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<br/>
				<li class="start <?=$page=="index"?'active':''?>">
					<a href="<?=base_url()?>admin">
					<i class="fa fa-home"></i>
					<span class="title">
						หน้าหลัก
					</span>
					</a>
				</li>
				<!--
				<li class="<?=$page=="cast"?'active':''?>">
					<a href="javascript:;">
						<i class="fa fa-camera-retro"></i>
						<span class="title">
							การรายงานผลรายวัน
						</span><span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li class="<?=$pagesub=='forcast'?'active':''?>"><a href="<?=base_url()?>admin/forcast"><i class="fa fa-list"></i> กรมควบคุมมลพิษ</a></li>
						<li class="<?=$pagesub=='forcastdustboy'?'active':''?>"><a href="<?=base_url()?>admin/forcastdustboy"><i class="fa fa-cog"></i> Dustboy</a></li>
					</ul>
				</li>
				
				
				<li class="<?=$page=="snapshot"?'active':''?>">
					<a href="<?=base_url()?>admin/snapshot">
					<i class="fa fa-camera"></i>
					<span class="title">
						Snapshot
					</span>
					</a>
				</li>
				<li class="<?=$page=="airdetail"?'active':''?>">
					<a href="<?=base_url()?>admin/airdetail">
					<i class="fa fa-list-alt"></i>
					<span class="title">
						ดัชนีคุณภาพอากาศ
					</span>
					</a>
				</li>
				-->
				<li class="<?=$page=="source"?'active':''?>">
					<a href="<?=base_url()?>admin/source">
					<i class="fa fa-map-marker"></i>
					<span class="title">
						จุดตรวจวัด
					</span>
					</a>
				</li>
				<li class="<?=$page=="dbdata"?'active':''?>">
					<a href="<?=base_url()?>admin/dbdata">
					<i class="fa fa-bar-chart-o "></i>
					<span class="title">
						ตรวจเช็คข้อมูล
					</span>
					</a>
				</li>
				<li class="<?=$page=="api"?'active':''?>">
					<a href="<?=base_url()?>admin/api">
					<i class="fa fa-pagelines "></i>
					<span class="title">
						APIs
					</span>
					</a>
				</li>
				
				
				<li class="<?=$page=="slide"?'active':''?>">
					<a href="<?=base_url()?>admin/slide">
					<i class="fa fa-windows"></i>
					<span class="title">
						สไลด์หน้าแรก
					</span>
					</a>
				</li>
				
				<li class="<?=$page=="page"?'active':''?>">
					<a href="<?=base_url()?>admin/page">
					<i class="fa fa-info"></i>
					<span class="title">
						หน้าแสดงข้อมูล
					</span>
					</a>
				</li>
			
				<li class="<?=$page=="content"?'active':''?>">
					<a href="javascript:;">
						<i class="fa fa-info"></i>
						<span class="title">
							ข่าวสาร
						</span><span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li class="<?=$pagesub=='content'?'active':''?>"><a href="<?=base_url()?>admin/section/1"><i class="fa fa-list"></i> ข่าวประชาสัมพันธ์</a></li>
						<li class="<?=$pagesub=='category'?'active':''?>"><a href="<?=base_url()?>admin/category"><i class="fa fa-cog"></i> หมวดหมู่</a></li>
					</ul>
				</li>
				<li class="<?=$page=="vdo"?'active':''?>">
					<a href="<?=base_url()?>admin/vdo">
					<i class="fa fa-youtube-play"></i>
					<span class="title">
						วีดีโอยูทูป
					</span>
					</a>
				</li>
				<li class="<?=$page=="research"?'active':''?>">
					<a href="<?=base_url()?>admin/research">
					<i class="fa fa-file"></i>
					<span class="title">
						บทความ / งานวิจัย
					</span>
					</a>
				</li>

				<li class="<?=$page=="config"?'active':''?>">
					<a href="javascript:;"><i class="fa fa-cog"></i>
						<span class="title">ตั้งค่าระบบ</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<!--
						<li class="<?=$pagesub=='menu'?'active':''?>"><a href="<?=base_url()?>admin/menu"><i class="fa fa-cog"></i> เมนู</a></li>
						<li class="<?=$pagesub=='landingpage'?'active':''?>"><a href="<?=base_url()?>admin/landingpage"><i class="fa fa-cog"></i> Landing / Popup</a></li>
						<li class="<?=$pagesub=='web_info'?'active':''?>"><a href="<?=base_url()?>admin/web_info"><i class="fa fa-cog"></i> ข้อมูลเว็บไซต์</a></li>
						<li class="<?=$pagesub=='web_aboutus'?'active':''?>"><a href="<?=base_url()?>admin/web_aboutus"><i class="fa fa-cog"></i> หน้าเกี่ยวกับเรา</a></li>
						<li class="<?=$pagesub=='web_contactus'?'active':''?>"><a href="<?=base_url()?>admin/web_contactus"><i class="fa fa-cog"></i> หน้าติดต่อเรา</a></li>-->
						<li class="<?=$pagesub=='profile'?'active':''?>"><a href="<?=base_url()?>admin/profile"><i class="fa fa-cog"></i> เปลี่ยนรหัสผ่าน</a></li>
					
					</ul>
				</li>
				<!--
				<li class="<?=$page=="ads"?'active':''?>">
					<a href="javascript:;"><i class="fa fa-cog"></i>
						<span class="title">ผู้สนับสนุน</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						
						<li class="<?=$pagesub=='external'?'active':''?>"><a href="<?=base_url()?>admin/external"><i class="fa fa-star"></i> CCDC</a></li>
						<li class="<?=$pagesub=='external2'?'active':''?>"><a href="<?=base_url()?>admin/external2"><i class="fa fa-star"></i> Opendata</a></li>		
					</ul>
				</li>
				
				<li class="<?=$page=="member"?'active':''?>">
					<a href="<?=base_url()?>admin/member">
					<i class="fa fa-user"></i>
					<span class="title">
						เจ้าหน้าที่
					</span>
					</a>
				</li>
				-->
				<li class="last <?=$page=="contact"?'active':''?>">
					<a href="<?=base_url()?>admin/contact">
						<i class="fa fa-envelope-o"></i>
						<?php if($rsInbox[0]->total_row>0){?>
						<span class="badge badge-info alertInbox"><?=$rsInbox[0]->total_row?></span>
						<?php }?>
						<span class="title">ข้อความติดต่อ</span>
					</a>
				</li>

			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->