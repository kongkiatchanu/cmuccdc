
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
    