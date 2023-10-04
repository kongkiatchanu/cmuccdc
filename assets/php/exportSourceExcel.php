<?php
	error_reporting(E_ALL);

	include "/home/dev2/public_html/assets/php/connect.php";
	$data = array();
	$sql= 'SELECT * FROM `source` ORDER BY `source_id` ASC ';
	$q=$mysqli->query($sql);
	while($rs = $q->fetch_assoc()){
		array_push($data, $rs);
	}
	header("Content-type: application/vnd.ms-excel");
// header('Content-type: application/csv'); //*** CSV ***//
header("Content-Disposition: attachment; filename=testing.xls");
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>
<table>
	<thead>
		<tr>
			<th>source_id</th>
			<th>location_id</th>
			<th>location_name</th>
			<th>location_name_en</th>
			<th>location_lat</th>
			<th>location_lon</th>
			<th>location_status</th>
			<th>location_uri</th>
			<th>is_cnx</th>
			<th>is_hospital</th>
			<th>source_province_id</th>
			<th>version</th>
			<th>db_model</th>
			<th>db_co</th>
			<th>db_mobile</th>
			<th>db_email</th>
			<th>db_addr</th>
			<th>db_status</th>
			<th>db_status_fixed</th>
			<th>db_status_install</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($data as $item){?>
		<tr>
			<td><?=$item['source_id']?></td>
			<td><?=$item['location_id']?></td>
			<td><?=$item['location_name']?></td>
			<td><?=$item['location_name_en']?></td>
			<td><?=$item['location_lat']?></td>
			<td><?=$item['location_lon']?></td>
			<td><?=$item['location_status']?></td>
			<td><?=$item['location_uri']?></td>
			<td><?=$item['is_cnx']?></td>
			<td><?=$item['is_hospital']?></td>
			<td><?=$item['source_province_id']?></td>
			<td><?=$item['version']?></td>
			<td><?=$item['db_model']?></td>
			<td><?=$item['db_co']?></td>
			<td><?=$item['db_mobile']?></td>
			<td><?=$item['db_email']?></td>
			<td><?=$item['db_addr']?></td>
			<td><?=$item['db_status']?></td>
			<td><?=$item['db_status_fixed']?></td>
			<td><?=$item['db_status_install']?></td>
			
		</tr>
	<?php }?>
	</tbody>
</table>
	
</body>
</html>