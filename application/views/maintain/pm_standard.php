	
	<?php $action = $this->session->userdata('noti_action');?>
	<?php $year = $this->input->get('year');?>
	<?php if(!$year){ $year = '2023';}?>
	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<style>
	.info-box {
    border-bottom-left-radius: 5px;
    border-top-right-radius: 5px;
    min-height: 100px;
    background: #fff;
    width: 100%;
    box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
    -webkit-box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
    margin-bottom: 20px;
    padding: 15px;
	color:#fff;
}
	.bg-b-green {
		background: linear-gradient(45deg,#2ed8b6,#59e0c5);
	}
	.bg-b-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}
.bg-b-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}
.bg-b-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}
	</style>

	<div class="container-fluid mb-5">
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">pm รายจังหวัด</li>
				  </ol>
				</nav>
			</div>
		</div>
		<div class="row mt-3 mb-3">
			<div class="col-md-12">
				<div class="form-filler">
					<div class="mb-3">
						<a href="<?=base_url('maintain/pm_standard?year=2019')?>" class="btn btn-<?=$year==2019?'info':'secondary'?>">2019</a>
						<a href="<?=base_url('maintain/pm_standard?year=2020')?>" class="btn btn-<?=$year==2020?'info':'secondary'?>">2020</a>
						<a href="<?=base_url('maintain/pm_standard?year=2021')?>" class="btn btn-<?=$year==2021?'info':'secondary'?>">2021</a>
						<a href="<?=base_url('maintain/pm_standard?year=2022')?>" class="btn btn-<?=$year==2022?'info':'secondary'?>">2022</a>
						<a href="<?=base_url('maintain/pm_standard?year=2023')?>" class="btn btn-<?=$year==2022?'info':'secondary'?>">2023</a>
					</div>
					<h5 class="mb-3">Province Filter</h5><hr/>
					<select class="form-control" id="province">
						<option value=""> เลือกจังหวัด </option>
						<?php foreach($rsProvince as $item){?>
						<option value="<?=$item->province_id?>"> <?=$item->province_name?> </option>
						<?php }?>
					</select>
				</div>
				<div class="load" style="display:none"><img src="/template/img/loader.gif"></div>
				<div class="content pt-3 pb-3" style="display:none">
					<h1>PM2.5 > 37.5 : <span id="amount"></span> Days</h1>
					<div class="table-responsive">
					<table class="table table-bordered" id="tblist">
						<thead>
							<tr>
								<th>webid</th>
								<th>name</th>
								<?php $timestamp =  strtotime($year.'-01-01');?>
								<?php for($i=0; $i<365; $i++){?>
									<th><?=date('m/d', $timestamp)?></th>
								<?php $timestamp+= 24*3600;}?>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
	<script>
		$( document ).ready(function() {
			
			
			
			
			$('select').on('change', function() {
				var province_id = this.value;
				$('.load').show();
				$.getJSON( '/maintain/getSource?id='+province_id, function( data ) {
					
					
					var i;
					var html;
					jQuery.each(data, function(index, item) {	
						
						html +='<tr>';
						html +='<td width="100">'+item.source_id+'</td>';
						html +='<td>'+item.location_name+'</td>';
						<?php $timestamp =  strtotime($year.'-01-01');?>
						<?php for($i=0; $i<365; $i++){?>
							html +='<td class="row<?=$i?> '+item.source_id+'_<?=date('Y-m-d', $timestamp)?> '+item.source_id+' <?=date('Y-m-d', $timestamp)?>"><img src="/template/img/loader.gif"></td>';
						<?php $timestamp+= 24*3600; }?>
						html +='</tr>';
						
						$.getJSON( '/maintain/getData?id='+item.source_id, function( log ) {	
							inputValue(item.source_id, log)
						});
					});
					
					$('#tblist tbody').html(html);
					$('.content').show();
					$('.load').hide();
				});
			});
			
			function inputValue(id, log){
				$('.'+id).html('');
				jQuery.each(log, function(index, item) {	
					$('.'+id+'_'+item.daily_date).html(item.pm25);
					if(item.pm25>37.5){
						$('.'+id+'_'+item.daily_date).css('color','rgb(242,101,34)');
					}else if(item.pm25>=25.1 && item.pm25<=37.5){
						$('.'+id+'_'+item.daily_date).css('color','rgb(253,192,78)');
					}else if(item.pm25>=15.1 && item.pm25<25.1){
						$('.'+id+'_'+item.daily_date).css('color','rgb(0,166,81)');
					}else{
						$('.'+id+'_'+item.daily_date).css('color','rgb(0,191,243)');
					}
					
				});
				calulateRow();
			}
			
			function calulateRow(){
				
				const totals = [];
				
				for(var x=0; x<365; x++){
					var check = 0;
					totals[x] = 0;
					$(".row"+x).each(function(){
						var val = parseInt($(this).text());
						if (val>37.5) {
							check=1;
						}          
					});   
					
					if(check==1){
						totals[x] = 1;
					}
				}
				
				var number = 0;
				for(var y=0; y<365; y++){
					number +=totals[y];
				
					$('#amount').html(number);
					
				}

				
			}
			
			$('#tblDB').DataTable({
				"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
				"columnDefs": [{ "type": "num", "targets": 3 }]
			});
		});
	</script>
	