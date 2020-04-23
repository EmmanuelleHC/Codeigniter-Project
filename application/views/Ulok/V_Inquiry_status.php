<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ulok.inq.js"></script>
<style type="text/css">
    .textbox-readonly .textbox-text{
        background: #DEDEDE;
    }
    #wizard .content {
        min-height: 100px;
    }
    #wizard .content > .body {
        width: 100%;
        height: auto;
        padding: 15px;
        position: relative;
    }
    .floatedRight {
            float:right;
    }
</style>
<div>
	<h2>Log Status</h2>
	<hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>

<div id="inq-log-status" class="easyui-layout" style="height:150px;width:100%">
    <div data-options="iconCls:'icon-ess-filter',region:'north',title:'Filter'" style="height:150px;padding:5px;">
        <table>
            <tr>
                <td>No. Form</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-no-form-status" name="search-no-form-status" class="easyui-textbox" style="width:215px;height:30px" ></input>
                </td>
            
                <td colspan="3">
                    <a id="search-inq-status" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'" style="height:30px;">Search</a>
                  
                    <a id="clear-inq-status" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="height:30px;">Clear</a>
                </td>
            </tr>
        </table>
    </div>
</div>
<div id="cc-log-status" class="easyui-layout" style="height:357px;width:100%">
     <div data-options="region:'north',title:'Log Status'" style="height:357px;padding:5px;">
        <div style="float:left;display: block;">
        </div>
        <div style="float:right;display: block;"> 
        </div>
        <br><br>
        <hr>
       <!--   <table  id="data-log-status"style=";width:100%"></table>-->
    </div>
 
</div> 

<div id="modal-detail-status" style="display:none; width:1200px; height:auto; "class="easyui-window" title="DETAIL STATUS ULOK/TO " data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="list-detail-status">
      <!--    <table id="data-list-detail-status"style=";width:100%"></table>-->
    </div>
</div>

