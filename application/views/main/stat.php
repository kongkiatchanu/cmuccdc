		<style>
		#embed_chart{width:100%!important;}
		</style>
		<div class="container mb-5">
			<div class="row mt-3 mb-3">
				<div class="col-12">
					<h5>Statistics</h5>
					<span style="color:#666;font-size:small">Users <?=number_format($rsStat->rows[0][0])?> | Sessions <?=number_format($rsStat->rows[0][1])?></span>
				</div>
			</div>
			<div class="row mt-3 mb-3">
				<?php 

				?>
				<div class="col-md-6">
					<iframe width="100%" height="450" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQyi9A0aU0i2ogWxoUImSpoM035qGzysrCJPftVqSCaHy9aT37VTgyhxfuXN3LtIurBh3p1tsUisdYq/pubchart?oid=1306049528&amp;format=interactive"></iframe>
				</div>
				<div class="col-md-6">
					<iframe width="100%" height="450" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQyi9A0aU0i2ogWxoUImSpoM035qGzysrCJPftVqSCaHy9aT37VTgyhxfuXN3LtIurBh3p1tsUisdYq/pubchart?oid=781038038&amp;format=interactive"></iframe>
				</div>
			</div>
		</div>
		<script>
		$(document).ready(function() {
			function convertDateFormat(dlog){
				var f_date = dlog.split(' ');
				var a_date = f_date[0].split('-');
				var d =a_date[2]+'/'+a_date[1]+'/'+a_date[0];
				var t =f_date[1].substring(0,5);
				console.log(d+' '+t);
			}
			convertDateFormat('2020-01-24 16:00:00');
		} );
		</script>


		
