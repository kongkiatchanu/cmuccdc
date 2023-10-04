<?php
include 'config.php';

$sql = "UPDATE forum_topic SET is_show = '".mysqli_escape_string($mysqli,$_POST["is_show"])."'
			  WHERE topic_id = '".mysqli_escape_string($mysqli,$_POST["id"])."'";

$q = $mysqli->query($sql);

if($_POST["is_show"]) : ?>
	<a href="#<?php echo $_POST["id"]; ?>" class="topic_status_off btn btn-success btn-xs">แสดง</a>
<?php else : ?>
	<a href="#<?php echo $_POST["id"]; ?>" class="topic_status_on btn btn-default btn-xs">ซ่อน</a>
<?php endif; ?>