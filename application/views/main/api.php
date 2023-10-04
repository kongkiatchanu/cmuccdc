		<link rel="stylesheet" href="<?=base_url()?>assets/plugins/jsonviewer/css/jjsonviewer.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/plugins/prism/prism.css">
		<style>
.sec{margin-bottom:50px;}
	.card-item{
		border: 1px solid #9dc03b;
		box-shadow: 0 0 2px rgba(0,0,0,.1);
		margin-bottom: 12px;
	}	
	.card-header{background-color: #9dc03b26;
		border-bottom: 0;
		border-radius: 3px;
		height: 48px;
		padding: 8px 20px;
		cursor: pointer;
	}
	.card-title {
		display: inline-flex;
	}
	.btn-get {
    color: #fff;
    background-color: #9dc03b;
    border-color: #9dc03b;
    width: 80px;
}
.btn-api {
    border-radius: 4px;
    cursor: pointer;
    height: 32px;
    line-height: 0;
    min-width: 80px;
    padding: 6px 16px;
    font-weight: 700;
}
.card-title .name {
    color: #383b39;
    margin-left: 16px;
    margin-bottom: 0;
    padding-top: 6px;
    padding-bottom: 6px;
        font-weight: bold;
}

strong{font-size: 18px;}
.close{ 
	float: unset;
	font-size: unset;
	font-weight:unset;
	line-height:unset;
	color: #000;unset;
	text-shadow:unset;
	opacity: unset;
}
		</style>
		<div class="container mb-5">
			<div class="row pt-5 pb-2">
				<div class="col-md-10">
					<div class="sec" id="overview">
						<h3 class="mb-3">Overview</h3>
						<p>ศูนย์ข้อมูลการเปลี่ยนแปลงสภาพภูมิอากาศ (Climate Change Data Center: CCDC) มหาวิทยาลัยเชียงใหม่ (www.cmuccdc.org) ได้ดำเนินโครงการ "เครือข่ายเฝ้าระวังและเตือนภัยวิกฤตหมอกควันภาคประชาชน (People AQI)" ร่วมกับเครือข่ายติดตั้งเครื่องตรวจวัดคุณภาพอากาศ DustBoy ภายใต้การสนับสนุนของสำนักงานการวิจัยแห่งชาติ (วช.) ในการติดตั้งเครื่องวัดฝุ่น "DustBoy" มากกว่า 400 จุด ทั่วประเทศ ทำให้สามารถแสดงข้อมูลคุณภาพอากาศได้ครอบคลุมทุกจังหวัดในประเทศไทย</p>
						<p><i>Call</i></p>
						<pre><code class="language-markup"><?=base_url()?>api/ccdc</code></pre>
						<p><i>Response</i></p>
						<div id="exam" class="jjson"></div>
					</div>
					
					<div class="sec" id="dustboy">
						<h3 class="mb-3">DustBoy API</h3>
						<p>DustBoy API (Application Programming Interface) รองรับการเข้าถึงข้อมูลต่างๆ  โดยจะกำหนดขอบเขตในการเข้าถึงบริการต่างๆ ของทางเว็บไซต์</p>
						<div id="accordion">
							<div class="card card-item">
								<div class="card-header" id="headingOne">
									<div class="mb-0 card-title">
										<button class="btn btn-api btn-get" data-toggle="collapse" data-target="#collapseOne"  aria-controls="collapseOne">GET</button>
										<p class="name">Stations</p>
									</div>
								</div>

								<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
									<div class="card-body">
										<p>แสดงจุดตรวจวัดคุณภาพอากาศทั้งหมด ที่มีการเก็บข้อมูล</p>
										
										<p><strong>Call</strong></p>
										<pre><code class="language-markup">/api/ccdc/stations</code></pre>
										
										<p><strong>Formats</strong></p>
										<table class="table table-sm">
										  <tbody>
											<tr>
											  <td>JSON(default)</td>
											  <td>/api/ccdc/stations?format=json</td>
											</tr>
											<tr>
											  <td>XML</td>
											  <td>/api/ccdc/stations?format=xml</td>
											</tr>
											
										  </tbody>
										</table>

										<p><strong>Example</strong></p>
										<pre><code class="language-markup"><?=base_url()?>api/ccdc/stations</code></pre>
										<button class="btn btn-secondary btn-sm btn-getapi mb-3" call-target="stations" call-url="<?=base_url()?>api/ccdc/stations">Try it!</button>
										<button class="btn btn-secondary btn-sm btn-clear mb-3" id="clear_stations" call-target="stations"style="display:none;">Clear</button>
										
										<div id="response_stations" class="response"></div>
									</div>
								</div>
							</div>
							
							<div class="card card-item">
								<div class="card-header" id="s_detail">
									<div class="mb-0 card-title">
										<button class="btn btn-api btn-get" data-toggle="collapse" data-target="#s_detail_body"  aria-controls="s_detail_body">GET</button>
										<p class="name">Station Detail</p>
									</div>
								</div>

								<div id="s_detail_body" class="collapse" aria-labelledby="s_detail" data-parent="#accordion">
									<div class="card-body">
										<p>แสดงค่าที่ได้จากจุดตรวจวัดล่าสุด</p>

										<p><strong>Parameter</strong></p>
										<table class="table table-sm">
										  <tbody>
											<tr>
											  <th>Name</th>
											  <th>Description</th>
											</tr>
											<tr>
											  <td>id</td>
											  <td>id ของเครื่องวัดฝุ่นละอองขนาดเล็กของ DustBoy แต่ละจุด</td>
											</tr>	
										  </tbody>
										</table>
										
										<p><strong>Call</strong></p>
										<pre><code class="language-markup">/api/ccdc/station/{id}</code></pre>
										
										<p><strong>Formats</strong></p>
										<table class="table table-sm">
										  <tbody>
											<tr>
											  <td>JSON(default)</td>
											  <td>/api/ccdc/station/{id}?format=json</td>
											</tr>
											<tr>
											  <td>XML</td>
											  <td>/api/ccdc/station/{id}?format=xml</td>
											</tr>
											
										  </tbody>
										</table>
										
										
										
										<p><strong>Example</strong></p>
										<pre><code class="language-markup"><?=base_url()?>api/ccdc/station/6</code></pre>
										<button class="btn btn-secondary btn-sm btn-getapi mb-3" call-target="stations_detail" call-url="<?=base_url()?>api/ccdc/station/6">Try it!</button>
										<button class="btn btn-secondary btn-sm btn-clear mb-3" id="clear_stations_detail" call-target="stations_detail"style="display:none;">Clear</button>
										
										<div id="response_stations_detail" class="response"></div>
									</div>
								</div>
							</div>
							
							<div class="card card-item">
								<div class="card-header" id="s_pm">
									<div class="mb-0 card-title">
										<button class="btn btn-api btn-get" data-toggle="collapse" data-target="#s_pm_body"  aria-controls="s_pm_body">GET</button>
										<p class="name">DustBoy Value</p>
									</div>
								</div>

								<div id="s_pm_body" class="collapse" aria-labelledby="s_pm" data-parent="#accordion">
									<div class="card-body">
										<p>แสดงปริมาณฝุ่นละอองขนาดเล็ก PM 2.5 และ PM 10 แต่ละสถานี โดยมีพารามิเตอร์ดังนี้</p>
										
										<p><strong>Parameter</strong></p>
										<table class="table table-sm">
										  <tbody>
											<tr>
											  <th>Name</th>
											  <th>Description</th>
											</tr>
											<tr>
											  <td>Dustboy id</td>
											  <td>Dustboy id ของเครื่องวัดฝุ่นละอองขนาดเล็กของ DustBoy แต่ละจุด</td>
											</tr>
										  </tbody>
										</table>
										
										<p><strong>Call</strong></p>
										<pre><code class="language-markup">/api/ccdc/value/{dustboy_id}</code></pre>
										
										<p><strong>Formats</strong></p>
										<table class="table table-sm">
										  <tbody>
											<tr>
											  <td>JSON(default)</td>
											  <td>/api/dustboy/value/{dustboy_id}?format=json</td>
											</tr>
											<tr>
											  <td>XML</td>
											  <td>/api/dustboy/value/{dustboy_id}?format=xml</td>
											</tr>
											
										  </tbody>
										</table>
										
										<p><strong>Example</strong></p>
										<pre><code class="language-markup"><?=base_url()?>api/ccdc/value/6</code></pre>
										<button class="btn btn-secondary btn-sm btn-getapi mb-3" call-target="stations_value" call-url="<?=base_url()?>api/ccdc/value/6">Try it!</button>
										<button class="btn btn-secondary btn-sm btn-clear mb-3" id="clear_stations_value" call-target="stations_value" style="display:none;">Clear</button>
										
										<div id="response_stations_value" class="response"></div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<h3>DustBoy</h3>
					<ul class="list-unstyled">
						<li>
							<ul >
								<li>Stations</li>
								<li>Station Detail</li>
								<li>Dustboy Value</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>

		</div>

		<script type="text/javascript" src="<?=base_url()?>assets/plugins/jsonviewer/js/jjsonviewer.js?v=1"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/plugins/prism/prism.js?v=1"></script>
		<script>
        $( document ).ready(function() {
			$.getJSON( "https://dev2.cmuccdc.org/api/ccdc/", function( data ) {
				$("#exam").jJsonViewer(data);
			});
			
			$('.btn-clear').on('click',function(){
				var target =  $(this).attr("call-target");	
				$("#response_"+target).jJsonViewer();
				$("#response_"+target).hide();
				$('.btn-clear').hide();
			});
			
			$('.btn-getapi').on('click',function(){
				var call =  $(this).attr("call-url");	
				var target =  $(this).attr("call-target");	
				
				$.getJSON( call, function( data ) {
					if(data){
						$("#response_"+target).show();
						$("#response_"+target).jJsonViewer(data);
						$('#clear_'+target).show();
					}
				});
			});
		});
		</script>
		
