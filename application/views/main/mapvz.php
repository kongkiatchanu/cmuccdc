		<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datepicker/datepicker.css">
		<div class="container">
			<div class="row">
				<div class="col-md-4 offset-md-4 pt-3 pb-3">
					<form class="form-inline text-center" method="get" action="">
								<div class="col-md-5 mb-3"> 
									<label class="mb-2">รูปแบบ</label> 
									<select class="form-control" name="source" id="source" required="" style="width:100%;"> 
										<option value="TH">TH AQI</option>
										<option value="US">US AQI</option>
									</select> 
								</div> 
								<div class="col-md-5 mb-3"> 
									<label class="mb-2">วันที่ </label> 
									<input type="text" style="width:100%;" class="form-control datetime" id="dateStart" name="dateStart" value="<?=date('Y-m-d')?>" required=""> 
								</div> 
								<div class="col-md-2 mb-3"> 
									<button type="button" class="btn btn-primary" id="btn-filter" style="margin-top: 30px;">Submit</button> 
								</div> 
					</form>
				</div>
			</div>
			
			<div class="row mb-5">
				<div class="col-md-12">
					<div class="loader">
						<p class="text-center"><img style="max-width:100%" src="<?=base_url()?>template/image/loader.gif"></p>
					</div>
					<div id="display_image"></div>
				</div>
			</div>
		</div>
		
		<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script>
		$(document).ready(function(){
			$(".datetime").datepicker({ 
				 format: 'yyyy-mm-dd'
			});
			
			function getVZImage(source, action){
				var tmp='';
				$.getJSON("<?=$this->config->item('base_api')?>main/getVZImage/"+source+"/"+action, function(result){		
					
					tmp += '<div class="row">';
					if(result){
						$.each(result, function (key,value) {
							console.log(value);
							tmp +='<div class="col-sm-3" style="margin-bottom:15px;position: relative;">';
							tmp +='<span style="position: absolute;background-color: #9dc02d;padding: 2px;color: #fff;">'+value.time+' น.</span>';
							tmp +='<a target="_blank" href="'+value.url+'"><img src="'+value.url+'" class="img-fluid"/></a></div>';
						});
					}else{
						tmp +='<div class="col-md-12"><p class="text-center"> ไม่พบข้อมูล </p></div>';
					}
					tmp += '</div>';
					
					$('.loader').hide();
					$('#display_image').html(tmp);
				});
			}
					
			getVZImage($('#source').val(), $('#dateStart').val());
			
			$('#btn-filter').on( "click", function() {
				$('.loader').show();
				$('#display_image').html('');
				getVZImage($('#source').val(), $('#dateStart').val(), $('#stime').val());
			});
		});
		</script>
		
		
	
