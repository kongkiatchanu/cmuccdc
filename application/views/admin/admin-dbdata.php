
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
			</div>
		</div>
		
		<div class="row" style="margin-bottom:30px;">
			<div class="col-md-12">
				<form class="form-inline" role="form" method="post">
					<div class="form-group">
						<label class="sr-only" for="exampleInputEmail2">web id</label>
						<input type="text" name="webid" class="form-control" id="exampleInputEmail2" placeholder="input webid" required>
					</div>
					<div class="form-group">
						<label class="sr-only" for="exampleInputPassword2">table</label>
						<select class="form-control" name="tb" required>
							<option value=""></option>
							<option value="log_mini_2561">log_mini_2561</option>
							<option value="log_data_2562">log_data_2562</option>
						</select>
					</div>
					<button type="submit" class="btn btn-default blue">Query!</button>
				</form>
							

			</div>
		</div>
		
		<hr/>
		<div class="row">
			<div class="col-md-12">

				<div class="table-responsive">
					<table class="table" id="sample_2">
						<thead>
							<tr style="font-weight: 500;background-color: #333;color:#fff;">
								<th>source_id</th>
								<th>nickname</th>
								<th>pm25</th>
								<th>pm10</th>
								<th>temp</th>
								<th>humid</th>
								<th>datetime</th>
								<th>ip</th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $value) {$i++;?>  

						<tr>
							<td><?=$value->source_id?></td>
							<td><?=$value->nickname?></td>
							<td><?=$value->log_pm10?></td>
							<td><?=$value->log_pm25?></td>
							<td><?=$value->temp?></td>
							<td><?=$value->humid?></td>
							<td><?=$value->log_datetime?></td>
							<td><?=$value->source_ip?></td>
						</tr>
						<?php }?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>


