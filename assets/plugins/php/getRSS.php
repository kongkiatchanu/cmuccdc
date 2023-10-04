<?php isset($_GET['limit']) ? $limit = $_GET['limit'] : $limit = 50;?>
<div class="list-box">
<table class="table table-striped">
        <thead>
            <tr>
                <th class="col-sm-8 text-center">รายการ</th>
                <th class="col-sm-2 text-center">หน่วยงาน</th>
                <?php if($limit!=10){?>
                <th class="col-sm-2 text-center">เลขที่หนังสือ</th>
                <th class="col-sm-2 text-center">หนังสือลงวันที่</th>
                <?php }?>
            </tr>
        </thead>
        <tbody>

<?php 
$url = "http://www.dla.go.th/servlet/RssServlet";
$xml = simplexml_load_file($url);

$json = json_encode($xml);
$array = json_decode($json,TRUE);
$i=0;

foreach($array['DOCUMENT'] as $rs){
    $i++;
    if($i<=$limit){
        $DOCUMENT_TOPIC = $rs['DOCUMENT_TOPIC'];
        $ORG            = $rs['ORG'];
        $DOCUMENT_NO    = $rs['DOCUMENT_NO'];
        $DOCUMENT_DATE  = $rs['DOCUMENT_DATE'];
        $UPLOAD_FILE1   = $rs['UPLOAD_FILE1'];
        $UPLOAD_FILE2   = $rs['UPLOAD_FILE2'];
        $UPLOAD_DESC2   = $rs['UPLOAD_DESC2'];
        $UPLOAD_FILE3   = $rs['UPLOAD_FILE3'];
        $UPLOAD_DESC3   = $rs['UPLOAD_DESC3'];
        $UPLOAD_FILE4   = $rs['UPLOAD_FILE4'];
        $UPLOAD_DESC4   = $rs['UPLOAD_DESC4'];
        ?>
        <tr>
            <td>
                <i class="fa fa-file-text-o" aria-hidden="true"></i><a href="<?php echo $UPLOAD_FILE1;?>" target="_blank"> <?php echo $DOCUMENT_TOPIC;?></a>
                <?php if($UPLOAD_FILE2!=null){?>
                    <br/>
                    [<a href="<?php echo $UPLOAD_FILE2;?>" target="_blank"><?php echo $UPLOAD_DESC2;?></a>]
                <?php }?>
                <?php if($UPLOAD_FILE3!=null){?>
                    [<a href="<?php echo $UPLOAD_FILE3;?>" target="_blank"><?php echo $UPLOAD_DESC3;?></a>]
                <?php }?>
                <?php if($UPLOAD_FILE4!=null){?>
                    [<a href="<?php echo $UPLOAD_FILE4;?>" target="_blank"><?php echo $UPLOAD_DESC4;?></a>]
                <?php }?>
            </td>
            <td class="text-center"><?php echo $ORG;?></td>
            <?php if($limit!=10){?>
            <td class="text-center"><?php echo $DOCUMENT_NO;?></td>
            <td class="text-center"><?php echo $DOCUMENT_DATE;?></td>
            <?php }?>
        </tr>
    <?php
    }
}
?>
        </tbody>
</table>
</div>