		<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datepicker/datepicker.css">
		<div class="container">
			<div class="row">
				<div class="col-md-8 offset-md-2 pt-3 pb-3">
					<form class="form-inline text-center" method="get" action="">
								<div class="col-md-7 mb-3"> 
									<label class="mb-2">จุดวัด</label> 
									<select class="form-control" name="source" id="source" required="" style="width:100%;"> 
										<option value="2004">Faculty of Engineering (CMU), Chiang Mai</option>
										<option value="6">Chiang Mai University (Mae Hia)</option>
										<option value="8">Greenpeace Thailand, Saphan Khwai(BKK)</option>
										<option value="11">Cafe’ My Day Off, Chiangdao</option>
										<option value="20">Rajamangala University of Technology Lanna (doi saket)</option>
										<option value="106">Rajamangala University of Technology Lanna</option>
										
										<option value="5248">National Astronomical Research Institute of Thailand (NARIT), Chiang Mai</option>
										<option value="4421">30 years (SCB1) Faculty of Science Chiang Mai University </option>
									</select> 
								</div> 
								<div class="col-md-3 mb-3"> 
									<label class="mb-2">วันที่ </label> 
									<input type="text" style="width:100%;" class="form-control datetime" id="dateStart" name="dateStart" value="<?=date('Y-m-d')?>" required=""> 
								</div> 
								<div class="col-md-2 mb-3"> 
									<button type="button" class="btn btn-primary" id="btn-filter" style="margin-top: 30px;">Submit</button> 
								</div> 
					</form>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="loader">
						<p class="text-center"><img style="max-width:100%" src="<?=base_url()?>template/image/loader.gif"></p>
					</div>
					<div id="display_snapshot"></div>
				</div>
			</div>
		</div>
		
		<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script>
		$(document).ready(function(){
			$(".datetime").datepicker({ 
				 format: 'yyyy-mm-dd'
			});
			
			function getSnapshot(source, action){
				var tmp='';
				$.getJSON("<?=$this->config->item('base_api')?>api2/dustboy/snapshot/"+source+"/"+action, function(result){		
					tmp += '<div class="row">';
					if(result[0]){
						$.each(result[0].snapshots, function (key,value) {
							console.log(value);
							tmp +='<div class="col-sm-4" style="margin-bottom:15px;position: relative;">';
							tmp +='<span style="position: absolute;background-color: #9dc02d;padding: 2px;color: #fff;">'+value.lastupdated+'</span>';
							tmp +='<a target="_blank" href="'+value.image_url+'"><img src="'+value.image_url+'" class="img-fluid"/></a></div>';
						});
					}else{
						tmp +='<div class="col-md-12"><p class="text-center"> ไม่พบข้อมูล </p></div>';
					}
					tmp += '</div>';
					$('.loader').hide();
					$('#display_snapshot').html(tmp);
				});
			}
					
			getSnapshot($('#source').val(), $('#dateStart').val());
			
			$('#btn-filter').on( "click", function() {
				$('.loader').show();
				$('#display_snapshot').html('');
				getSnapshot($('#source').val(), $('#dateStart').val(), $('#stime').val());
			});
		});
		</script>
		
		
	
