<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
			</div>
		</div>
		<hr/>
		<div class="row">

			<div class="col-md-8">
				<h4><i class="fa fa-list"></i> Group by Theme</h4>
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover table-condensed">
				  <thead>
					<tr>
					  <th class="text-center" width="10%">#</th>
					  <th class="text-center" width="60%">Session/Theme</th>
					  <th class="text-center" width="30%">Total</th>
					</tr>
				  </thead>
				  <tbody>
				  <?php $i=0; foreach($rsTheme as $cn){ $i++;?>
					<tr>
					  <th class="text-center"><?=$i?></th>
					  <td><?=$cn->theme?></td>
					  <td class="text-center"><span datatype="themefull" datavalue="<?=$cn->theme?>" class="btn btn-xs btn-info loadajax2"><?=$cn->total?></span</td>
					</tr>
				  <?php }?>
				  </tbody>
				</table>
				</div>
			</div>
			
			
			
			
			
			
			
			<div class="clearfix"></div>
			<div class="col-md-12">
				<h4><i class="fa fa-list"></i> Member List</h4>	
				<div id="memberLoad">
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover table-condensed">
						<thead class="text-center">
						<tr>
						  <th>#</th>
						  <th>Name</th>
						  <th>Email</th>
						  <th>theme</th>
						  <th>country</th>
						  <th>Presentration</th>
						  <th>File</th>
						  <th>register data</th>
						</tr>
					  </thead>
					  <tbody>
					  <?php $i=0; foreach($rsMemberList as $member){ $i++;?>
						<tr>
						  <th class="text-center"><?=$i?></th>
						  <td><?=$member->title?><?=$member->firstname?> <?=$member->lastname?></td>
						  <td><?=$member->email?></td>
						  <td><?=$member->theme?></td>
						  <td><?=$member->country?></td>
						  <td><?=$member->presentration?></td>
						  <td><a target="_blank" href="<?=base_url()?>uploads/docs/<?=$member->assets_full_file?>" class="btn btn-xs btn-info"><?=$member->assets_full_file?></a></td>
						  <td><?=$member->thaidate?></td>
						</tr>
					  <?php }?>
					  </tbody>
					  </tbody>
					</table>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>


