<div class="main-header row">
    <div class="col-12 col-md-12">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-12">
        <form class="form-inline custom-form" role="form" method="get">
            <div class="form-group mr-3">
                <label class="sr-only" for="exampleInputEmail2">web id</label>
                <input type="text" name="webid" class="form-control" id="exampleInputEmail2" placeholder="input webid" value="<?=$this->input->get('webid')?>" required>
            </div>
            <div class="form-group mr-3">
                <label class="sr-only" for="exampleInputPassword2">table</label>
                <select class="form-control" name="tb" required>
                    <option value=""></option>
                    <option value="log_mini_2561" <?=$this->input->get('tb')=="log_mini_2561"?'selected':''?>>log_mini_2561</option>
                    <option value="log_data_2562" <?=$this->input->get('tb')=="log_data_2562"?'selected':''?>>log_data_2562</option>
                    <option value="log_mini_2561_2562" <?=$this->input->get('tb')=="log_mini_2561_2562"?'selected':''?>>log_mini_2561_2562</option>
                    <option value="log_mini_2561_sep2021" <?=$this->input->get('tb')=="log_mini_2561_sep2021"?'selected':''?>>log_mini_2561_sep2021</option>
                    <option value="log_wplus" <?=$this->input->get('tb')=="log_wplus"?'selected':''?>>log_wplus</option>
                    <option value="log_zdata" <?=$this->input->get('tb')=="log_zdata"?'selected':''?>>log_zdata</option>
                </select>
            </div>
			<div class="form-group mr-3">
                <label class="sr-only" for="">start date</label>
                <input type="text" name="start_date" class="form-control export_date" id="" placeholder="start date" value="<?=$this->input->get('start_date')?>">
            </div>
			<div class="form-group mr-3">
                <label class="sr-only" for="">end date</label>
                <input type="text" name="end_date" class="form-control export_date" id="" placeholder="end date" value="<?=$this->input->get('end_date')?>">
            </div>
            <button type="submit" class="btn btn-custom btn-bg-color">Query!</button>
			<?php if($rsList!=null){?>
			<?php 
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$export_url = str_replace("dbdata","export_dbdata",$actual_link);
			$export_url_json = str_replace("dbdata","export_dbdata_json",$actual_link);
			?>
            <a href="<?=$export_url?>" target="_blank" class="btn btn-custom ml-2 btn-bg-color">export excel</a>
            <a href="<?=$export_url_json?>" target="_blank" class="btn btn-custom ml-2 btn-bg-color">export json</a>
			
			<?php }?>
        </form>
    </div>
</div>
<div class="main-body">
    <div class="table-responsive mb-5">
        <table id="table-test" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header">source id</td>
                    <td class="table-header">nickname</td>
                    <td class="table-header">pm25</td>
                    <td class="table-header">pm10</td>
                    <td class="table-header">temp</td>
                    <td class="table-header">humid</td>
                    <td class="table-header">datetime</td>
                    <td class="table-header">ip</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
                    <tr class="table-row-detail">
                        <td class="table-detail text-center"><?=$value->source_id?></td>
                        <td class="table-detail"><?=$value->nickname?></td>
                        <td class="table-detail text-center"><?=$value->log_pm25?></td>
                        <td class="table-detail text-center"><?=$value->log_pm10?></td>
                        <td class="table-detail text-center"><?=$value->temp?></td>
                        <td class="table-detail text-center"><?=$value->humid?></td>
                        <td class="table-detail"><?=$value->log_datetime?></td>
                        <td class="table-detail"><?=$value->source_ip?></td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>