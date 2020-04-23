<style type="text/css">
    .floatedRight {
            float:right;
    }
</style><?php echo @$header; ?>
	<div class="container" >
		<h2>
			Dashboard	
				
		</h2>
		
		<h2>
			<div id="clock"  onload="startTime" class="floatedRight"></div>
		</h2>
		

	    <div id="cc_menu" class="easyui-layout" style="width:100%;height:85%;">
	        <div id="menunya" data-options="region:'west',title:'Menu',split:true,collapsible:true" style="width:17%;">
        	    <ul id="tree_navigator" class="easyui-tree" data-options="animate:true" url="<?php echo base_url();?>Home/get_menu/"></ul>
	        </div>
	        
	        <div id="content" data-options="region:'center',title:''" style="padding:10px 10px 10px 20px;height:85%">
	        	<?php echo $this->session->flashdata('msg'); ?>
	        			
	        	    <div id="tt" class="easyui-tabs" style="width:100%;height:50%;">
		        		<div title="BBT" style="height:100%;padding:20px;display:none;">
		            		<div id="cc-log-bbt" class="easyui-layout" style="height:100px;width:100%">
    							<div data-options="iconCls:'icon-ess-filter',region:'north',title:'Data BBT yg berhasil diupdate'" style="height:100%;padding:5px;">
								<table>
									<tr>
										<td>Tanggal </td>
										<td style="width: 15px"></td>
										<td>
                        						<input type="text" id="tgl-log-bbt" name="tgl-log-bbt" class="easyui-datebox"  style="width:200px;"></input>
										</td>
										<td colspan="4">
                    						<a id="search-log-bbt" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'" style="width:100px">Search</a>
                     						<a id="clear-log-bbt" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'"style="width:100px">Clear</a>
                						</td>
                						<td>
                							<div id="div_session">
                								<input type="text" id="session-role" name="session-role" class="easyui-textbox" style="width:200px;display:none" value="<?php echo @$role_id; ?>"/>
                							</div>
                						</td>
									</tr>
								</table>
    							</div>
							</div>
	        				<table class="easyui-datagrid" id="data-log-bbt" style="width:100%" ></table>
	      
		       		 	</div>
		        		<div title="BBK" data-options="closable:true" style="overflow:auto;padding:20px;display:none;">
		        			<div id="cc-log-bbk" class="easyui-layout" style="height:100px;width:100%">
    							<div data-options="iconCls:'icon-ess-filter',region:'north',title:'Data BBK yg berhasil diupdate'" style="height:100%;padding:5px;">
								<table>
									<tr>
										<td>Tanggal </td>
										<td style="width: 15px"></td>
										<td>

                        						<input type="text" id="tgl-log-bbk" name="tgl-log-bbk" class="easyui-datebox"  style="width:200px;"></input>
										</td>
										<td colspan="4">
                    						<a id="search-log-bbk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'" style="width:100px">Search</a>
                     						<a id="clear-log-bbk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'"style="width:100px">Clear</a>
                						</td>
									</tr>
								</table>
    							</div>
		            			</div>
	        					<table class="easyui-datagrid" id="data-log-bbk" style="width:100%"></table>
		        		</div>
		        	   </div>
		        		 <div id="t-reject" class="easyui-tabs" style="width:100%;height:50%;">
		        		<div title="BBT" style="height:100%;padding:20px;display:none;">
		            		<div id="cc-log-no-bbt" class="easyui-layout" style="height:100px;width:100%">
    							<div data-options="iconCls:'icon-ess-filter',region:'north',title:'Data BBT yg belum terupdate'" style="height:100%;padding:5px;">
								<table>
									<tr>
										<td>Tanggal </td>
										<td style="width: 15px"></td>
										<td>

                        						<input type="text" id="tgl-log-no-bbt" name="tgl-log-no-bbt" class="easyui-datebox"  style="width:200px;"></input>
										</td>
										<td colspan="4">
                    						<a id="search-log-no-bbt" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'" style="width:100px">Search</a>
                     						<a id="clear-log-no-bbt" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'"style="width:100px">Clear</a>
                						</td>
									</tr>
								</table>
    							</div>
							</div>
	        				<table class="easyui-datagrid" id="data-log-no-bbt" style="width:100%"></table>
		       		 	</div>
		        		<div title="BBK" data-options="closable:true" style="overflow:auto;padding:20px;display:none;">
		        			<div id="cc-log-no-bbk" class="easyui-layout" style="height:100px;width:100%">
    							<div data-options="iconCls:'icon-ess-filter',region:'north',title:'Data BBK yg belum terupdate'" style="height:100%;padding:5px;">
								<table>
									<tr>
										<td>Tanggal </td>
										<td style="width: 15px"></td>
										<td>

                        						<input type="text" id="tgl-log-no-bbk" name="tgl-log-no-bbk" class="easyui-datebox"  style="width:200px;"></input>
										</td>
										<td colspan="4">
                    						<a id="search-log-no-bbk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'" style="width:100px">Search</a>
                     						<a id="clear-log-no-bbk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'"style="width:100px">Clear</a>
                						</td>
									</tr>
								</table>
    							</div>
		            			</div>
	        					<table class="easyui-datagrid" id="data-log-no-bbk" style="width:100%"></table>
		        		</div>
		       
		 
	        </div>	  
		</div>

