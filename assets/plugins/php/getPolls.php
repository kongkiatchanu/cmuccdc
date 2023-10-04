<?php 
include 'config.php';
?>
<?php 
if(!$_POST['poll'] || !$_POST['pollid']){
    $sql="SELECT id, ques FROM poll_questions where is_show=1 ORDER BY id DESC LIMIT 1";
	$query=$mysqli->query($sql);
	while($row=$query->fetch_assoc()){
		//display question
		echo "<p class=\"pollques\" ><strong>".$row['ques']."</strong></p>";
		$poll_id=$row['id'];
	}
	if($_GET["result"]==1 || $_COOKIE["voted".$poll_id]=='yes'){

		//if already voted or asked for result
		showresults($poll_id);
		exit;
	}
	else{
	//display options with radio buttons
		$sql ="SELECT option_id, value FROM poll_options WHERE ques_id=$poll_id";
		$query=$mysqli->query($sql);
		if($query->num_rows){
			echo '<div id="formcontainer" ><form method="post" id="pollform" action="'.$_SERVER['PHP_SELF'].'" >';
			echo '<input type="hidden" name="pollid" value="'.$poll_id.'" />';
			while($row=$query->fetch_assoc()){
				echo '<p><input type="radio" name="poll" value="'.$row['option_id'].'" id="option-'.$row['option_id'].'" /> 
				<label for="option-'.$row['option_id'].'" >'.$row['value'].'</label></p>';
			}
			echo '<p><button type="submit" class="btn btn-success btn-vote">โหวต</button></p></form>';
			echo '<p><a href="'.$_SERVER['PHP_SELF'].'?result=1" id="viewresult">ดูผลโหวต</a></p></div>';
		}
	}
}
else{
	if($_COOKIE["voted".$_POST['pollid']]!='yes'){
		
		//Check if selected option value is there in database?
		$sql="SELECT * FROM poll_options WHERE option_id='".intval($_POST["poll"])."'";
		$query=$mysqli->query($sql);
		if($query->num_rows){
			$sql2="INSERT INTO poll_votes(option_id, voted_on, ip) VALUES('".$_POST["poll"]."', '".date('Y-m-d H:i:s')."', '".$_SERVER['REMOTE_ADDR']."')";
			if($mysqli->query($sql2))
			{
				//Vote added to database
				setcookie("voted".$_POST['pollid'], 'yes', time()+86400*300);				
			}
			else
				echo "There was some error processing the query: ".mysql_error();
		}
	}
	showresults(intval($_POST['pollid']));
}

function showresults($poll_id){
	global $mysqli;
	$sql="SELECT COUNT(*) as totalvotes FROM poll_votes WHERE option_id IN(SELECT option_id FROM poll_options WHERE ques_id='$poll_id')";
	$query=$mysqli->query($sql);
	$row=$query->fetch_assoc();
	$total=$row['totalvotes'];
	$sql="SELECT poll_options.option_id, poll_options.value, COUNT(*) as votes FROM poll_votes, poll_options WHERE poll_votes.option_id=poll_options.option_id AND poll_votes.option_id IN(SELECT option_id FROM poll_options WHERE ques_id='$poll_id') GROUP BY poll_votes.option_id";

	$query=$mysqli->query($sql);
	while($row=$query->fetch_assoc()){
			$percent=($row['votes']*100)/$total;?>
			<div class="option">
                <h5><?php echo $row['value'];?></h5>
                <p><?php echo number_format($percent,1);?>% (<?php echo $row['votes'];?> votes)</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo number_format($percent);?>" aria-valuemin="0" aria-valuemax="100" animate="<?php echo number_format($percent);?>">
                    </div>
                </div>
            </div>
			<!--
			echo '<div class="option" ><p>'.$row['value'].' (<em>'.$percent.'%, '.$row['votes'].' votes</em>)</p>';
			echo '<div class="bar ';
			if($_POST['poll']==$row['id']) echo ' yourvote';
			echo '" style="width: '.$percent.'%; " ></div></div>';-->
			<?php
		}
	echo '<p>จำนวนผู้โหวตทั้งหมด : '.$total.' ท่าน</p>';
	if($_GET["result"]==1){
		echo '<p><a style="cursor:pointer;" id="viewvote">กลับไปยังหน้าโหวต</a></p>';
	}
}

?>
