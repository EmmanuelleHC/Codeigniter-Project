$("#data-log-bbt").datagrid({
				url: 'Ulok/get_data_log_status/',
				striped: true,
				rownumbers: true,
				remoteSort: true,
				singleSelect: false,
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
												}, {
																field: 'action',
																title: 'Action',
																width: 100,
																align: 'center',
																formatter: function(value, row, index) {
																				var p = ' <button href="javascript:void(0)" onclick="lihat_log(this)" class="easyui-linkbutton">View</button>';
																				return p;

																}
												}

								]
				]
});