<div id="loading" style="display:none;">
   			
   						<img src="<?php echo base_url();?>assets/images/fruits-apple.gif" alt="Loading" />
					</div>

	
</div>	


<?php echo @$footer; ?>
<script>
	function replaceAll(str, term, replacement) {
                return str.replace(new RegExp(escapeRegExp(term), 'g'), replacement);
   }
    function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
   }


    function doSearchLogBBT() {
                var tanggal_mulai = replaceAll($("#tgl-log-bbt").datebox('getValue'), "/", "-");
                var res = tanggal_mulai.substr(6, 4) + '-' + tanggal_mulai.substr(3, 2) + '-' + tanggal_mulai.substr(0, 2);
                
                $('#data-log-bbt').datagrid('load', {
                                tgl_log_bbt: res
                });

   }
    function doSearchLogBBK() {
                var tanggal_mulai = replaceAll($("#tgl-log-bbk").datebox('getValue'), "/", "-");
                var res = tanggal_mulai.substr(6, 4) + '-' + tanggal_mulai.substr(3, 2) + '-' + tanggal_mulai.substr(0, 2);
                
                $('#data-log-bbk').datagrid('load', {
                                tgl_log_bbk: res
                });

   }
    function doSearchLogNoBBT() {
                var tanggal_mulai = replaceAll($("#tgl-log-no-bbt").datebox('getValue'), "/", "-");
                var res = tanggal_mulai.substr(6, 4) + '-' + tanggal_mulai.substr(3, 2) + '-' + tanggal_mulai.substr(0, 2);
                
                $('#data-log-no-bbt').datagrid('load', {
                                tgl_log_no_bbt: res
                });

   }
    function doSearchLogNoBBK() {
                var tanggal_mulai = replaceAll($("#tgl-log-no-bbk").datebox('getValue'), "/", "-");
                var res = tanggal_mulai.substr(6, 4) + '-' + tanggal_mulai.substr(3, 2) + '-' + tanggal_mulai.substr(0, 2);
                
                $('#data-log-no-bbk').datagrid('load', {
                                tgl_log_no_bbk: res
                });

   }
	function startTime() {
		    var today = new Date();
		    var month_names =["January","February","March",
                      "April","May","Juny",
                      "July","August","September",
                      "October","November","December"];
			var dd = today.getDate();
			var mm = today.getMonth(); //January is 0!
			var yyyy = today.getFullYear();
			var h = today.getHours();
		    var m = today.getMinutes();
		    var s = today.getSeconds();
		    m = checkTime(m);
		    s = checkTime(s);
			today = dd + '  ' + month_names[mm] + '  ' + yyyy;
		    
		    document.getElementById('clock').innerHTML =
		    today +' '+h + ":" + m + ":" + s;
		    var t = setTimeout(startTime, 500);
	}
	function checkTime(i) {
    		if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    		return i;
	}
    
   $("#data-log-bbt").datagrid({
				url: 'Ulok/get_data_log_bbt/',
				striped: true,
				rownumbers: true,
				remoteSort: true,
				singleSelect: false,
				pageSize:5,
				pageList:[5,10,15,20],
				pagination: true,
				fit: false,
				autoRowHeight: false,
				fitColumns: true,
				columns: [[{
							field: 'FORM_NUM',
							title: 'No Form',
							width: 150,
							align: "center",
							halign: "center"
						},{
							field: 'BBT_NUM',
							title: 'No BBT',
							width: 150,
							align: "center",
							halign: "center"
						},{
                            field: 'BBT_DATE',
                            title: 'Tanggal BBT',
                            width: 150,
                            align: "center",
                            halign: "center",
                            formatter: function(value, row, index) {
                                if (value != null) {
                                    var date = new Date(value.substring(0, 4) + '-' + value.substring(5, 7) + '-' + value.substring(8, 10));
                                    options = {
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric'                                                              
                                              };
                                    return Intl.DateTimeFormat('id-ID', options).format(date);
                                } else {
                                          	return "";
                                       }
                            }
                        },{
                            field: 'BBT_AMOUNT',
                            title: 'Amount',
                            width: 150,
                            align: "right",
                            halign: "center",
                            formatter: function(value, row, index) {
                                if (value == null) {
                                    return "";
                                } else {
                                    return accounting.formatNumber(value);
                                 }
                            }
                        }

			]]
	});


   
	$("#data-log-bbk").datagrid({
				url: 'Ulok/get_data_log_bbk/',
				striped: true,
				rownumbers: true,
				remoteSort: true,
				singleSelect: false,
				pagination: true,
				pageSize:5,
				pageList:[5,10,15,20],
				fit: false,
				autoRowHeight: false,
				fitColumns: true,
				columns: [[{
							field: 'FORM_NUM',
							title: 'No Form',
							width: 150,
							align: "center",
							halign: "center"
						},{
							field: 'BBK_NUM',
							title: 'No BBK',
							width: 150,
							align: "center",
							halign: "center"
						},{
                            field: 'BBK_DATE',
                            title: 'Tanggal BBK',
                            width: 150,
                            align: "center",
                            halign: "center",
                            formatter: function(value, row, index) {
                                if (value != null) {
                                    var date = new Date(value.substring(0, 4) + '-' + value.substring(5, 7) + '-' + value.substring(8, 10));
                                    options = {
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric'                                                              
                                              };
                                    return Intl.DateTimeFormat('id-ID', options).format(date);
                                } else {
                                          	return "";
                                       }
                            }
                        },{
                            field: 'BBK_AMOUNT',
                            title: 'Amount',
                            width: 150,
                            align: "right",
                            halign: "center",
                            formatter: function(value, row, index) {
                                if (value == null) {
                                    return "";
                                } else {
                                    return accounting.formatNumber(value);
                                 }
                            }
                        }

			]]
	});
	$("#data-log-no-bbk").datagrid({
				url: 'Ulok/get_data_log_no_bbk/',
				striped: true,
				rownumbers: true,
				remoteSort: true,
				singleSelect: false,
				pagination: true,
				pageSize:5,
				pageList:[5,10,15,20],
				fit: false,
				autoRowHeight: false,
				fitColumns: true,
				columns: [[{
							field: 'FORM_NUM',
							title: 'No Form',
							width: 150,
							align: "center",
							halign: "center"
						}
			]]
	}); 

	$("#data-log-no-bbt").datagrid({
				url: 'Ulok/get_data_log_no_bbt/',
				striped: true,
				rownumbers: true,
				remoteSort: true,
				singleSelect: false,
				pagination: true,
				pageSize:5,
				pageList:[5,10,15,20],
				fit: false,
				autoRowHeight: false,
				fitColumns: true,
				columns: [[{
							field: 'FORM_NUM',
							title: 'No Form',
							width: 150,
							align: "center",
							halign: "center"
						}
			]]
	}); 

