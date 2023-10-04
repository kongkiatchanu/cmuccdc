	
	<?php $action = $this->session->userdata('noti_action');?>
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
					<h5 class="mb-3">Province Filter</h5><hr/>
					<select class="form-control" id="province">
						<option value=""> เลือกจังหวัด </option>
						<?php foreach($rsProvince as $item){?>
						<option value="<?=$item->province_id?>"> <?=$item->province_name?> </option>
						<?php }?>
					</select>
				</div>
				<div class="load" style="display:none"><img src="/template/img/loader.gif"></div>
				<div class="content" style="display:none">
					<div class="table-responsive">
					<table class="table table-bordered" id="tblist">
						<thead>
							<tr>
								<th>webid</th>
								<th>name</th>
								<?php $timestamp =  strtotime('2022-01-01');?>
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
						<?php $timestamp =  strtotime('2022-01-01');?>
						<?php for($i=0; $i<365; $i++){?>
							html +='<td class="'+item.source_id+'_<?=date('Y-m-d', $timestamp)?> '+item.source_id+' <?=date('Y-m-d', $timestamp)?>"></td>';
						<?php $timestamp+= 24*3600; }?>
						html +='</tr>';
						
					});
					$.getJSON( '/maintain/getDataAll?id='+province_id, function( log ) {	
						inputValue(log)
					});
					$('#tblist tbody').html(html);
					$('.content').show();
					$('.load').hide();
				});
			});
			
			function inputValue(log){
				jQuery.each(log, function(index, item) {	
					
					$('.'+item.daily_date).html('');
					$('.'+item.source_id+'_'+item.daily_date).html(item.pm25);
					if(item.pm25>50){
						$('.'+item.source_id+'_'+item.daily_date).css('color','red');
					}
				});
			}

			$('#tblDB').DataTable({
				"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
				"columnDefs": [{ "type": "num", "targets": 3 }]
			});
		});
	</script>
	