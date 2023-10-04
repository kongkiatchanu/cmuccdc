<?php
include 'config.php';

$sql="SELECT * FROM od_article WHERE 
	article_".mysqli_real_escape_string($mysqli,$_REQUEST['type'])." LIKE '%".mysqli_real_escape_string($mysqli,$_REQUEST['term'])."%'
	AND article_status = 1
	ORDER BY article_title ASC";

$query = $mysqli->query($sql);

while($row = $query->fetch_assoc())
{
	$results[] = array(
		'label' => $row['article_'.mysqli_real_escape_string($mysqli,$_REQUEST['type'])],
		'code' => $row['article_id']
		);
}

echo json_encode($results);

?>
