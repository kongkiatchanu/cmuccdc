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
						  <th>register data</th>
						</tr>
			</thead>
			<tbody>
			</tbody>
<?php			
	if ($type=="country"){

		$sql="SELECT *, DATE_FORMAT(created_date, '%d %M %Y %H:%i') as thaidate FROM member_db WHERE country = '{$filter}' order by created_date desc";
		$q=$mysqli->query($sql);
		$i=0;
		while($rs=$q->fetch_assoc()){$i++;?>
		
			<tr>
						  <th class="text-center"><?=$i?></th>
						  <td><?=$rs["title"]?><?=$rs["firstname"]?> <?=$rs["lastname"]?></td>
						  <td><?=$rs["email"]?></td>
						  <td><?=$rs["theme"]?></td>
						  <td><mark><?=$rs["country"]?></mark></td>
						  <td><?=$rs["presentration"]?></td>

						  <td><?=$rs["thaidate"]?></td>
			</tr>
<?php			
		}
	}
?>

<?php			
	if ($type=="theme"){

		$sql="SELECT *, DATE_FORMAT(created_date, '%d %M %Y %H:%i') as thaidate FROM member_db WHERE theme = '{$filter}' order by created_date desc";
		$q=$mysqli->query($sql);
		$i=0;
		while($rs=$q->fetch_assoc()){$i++;?>
		
			<tr>
						  <th class="text-center"><?=$i?></th>
						  <td><?=$rs["title"]?><?=$rs["firstname"]?> <?=$rs["lastname"]?></td>
						  <td><?=$rs["email"]?></td>
						  <td><mark><?=$rs["theme"]?></mark></td>
						  <td><?=$rs["country"]?></td>
						  <td><?=$rs["presentration"]?></td>

						  <td><?=$rs["thaidate"]?></td>
			</tr>
<?php			
		}
	}
?>

<?php			
	if ($type=="food_type"){

		$sql="SELECT *, DATE_FORMAT(created_date, '%d %M %Y %H:%i') as thaidate FROM member_db WHERE food_type = '{$filter}' order by created_date desc";
		$q=$mysqli->query($sql);
		$i=0;
		while($rs=$q->fetch_assoc()){$i++;?>
		
			<tr>
						  <th class="text-center"><?=$i?></th>
						  <td><?=$rs["title"]?><?=$rs["firstname"]?> <?=$rs["lastname"]?></td>
						  <td><?=$rs["email"]?></td>
						  <td><?=$rs["theme"]?></td>
						  <td><?=$rs["country"]?></td>
						  <td><?=$rs["presentration"]?></td>
						  <td><?=$rs["thaidate"]?></td>
			</tr>
<?php			
		}
	}
?>

<?php			
	if ($type=="presentration"){

		$sql="SELECT *, DATE_FORMAT(created_date, '%d %M %Y %H:%i') as thaidate FROM member_db WHERE presentration = '{$filter}' order by created_date desc";
		$q=$mysqli->query($sql);
		$i=0;
		while($rs=$q->fetch_assoc()){$i++;?>
		
			<tr>
						  <th class="text-center"><?=$i?></th>
						  <td><?=$rs["title"]?><?=$rs["firstname"]?> <?=$rs["lastname"]?></td>
						  <td><?=$rs["email"]?></td>
						  <td><?=$rs["theme"]?></td>
						  <td><?=$rs["country"]?></td>
						  <td><mark><?=$rs["presentration"]?></mark></td>
						  <td><?=$rs["thaidate"]?></td>
			</tr>
<?php			
		}
	}
?>




			</tbody>
		</table>
	</div>