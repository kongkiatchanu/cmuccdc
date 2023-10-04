<?php
	include 'config.php';

	$type=$_GET['type'];
	
	if($type=='ib'){
		$sql="SELECT count(idcontact) as total_row  FROM  contact  WHERE  contact_view  = 0";
		$q=$mysqli->query($sql);
		$row=$q->fetch_assoc();
		echo $row['total_row'];
	}
	
	if($type=='ibl'){
		$sql="SELECT * FROM  contact ORDER BY  contact . contact_datetime  DESC limit 3";
		$q=$mysqli->query($sql);
		while($row=$q->fetch_assoc()){?>
			<li>
				<a href="<?=BASE_URL?>admin/contact/view/<?=$row['idcontact']?>">
					<span class="subject">
						<span class="from"><?=$row['contact_name']?></span>
						<span class="time"><?=get_time_ago(strtotime($row['contact_datetime']))?></span>
					</span>
					<span class="message">
						<?=mb_substr($row['contact_message'],0,100,'utf-8')?>
					</span>
				</a>
			</li>
		<?php	
		}
	}
?>