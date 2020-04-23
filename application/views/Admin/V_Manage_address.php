<script type="text/javascript" src="<?php echo base_url();?>assets/js/admin.js"></script>
<style type="text/css">

</style>
<div style="margin:20px 0;"></div>
    <div class="easyui-panel" title="Master Address" style="width:50%;padding:30px 60px;">
        <form method="post" id="import_csv" enctype="multipart/form-data">
            <div style="margin-bottom:20px">
                <input name="csv_file" id="csv_file" class="easyui-filebox"  labelPosition="top" data-options="prompt:'Choose a file...'"  accept=".csv" style="width:100%">
            </div>
            <div>
                <a id="submit-upload-master-address" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;width:100%">Upload</a>
            </div>
            <br>
            <div>
                <a id="submit-download-format-address" href="#" class="easyui-linkbutton"  style="font-weight: bold;font-size:50px;height:30px;width:100%">Download Format File</a>
            </div>
            <br>
            <div  id="loader-icon" style="display:none;"><img src="<?php echo base_url();?>assets\images\LoaderIcon.gif" style="height: 50px; width: 100px;"></div>
            <span>Penamaan File upload : MASTER_WILAYAH.csv</span>
        </form>
    </div>