$(document).ready(function() {
	if($('#session-role').textbox('getValue')!='3' && $('#session-role').textbox('getValue') !='5' && $('#session-role').textbox('getValue')!='1'){

		$('#tt').hide();
		$('#t-reject').hide();
	}else{
		$('#div_session').hide();
	}
$("#clear-log-bbt").click(function(event) {
                                event.preventDefault();
                                $('#tgl-log-bbt').datebox('setValue', '');
                                $('#data-log-bbt').datagrid('load', {
                                	tgl_log_bbt: null
                				});

                });
$("#clear-log-bbk").click(function(event) {
                                event.preventDefault();
                                $('#tgl-log-bbk').datebox('setValue', '');
                                $('#data-log-bbk').datagrid('load', {
                                	tgl_log_bbk: null
                				});

                });
$("#clear-log-no-bbt").click(function(event) {
                                event.preventDefault();
                                $('#tgl-log-no-bbt').datebox('setValue', '');
                                $('#data-log-no-bbt').datagrid('load', {
                                	tgl_log_no_bbt: null
                				});

                });
$("#clear-log-no-bbk").click(function(event) {
                                event.preventDefault();
                                $('#tgl-log-no-bbk').datebox('setValue', '');
                                $('#data-log-no-bbk').datagrid('load', {
                                	tgl_log_no_bbk: null
                				});

                });


$("#search-log-bbk").click(function(event) {
                                event.preventDefault();
                                if($('#tgl-log-bbk').datebox('getValue') ==''){
                                	  $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
                                }else {
                                	doSearchLogBBK();
                                }

                });
$("#search-log-bbt").click(function(event) {
                                event.preventDefault();
                                if($('#tgl-log-bbt').datebox('getValue') ==''){
                                	  $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
                                }else {
                                	doSearchLogBBT();
                                }

                });
$("#search-log-no-bbk").click(function(event) {
                                event.preventDefault();
                                if($('#tgl-log-no-bbk').datebox('getValue') ==''){
                                	  $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
                                }else {
                                	doSearchLogNoBBK();
                                }

                });
$("#search-log-no-bbt").click(function(event) {
                                event.preventDefault();
                                if($('#tgl-log-no-bbt').datebox('getValue') ==''){
                                	  $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
                                }else {
                                	doSearchLogNoBBT();
                                }

                });
 $('#tgl-log-bbt').datebox({
                                formatter: function(date) {
                                                var y = date.getFullYear();
                                                var m = date.getMonth() + 1;
                                                var d = date.getDate();
                                                return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
                                },
                                parser: function(s) {
                                                if (!s) return new Date();
                                                var ss = s.split('-');
                                                var y = parseInt(ss[0], 10);
                                                var m = parseInt(ss[1], 10);
                                                var d = parseInt(ss[2], 10);
                                                if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                                                                return new Date(d, m - 1, y);
                                                } else {
                                                                return new Date();
                                                }
                                }
                });
 $('#tgl-log-bbk').datebox({
                                formatter: function(date) {
                                                var y = date.getFullYear();
                                                var m = date.getMonth() + 1;
                                                var d = date.getDate();
                                                return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
                                },
                                parser: function(s) {
                                                if (!s) return new Date();
                                                var ss = s.split('-');
                                                var y = parseInt(ss[0], 10);
                                                var m = parseInt(ss[1], 10);
                                                var d = parseInt(ss[2], 10);
                                                if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                                                                return new Date(d, m - 1, y);
                                                } else {
                                                                return new Date();
                                                }
                                }
                });
$('#tgl-log-no-bbk').datebox({
                                formatter: function(date) {
                                                var y = date.getFullYear();
                                                var m = date.getMonth() + 1;
                                                var d = date.getDate();
                                                return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
                                },
                                parser: function(s) {
                                                if (!s) return new Date();
                                                var ss = s.split('-');
                                                var y = parseInt(ss[0], 10);
                                                var m = parseInt(ss[1], 10);
                                                var d = parseInt(ss[2], 10);
                                                if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                                                                return new Date(d, m - 1, y);
                                                } else {
                                                                return new Date();
                                                }
                                }
                });
$('#tgl-log-no-bbt').datebox({
                                formatter: function(date) {
                                                var y = date.getFullYear();
                                                var m = date.getMonth() + 1;
                                                var d = date.getDate();
                                                return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
                                },
                                parser: function(s) {
                                                if (!s) return new Date();
                                                var ss = s.split('-');
                                                var y = parseInt(ss[0], 10);
                                                var m = parseInt(ss[1], 10);
                                                var d = parseInt(ss[2], 10);
                                                if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                                                                return new Date(d, m - 1, y);
                                                } else {
                                                                return new Date();
                                                }
                                }
                });

});
</script>

