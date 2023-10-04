<?php
	include 'config.php';

	$type 		= mysqli_real_escape_string($mysqli,$_GET['type']);
	$filter 		= mysqli_real_escape_string($mysqli,$_GET['filter']);
?>
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
						  <th>Status</th>
						  <th></th>
						</tr>
			</thead>
			<tbody>
			</tbody>


<?php			
	if ($type=="theme"){

		$sql="SELECT * FROM member_db 
		WHERE theme = '{$filter}' order by created_date desc";
		$q=$mysqli->query($sql);
		$i=0;
		while($rs=$q->fetch_assoc()){$i++;
			
			$sql2= "SELECT * FROM `member_assets` WHERE `assets_member_id` = ".$rs["member_id"]; 
			$q2=$mysqli->query($sql2);
			$rs2=$q2->fetch_assoc();
		
			?>
		
			<tr>
						  <th class="text-center"><?=$i?></th>
						  <td><?=$rs["title"]?><?=$rs["firstname"]?> <?=$rs["lastname"]?></td>
						  <td><?=$rs["email"]?></td>
						  <td><mark><?=$rs["theme"]?></mark></td>
						  <td><?=$rs["country"]?></td>
						  <td><?=$rs["presentration"]?></td>
						  <td><a target="_blank" href="<?=BASE_URL?>uploads/docs/<?=$rs2["assets_abstract_file"]?>" class="btn btn-xs btn-info"><?=$rs2["assets_abstract_name"]?></a></td>
						  <td>
							<?php 
								if($rs2["assets_abstract_status"]==-1){
									echo '<span class="btn btn-danger btn-xs">Fail</span>';
								}else if($rs2["assets_abstract_status"]==0){
									echo '<span class="btn btn-info btn-xs">Waiting for inspection</span>';
								}else if($rs2["assets_abstract_status"]==1){
									echo '<span class="btn btn-success btn-xs">Approve</span>';
								}
							  ?>  
							</td>
							<td><a href="/rhccm2017/admin/abstactpaper/view/<?=$rs["member_id"]?>" class="btn btn-primary btn-xs">Edit</a></td>
			</tr>
<?php			
		}
	}
?>

<?php			
	if ($type=="status"){

		$sql="SELECT * FROM member_db 
		left join member_assets on member_db.member_id=member_assets.assets_member_id
		WHERE member_assets.assets_abstract_status = '{$filter}'";
		$q=$mysqli->query($sql);
		$i=0;
		while($rs=$q->fetch_assoc()){$i++;
			
			?>
		
			<tr>
						  <th class="text-center"><?=$i?></th>
						  <td><?=$rs["title"]?><?=$rs["firstname"]?> <?=$rs["lastname"]?></td>
						  <td><?=$rs["email"]?></td>
						  <td><?=$rs["theme"]?></td>
						  <td><?=$rs["country"]?></td>
						  <td><?=$rs["presentration"]?></td>
						  <td><a target="_blank" href="<?=BASE_URL?>uploads/docs/<?=$rs["assets_abstract_file"]?>" class="btn btn-xs btn-info"><?=$rs["assets_abstract_name"]?></a></td>
						  <td>
							<?php 
								if($rs["assets_abstract_status"]==-1){
									echo '<span class="btn btn-danger btn-xs">Fail</span>';
								}else if($rs["assets_abstract_status"]==0){
									echo '<span class="btn btn-info btn-xs">Waiting for inspection</span>';
								}else if($rs["assets_abstract_status"]==1){
									echo '<span class="btn btn-success btn-xs">Approve</span>';
								}
							  ?>  
							</td>
							<td><a href="/rhccm2017/admin/abstactpaper/view/<?=$rs["member_id"]?>" class="btn btn-primary btn-xs">Edit</a></td>
			</tr>
<?php			
		}
	}
?>

<?php			
	if ($type=="themefull"){

		$sql="SELECT *, DATE_FORMAT(created_date, '%d %M %Y %H:%i') as thaidate FROM member_db 
		WHERE theme = '{$filter}' order by created_date desc";
		$q=$mysqli->query($sql);
		$i=0;
		while($rs=$q->fetch_assoc()){$i++;
			
			$sql2= "SELECT * FROM `member_assets` WHERE `assets_member_id` = ".$rs["member_id"]; 
			$q2=$mysqli->query($sql2);
			$rs2=$q2->fetch_assoc();
		
			?>
		
			<tr>
						  <th class="text-center"><?=$i?></th>
						  <td><?=$rs["title"]?><?=$rs["firstname"]?> <?=$rs["lastname"]?></td>
						  <td><?=$rs["email"]?></td>
						  <td><mark><?=$rs["theme"]?></mark></td>
						  <td><?=$rs["country"]?></td>
						  <td><?=$rs["presentration"]?></td>
						  <td><a target="_blank" href="<?=BASE_URL?>uploads/docs/<?=$rs2["assets_full_file"]?>" class="btn btn-xs btn-info"><?=$rs2["assets_full_name"]?></a></td>
						  <td>
							<?php 
								if($rs2["assets_full_status"]==-1){
									echo '<span class="btn btn-danger btn-xs">Fail</span>';
								}else if($rs2["assets_full_status"]==0){
									echo '<span class="btn btn-info btn-xs">Waiting for inspection</span>';
								}else if($rs2["assets_full_status"]==1){
									echo '<span class="btn btn-success btn-xs">Approve</span>';
								}
							  ?>  
							</td>
							<td><a href="/rhccm2017/admin/fullpaper/view/<?=$rs["member_id"]?>" class="btn btn-primary btn-xs">Edit</a></td>
			</tr>
<?php			
		}
	}
?>





			</tbody>
		</table>
	</div>