function activated_user(user_id, flag) {
    $.ajax({
        url: 'Admin/activated_user',
        type: 'POST',
        data: {
            user_id: user_id,
            flag: flag
        },
        success: function(msg) {
            if (msg > 0) {
                $("#dt-master-user").datagrid('reload');
            } else {
                $.messager.alert('Warning','Data user gagal disimpan');
                $("#dt-master-user").datagrid('reload');
            }
        }
    });
}


function reset_password(user_id, nik) {
    $.ajax({
        url: 'Admin/reset_password',
        type: 'POST',
        data: {
            user_id: user_id
        },
        success: function(msg) {
            if (msg > 0) {
                $.messager.alert('Warning','Password NIK '+nik+' berhasil direset menjadi "12345".');
                $("#dt-master-user").datagrid('reload');
            } else {
                $.messager.alert('Warning','Reset password gagal.');
                $("#dt-master-user").datagrid('reload');
            }
        }
    });
}
function doSearchUser() {

                var nik = $('#search-nik').textbox('getValue');
                var username = $('#search-username').textbox('getValue');
                var role = $('#search-role').combobox('getValue');
                var cabang = $('#search-cabang').combobox('getValue');

                $('#dt-master-user').datagrid('load', {
                                nik: nik,
                                username: username,
                                role: role,
                                cabang: cabang
                });

}


function delete_region()
{
     var data=$('#dt-master-region').datagrid('getSelected');
     $.ajax({
        url: 'Admin/delete_region',
        type: 'POST',
        data: {
            region_id :data.REGION_ID
        },
        success: function(msg) {
            if (msg > 0) {
                $.messager.alert('Warning','Data region berhasil dihapus');
                $("#dt-master-region").datagrid('reload');
            } else {
                $.messager.alert('Warning','Data gagal dihapus.');
                $("#dt-master-region").datagrid('reload');
            }
        }
    });
}


function edit_region()
{
    var data=$('#dt-master-region').datagrid('getSelected');
    $("#modal-add-region").window({
                iconCls: 'icon-ess-edit',
                title: 'Edit Master Region'
            });
    $('#region-code').textbox('setValue',data.REGION_CODE);
    $('#region-name').textbox('setValue',data.REGION_NAME);
    $('#region-id').textbox('setValue',data.REGION_ID);
    $("#region-base").hide();
    $('#modal-add-region').window('open');

}

function edit_region_branch()
{
    var data=$('#dt-master-region-branch').datagrid('getSelected');
    $("#modal-add-region-branch").window({
                iconCls: 'icon-ess-edit',
                title: 'Edit Master Region Branch'
            });
    $('#branch').combobox('select',data.BRANCH_NAME);
    $('#branch').combobox('readonly',true);
    $('#region').combobox('select',data.REGION_NAME);
    $('#region-branch-base').hide();
    $('#branch-region-id').textbox('setValue',data.REGION_BRANCH_ID);
    $('#modal-add-region-branch').window('open');

}


function delete_region_branch()
{
     var data=$('#dt-master-region-branch').datagrid('getSelected');
   
     $.ajax({
        url: 'Admin/delete_region_branch',
        type: 'POST',
        data: {
            region_branch_id :data.REGION_BRANCH_ID
        },
        success: function(msg) {
            if (msg > 0) {
                $.messager.alert('Warning','Data berhasil dihapus');
                $("#dt-master-region-branch").datagrid('reload');
            } else {
                $.messager.alert('Warning','Data gagal dihapus.');
                $("#dt-master-region-branch").datagrid('reload');
            }
        }
    });
}

$("#dt-master-user").datagrid({
        url: 'Admin/get_data_master_user/',
        striped: true,
        rownumbers:true,
        remoteSort:true,
        singleSelect:true,
        pagination:true,
        fit:false,
        autoRowHeight:false,
        fitColumns:true,
        toolbar :'#toolbar',
        onDblClickRow: function() {
            var data = $(this).datagrid('getSelected');
            $("#modal-add-user").window({
                iconCls: 'icon-ess-edit',
                title: 'Edit User'
            });
            $("#user-id").val(data.USER_ID);
            $("#u-branch").combobox('select', data.BRANCH_ID);
            $("#u-role").combobox('select', data.ROLE_ID);
            $("#u-nik").numberbox('setValue', data.NIK);
            $("#u-username").textbox('setValue', data.USERNAME);
            $("#u-email").textbox('setValue', data.EMAIL);
            $('#u-nama').textbox('setValue',data.NAMA);

            $("#modal-add-user").window('open');
        },
        columns:[[
            {field:'USER_ID',hidden:true},
            {field:'BRANCH_ID',hidden:true},
            {field:'ROLE_ID',hidden:true},
            {field:'REGION_ID',hidden:true},
            {field:'NIK',title:'NIK',width:150,align:"center",halign:"center"},
            {field:'USERNAME',title:'Username',width:150,align:"center",halign:"center"},
            {field:'EMAIL',title:'Email',width:150,align:"center",halign:"center"},
            {field:'ROLE_NAME',title:'Role',width:150,align:"center",halign:"center"},
            {field:'BRANCH',title:'Branch',width:150,align:"center",halign:"center"},
            {field:'ACTIVE_FLAG',title:'Status',width:150,align:"center",halign:"center",
                formatter: function (value, row, index) {
                    if (value == 'Y') {
                        return '<input type="button" value="Active" onClick="activated_user('+row.USER_ID+',\''+value+'\')">';
                    } else {
                        return '<input type="button" value="Inactive" onClick="activated_user('+row.USER_ID+',\''+value+'\')">';
                    }
                }
            },
            {field:'RESET_FLAG',title:'Reset Status',width:150,align:"center",halign:"center"},
            {field:'CREATE_DATE',title:'Create date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            },
            {field:'LAST_UPDATE_DATE',title:'Update date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            },
            {field: 'BTN_RESET_PASSWORD', title: 'Password' ,width:150 ,align:'center',
                formatter: function (value, row, index) {
                    var col = '<input type="button" value="Reset" onClick="reset_password('+row.USER_ID+',\''+row.NIK+'\')">';
                    return col;
                }
            }
        ]]
    });
$('#dt-master-role').datagrid({
        url: 'Admin/get_data_master_role/',
        striped: true,
        rownumbers:true,
        remoteSort:true,
        singleSelect:true,
        pagination:true,
        fit:false,
        autoRowHeight:false,
        fitColumns:true,
        toolbar :'#toolbar',
        onDblClickRow: function() {
            var data = $(this).datagrid('getSelected');
            $("#modal-add-role").window({
                iconCls: 'icon-ess-edit',
                title: 'Edit Master role'
            });
            $("#role-id").val(data.ROLE_ID);
            $("#role-name").textbox('setValue', data.ROLE_NAME);
            $("#role-desc").textbox('setValue', data.ROLE_DESC);
            $("#modal-add-role").window('open');
        },
        columns:[[
            {field:'ROLE_ID',hidden:true},
            {field:'ROLE_NAME',title:'Nama Menu',width:150,align:"center",halign:"center"},
            {field:'ROLE_DESC',title:'Deskripsi',width:150,align:"center",halign:"center"},
            {field:'CREATE_DATE',title:'Create date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            },
            {field:'LAST_UPDATE_DATE',title:'Update date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            }
        ]]
    });
$('#dt-master-bank').datagrid({
    url: 'Admin/get_data_master_bank/',
    striped: true,
    rownumbers: true,
    remoteSort: true,
    singleSelect: true,
    pagination: true,
    fit: false,
    autoRowHeight: false,
    fitColumns: true,
    toolbar: '#toolbar',
    onDblClickRow: function() {
        var data = $(this).datagrid('getSelected');
        $("#modal-add-bank").window({
            iconCls: 'icon-ess-edit',
            title: 'Edit Master BANK'
        });
        $("#bank-id").val(data.BANK_ID);
        $("#bank-name").textbox('setValue', data.BANK_NAME);
        // $("#bank-code").textbox('setValue', data.BANK_CODE);
        // $("#account-number").textbox('setValue', data.ACCOUNT_NUMBER);
        // $("#account-name").textbox('setValue', data.ACCOUNT_NAME);
        $("#modal-add-bank").window('open');
    },
    columns: [
        [
            { field: 'BANK_ID', hidden: true },
            { field: 'BANK_NAME', title: 'Nama Bank', width: 150, align: "center", halign: "center" },
            {
                field: 'CREATED_DATE',
                title: 'Create date',
                width: 150,
                align: "center",
                halign: "center",
                formatter: function(value, row, index) {
                    var date = new Date(value.substring(0, 4) + '-' + value.substring(5, 7) + '-' + value.substring(8, 10));
                    options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            },
            {
                field: 'LAST_UPDATE_DATE',
                title: 'Update date',
                width: 150,
                align: "center",
                halign: "center",
                formatter: function(value, row, index) {
                    var date = new Date(value.substring(0, 4) + '-' + value.substring(5, 7) + '-' + value.substring(8, 10));
                    options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            }
        ]
    ]
});
     $("#dt-master-region").datagrid({
        url: 'Admin/get_data_master_region/',
        striped: true,
        rownumbers:true,
        remoteSort:true,
        singleSelect:true,
        pagination:true,
        fit:false,
        autoRowHeight:false,
        fitColumns:true,
        toolbar :'#toolbar',
        onDblClickRow: function() {
            
        },
        columns:[[
            {field:'REGION_ID',hidden:true},
            {field:'REGION_CODE',title:'Kode Region',width:150,align:"center",halign:"center"},
            {field:'REGION_NAME',title:'Nama Region',width:150,align:"center",halign:"center"},
            {field: 'BTN_EDIT', title: 'Action' ,width:150 ,align:'center',
                formatter: function (value, row, index) {
                  
                    var p=' <a href="javascript:void(0)" onclick="edit_region(this)" class="easyui-linkbutton">Edit</a>';
                    var q=' <a href="javascript:void(0)" onclick="delete_region(this)" class="easyui-linkbutton">Delete</a>';
                  
                        return p+q;
                }
            }
        ]]
    });

     $("#dt-master-region-branch").datagrid({
        url: 'Admin/get_data_master_region_branch/',
        striped: true,
        rownumbers:true,
        remoteSort:true,
        singleSelect:true,
        pagination:true,
        fit:false,
        autoRowHeight:false,
        fitColumns:true,
        toolbar :'#toolbar',
        onDblClickRow: function() {
            
        },
        columns:[[
            {field:'REGION_BRANCH_ID',hidden:true},
            {field:'BRANCH_NAME',title:'Cabang',width:150,align:"center",halign:"center"},
            {field:'REGION_NAME',title:'Region',width:150,align:"center",halign:"center"},
            {field: 'BTN_EDIT', title: 'Action' ,width:150 ,align:'center',
                formatter: function (value, row, index) {
                    var p=' <a href="javascript:void(0)" onclick="edit_region_branch(this)" class="easyui-linkbutton">Edit</a>';

                    var q=' <a href="javascript:void(0)" onclick="delete_region_branch(this)" class="easyui-linkbutton">Delete</a>';
                        return p+q;
                }
            }
        ]]
    });


$(document).ready(function() {

    $.extend($.fn.textbox.methods, {
    show: function(jq){
        return jq.each(function(){
            $(this).next().show();
        })
    },
    hide: function(jq){
        return jq.each(function(){
            $(this).next().hide();
            })
        }
    })

    $.messager.defaults.ok = 'Ya';
    $.messager.defaults.cancel = 'Tidak';

    //bank

    $("#add-master-bank").click(function(event) {
        event.preventDefault();
        $('#add-master-bank').linkbutton('disable');
        $("#modal-add-bank").window({
            iconCls: 'icon-ess-add',
            title: 'Add Master Bank'
        });
        $("#bank-id").val('');
        $("#bank-name").textbox('setValue', '');
        $('#add-master-bank').linkbutton('enable');
        $("#modal-add-bank").window('open');
    });

     $("#delete-master-bank").click(function(event) {
        event.preventDefault();
        var data=$('#dt-master-bank').datagrid('getSelected');
        if(data){
            $.ajax({
                url: 'Admin/delete_master_bank/',
                type: 'POST',
                data: {
                    bank_id: data.BANK_ID
                },
                success: function (msg) {
                    if (msg > 0) {

                        $.messager.alert('Warning','Data Bank berhasil dihapus.');
                        $('#dt-master-bank').datagrid('reload');
                    } else {
                        $('#dt-master-bank').datagrid('reload');
                        $.messager.alert('Warning','Data Bank gagal dihapus.');
                    }
                }
            });
        }else{
            $.messager.alert('Warning','Mohon memilih bank yg ingin dihapus.');
        }

  
    });

    $("#save-bank").click(function(event) {
        event.preventDefault();
        $('#save-bank').linkbutton('disable');
        if ($("#bank-name").textbox('getValue') != '' ) {
            $.ajax({
                url: 'Admin/save_master_bank/',
                type: 'POST',
                data: {
                    bank_id: $("#bank-id").val(),
                    bank_name: $("#bank-name").textbox('getValue')
                    
                },
                success: function (msg) {
                    if (msg > 0) {
                        $('#dt-master-bank').datagrid('reload');
                        $("#modal-add-bank").window('close');
                    } else {
                        $('#dt-master-bank').datagrid('reload');
                        $("#modal-add-bank").window('close');
                        $.messager.alert('Warning','Data Bank gagal disimpan.');
                    }
                }
            });    
        } else {
            $.messager.alert('Warning','Mohon mengisi form dengan lengkap.');
        }

        $('#save-bank').linkbutton('enable');
    });


    //end bank
     $('#dt-master-menu').datagrid({
        url: 'Admin/get_data_master_menu/',
        striped: true,
        rownumbers:true,
        remoteSort:true,
        singleSelect:true,
        pagination:true,
        fit:false,
        autoRowHeight:false,
        fitColumns:true,
        toolbar :'#toolbar',
        onDblClickRow: function() {
            var data = $(this).datagrid('getSelected');
                $("#modal-add-mm").window({
                                iconCls: 'icon-ess-edit',
                                title: 'Edit Master Menu'
                        });
            $("#mm-id").val(data.MASTER_MENU_ID);
            $("#menu-name").textbox('setValue', data.MENU_NAME);
            $("#menu-desc").textbox('setValue', data.MENU_DESC);
            $("#menu-url").textbox('setValue', data.URL);
            $("#menu-attr").textbox('setValue', data.ATTR_ID);
            $("#modal-add-mm").window('open');
        },
        columns:[[
            {field:'MASTER_MENU_ID',hidden:true},
            {field:'MENU_NAME',title:'Nama Menu',width:150,align:"center",halign:"center"},
            {field:'MENU_DESC',title:'Deskripsi',width:150,align:"center",halign:"center"},
            {field:'URL',title:'URL',width:150,align:"center",halign:"center"},
            {field:'ATTR_ID',title:'ID Attribute',width:150,align:"center",halign:"center"},
            {field:'CREATE_DATE',title:'Create date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            },
            {field:'LAST_UPDATE_DATE',title:'Update date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            }
        ]]
    });


    $("#add-master-menu").click(function(event) {
        event.preventDefault();
        $('#add-master-menu').linkbutton('disable');
        $("#modal-add-mm").window({
                        iconCls: 'icon-ess-add',
                        title: 'Add Master Menu'
                });
        $("#mm-id").val('');
        $("#menu-name").textbox('setValue', '');
        $("#menu-desc").textbox('setValue', '');
        $("#menu-url").textbox('setValue', '');
        $("#menu-attr").textbox('setValue', '');
        $("#modal-add-mm").window('open');
        $('#add-master-menu').linkbutton('disable');
    });



    


    $("#submit-download-format-address").click(function(event) {
        event.preventDefault();
        window.open('./uploads/bkt_trf/template.csv');

    });


    $("#search-inq-user").click(function(event) {
        event.preventDefault();
        $('#search-inq-user').linkbutton('disable');
        var nik = $('#search-nik').textbox('getValue');
        var username = $('#search-username').textbox('getValue');
        var role = $('#search-role').combobox('getValue');
        var cabang = $('#search-cabang').combobox('getValue');


        if (nik == "" && username == "" && role == "" && cabang == "") {
            $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
        } else if (nik != "" || username != "" || role != "" || cabang != "") {
            doSearchUser();
        }
        $('#search-inq-user').linkbutton('enable');
    });

    $("#clear-inq-user").click(function(event) {
         event.preventDefault();
         $('#clear-inq-user').linkbutton('disable');
         $('#search-nik').textbox('setValue', '');
         $('#search-username').textbox('setValue', '');
         $('#search-role').combobox('select', '');
         $('#search-cabang').combobox('select', '');


         $('#dt-master-user').datagrid('load', {
             nik: null,
             username: null,
             role: null,
             cabang: null
         });
         $('#clear-inq-user').linkbutton('enable');
    });

    $('#search-nik').textbox({
            inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
            keyup: function(e) {
                var code = e.keyCode || e.which;
                if (code == 13) { //Enter keycode
                                $("#search-inq-user").click();
                                }
                                }
            })
    });
    $('#search-username').textbox({
    inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
        keyup: function(e) {
            var code = e.keyCode || e.which;
            if (code == 13) { //Enter keycode
                $("#search-inq-user").click();
                }
            }
        })
    });

    $("#save-mm").click(function(event) {
        event.preventDefault();
        $('#save-mm').linkbutton('disable');
        $.ajax({
                url: 'Admin/save_data_master_menu/',
                type: 'POST',
                data: {
                        id: $("#mm-id").val(),
                        name: $("#menu-name").textbox('getValue'),
                        desc: $("#menu-desc").textbox('getValue'),
                        url: $("#menu-url").textbox('getValue'),
                        attr: $("#menu-attr").textbox('getValue')
                },
                success: function (msg) {
                        if (msg > 0) {
                                $("#modal-add-mm").window('close');
                                $('#dt-master-menu').datagrid('reload');
                        } else {
                                $("#modal-add-mm").window('close');
                                $.messager.alert('Warning','Master menu gagal disimpan');
                        }
                }
        });
        $('#save-mm').linkbutton('enable');
    });
    

    $("#submit-upload-master-address").click(function(event) {
        event.preventDefault();
        $('#submit-upload-master-address').linkbutton('disable');
        var form = $('#import_csv')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        
            $('#loader-icon').show();
            $.ajax({
                url: "Admin/insert_master_wilayah/",
                method: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSubmit: function() {
                  $("#progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){ 
                    $("#progress-bar").width(percentComplete + '%');
                    $("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
                },
                success: function(msg) {
                                $('#import_csv')[0].reset();
                                $('#submit-upload-master-address').attr('disabled', false);
                                if(msg=='1'){
                                      
                                    $.messager.alert('Warning','Data berhasil diupload');
                                }else{
                                    $.messager.alert('Warning','Data gagal diupload');
                                }
                                $('#loader-icon').hide();
                }
            });
        $('#submit-upload-master-address').linkbutton('enable');
        return false; 
    });

    $('#dt-manage-menu-h').datagrid({
        url: 'Admin/get_data_menu/',
        striped: true,
        rownumbers:true,
        remoteSort:true,
        singleSelect:true,
        pagination:true,
        fit:false,
        autoRowHeight:false,
        fitColumns:true,
        toolbar :'#toolbar',
        onClickRow: function() {
            var data = $(this).datagrid('getSelected');
            if (data.IS_DETAIL == 'Y') {
                $('#dt-manage-menu-l').datagrid('reload', 'Admin/get_data_menu_detail/'+data.MENU_ID);
            }
        },
        onDblClickRow: function() {
            var data = $(this).datagrid('getSelected');
            $("#modal-add-menu").window({
                iconCls: 'icon-ess-add',
                title: 'Add Menu'
            });
            $("#h-menu-id").val(data.MENU_ID);
            $("#h-role").combobox('select', data.ROLE_ID);
            $("#h-is-detail").combobox('select', data.IS_DETAIL);
            $("#h-delete").show();
            if (data.IS_DETAIL == 'Y') {
                $("#h-menu-name").textbox('setValue', data.MENU_NAME);
                $("#h-menu-desc").textbox('setValue', data.MENU_DESC);
                $("#disp-h-mast").hide();
                $("#disp-h-name").show();
                $("#disp-h-desc").show();
                $('#dt-manage-menu-l').datagrid('reload', 'Admin/get_data_menu_detail/'+data.MENU_ID);
            } else {
                $("#h-mast-menu-name").combobox('select', data.MASTER_MENU_ID);
                $("#disp-h-name").hide();
                $("#disp-h-desc").hide();
                $("#disp-h-mast").show();
            }
            $("#modal-add-menu").window('open');
        },
        columns:[[
            {field:'MENU_ID',hidden:true},
            {field:'ROLE_ID',hidden:true},
            {field:'MASTER_MENU_ID',hidden:true},
            {field:'ROLE_NAME',title:'Role',width:150,align:"center",halign:"center"},
            {field:'MENU_NAME',title:'Nama Menu',width:150,align:"center",halign:"center"},
            {field:'MENU_DESC',title:'Deskripsi',width:150,align:"center",halign:"center"},
            {field:'URL',title:'URL',width:150,align:"center",halign:"center"},
            {field:'ATTR_ID',title:'ID Attribute',width:150,align:"center",halign:"center"},
            {field:'IS_DETAIL',title:'Detail',width:150,align:"center",halign:"center"},
            {field:'CREATE_DATE',title:'Create date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            },
            {field:'LAST_UPDATE_DATE',title:'Update date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            }
        ]]
    });

    $('#dt-manage-menu-l').datagrid({
        url: 'Admin/get_data_menu_detail/X',
        striped: true,
        rownumbers:true,
        remoteSort:true,
        singleSelect:true,
        pagination:true,
        fit:false,
        autoRowHeight:false,
        fitColumns:true,
        toolbar :'#toolbar',
        onDblClickRow: function() {
            var data_l = $(this).datagrid('getSelected');
            $("#modal-add-menu-detail").window({
                                iconCls: 'icon-ess-edit',
                                title: 'Edit Detail Menu'
                        });
                        $("#l-menu-det-id").val(data_l.MENU_DETAIL_ID);
                        $("#l-menu").combobox('select', data_l.MENU_NAME);
                        $("#l-mast-menu-name").combobox('select', data_l.MASTER_MENU_ID);
            $("#l-delete").show();
                        $("#modal-add-menu-detail").window('open');
        },
        columns:[[
            {field:'MENU_DETAIL_ID',hidden:true},
            {field:'MENU_ID',hidden:true},
            {field:'ROLE_ID',hidden:true},
            {field:'MASTER_MENU_ID',hidden:true},
            {field:'ROLE_NAME',title:'Role',width:150,align:"center",halign:"center"},
            {field:'MENU_NAME',title:'Nama Menu',width:150,align:"center",halign:"center"},
            {field:'MENU_DETAIL_NAME',title:'Nama Menu Detail',width:150,align:"center",halign:"center"},
            {field:'MENU_DETAIL_DESC',title:'Deskripsi',width:150,align:"center",halign:"center"},
            {field:'URL',title:'URL',width:150,align:"center",halign:"center"},
            {field:'ATTR_ID',title:'ID Attribute',width:150,align:"center",halign:"center"},
            {field:'CREATE_DATE',title:'Create date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            },
            {field:'LAST_UPDATE_DATE',title:'Update date',width:150,align:"center",halign:"center",
                formatter:function (value,row,index) {
                    var date = new Date(value.substring(0,4)+'-'+value.substring(5,7)+'-'+value.substring(8,10));
                    options = {
                          year: 'numeric', month: 'long', day: 'numeric'
                        };
                    return Intl.DateTimeFormat('id-ID', options).format(date);
                }
            }
        ]]
    });

    $("#l-save").click(function(event) {
        event.preventDefault();
        $('#l-save').linkbutton('disable');
        if ($("#l-menu").combobox('getValue') != '' && $("#l-mast-menu-name").combobox('getValue') != '') {
            $.ajax({
                url: 'Admin/save_data_detail_menu/',
                type: 'POST',
                data: {
                    det_id: $("#l-menu-det-id").val(),
                    menu_id:  $("#l-menu-id").val(),
                    master_id: $("#l-mast-menu-name").combobox('getValue')
                },
                success: function (msg) {
                    if (msg > 0) {
                        $("#l-menu").combobox('reload');
                        $("#l-mast-menu-name").combobox('reload');
                        $("#h-mast-menu-name").combobox('reload');
                        $("#h-role").combobox('reload');
                        $('#dt-manage-menu-l').datagrid('reload');
                        $("#modal-add-menu-detail").window('close');
                    } else {
                        $("#l-menu").combobox('reload');
                        $("#l-mast-menu-name").combobox('reload');
                        $("#h-mast-menu-name").combobox('reload');
                        $("#h-role").combobox('reload');
                        $('#dt-manage-menu-l').datagrid('reload');
                        $("#modal-add-menu-detail").window('close');
                        $.messager.alert('Warning','Menu detail gagal disimpan.');
                    }
                }
            });
            
        } else {
            $.messager.alert('Warning','Harap mengisi form dengan lengkap.');
        }
        $('#l-save').linkbutton('enable');
    });


    $("#add-menu-detail").click(function(event) {
        event.preventDefault();
        var data_l = $('#dt-manage-menu-h').datagrid('getSelected');
        $("#l-delete").hide();
        if (data_l) {
            $("#modal-add-menu-detail").window({
                iconCls: 'icon-ess-add',
                title: 'Add Detail Menu'
            });

        //alert(data_l.MENU_NAME);
            $("#l-menu-det-id").val('');
            document.getElementById('l-menu-id').value=data_l.MENU_ID;
            $("#l-menu").combobox('select', data_l.MENU_NAME);
            $("#l-mast-menu-name").combobox('select', '');
            $("#modal-add-menu-detail").window('open');
        } else {
            $.messager.alert('Warning','Harap memilih menu terlebih dahulu.');
        }
    });

    $("#l-delete").click(function(event) {
        event.preventDefault();
        $('#l-delete').linkbutton('disable');
        if ($("#l-menu-det-id").val() != '') {
            $.ajax({
                url: 'Admin/delete_menu_detail/',
                type: 'POST',
                data: {det_id: $("#l-menu-det-id").val()},
                success: function (msg) {
                    if (msg > 0) {
                        $("#l-menu").combobox('reload');
                        $("#l-mast-menu-name").combobox('reload');
                        $("#h-mast-menu-name").combobox('reload');
                        $("#h-role").combobox('reload');
                        $('#dt-manage-menu-l').datagrid('reload');
                        $("#modal-add-menu-detail").window('close');
                    } else {
                        $("#l-menu").combobox('reload');
                        $("#l-mast-menu-name").combobox('reload');
                        $("#h-mast-menu-name").combobox('reload');
                        $("#h-role").combobox('reload');
                        $('#dt-manage-menu-l').datagrid('reload');
                        $("#modal-add-menu-detail").window('close');
                        $.messager.alert('Warning','Menu detail gagal dihapus.');
                    }
                }
            });
        }
         $('#l-delete').linkbutton('enable');
    });

    $("#h-is-detail").combobox({
        onChange: function (new_val,old_val) {
            if (new_val == 'Y') {
                $("#disp-h-mast").hide();
                $("#disp-h-name").show('slow');
                $("#disp-h-desc").show('slow');
            } else {
                $("#disp-h-name").hide();
                $("#disp-h-desc").hide();
                $("#disp-h-mast").show('slow');
            }
        }
    });

    $("#add-menu").click(function(event) {
        event.preventDefault();
        $('#add-menu').linkbutton('disable');
        $("#modal-add-menu").window({
            iconCls: 'icon-ess-add',
            title: 'Add Menu'
        });
        $("#h-menu-id").val('');
        $("#h-role").combobox('select', '');
        $("#h-is-detail").combobox('select', '');
        $("#h-menu-name").textbox('setValue', '');
        $("#h-menu-desc").textbox('setValue', '');
        $("#h-mast-menu-name").combobox('setValue', '');
        $("#disp-h-mast").hide();
        $("#disp-h-name").hide();
        $("#disp-h-desc").hide();
        $("#h-delete").hide();
        $('#add-menu').linkbutton('enable');
        $("#modal-add-menu").window('open');
    });

    $("#save-user").click(function(event) {
        event.preventDefault();
        $('#save-user').linkbutton('disable');
        if (($("#u-branch").combobox('getValue') != '' ) &&  $('#u-nama').textbox('getValue') !='' && $("#u-role").combobox('getValue') != '' && $("#u-nik").numberbox('getValue') != '' && $("#u-username").textbox('getValue') != '' && $('#u-email').textbox('getValue') != '') {
         
          
            if($("#u-branch").combobox('getValue') !=''){
                var branch=$("#u-branch").combobox('getValue');
            }else{
                var branch=null;
            }
            $.ajax({
                url: 'Admin/save_user',
                type: 'POST',
                data: {
                    user_id: $("#user-id").val(),
                    branch_id: branch,
                    role_id: $("#u-role").combobox('getValue'),
                    nik: $("#u-nik").numberbox('getValue'),
                    username: $("#u-username").textbox('getValue'),
                    email :$("#u-email").textbox('getValue'),
                    nama: $('#u-nama').textbox('getValue')
                },
                success: function (msg) {
                    if (msg > 0) {
                        $("#dt-master-user").datagrid('reload');
                        $("#modal-add-user").window('close');
                    } else {
                        $("#dt-master-user").datagrid('reload');
                        $("#modal-add-user").window('close');
                        $.messager.alert('Warning','Data user gagal disimpan.');
                    }
                }
            });
        } else {
            $.messager.alert('Warning','Mohon mengisi form dengan lengkap.');
        }
        $('#save-user').linkbutton('enable');
    });

    $("#add-master-user").click(function(event) {
        event.preventDefault();
        $("#modal-add-user").window({
            iconCls: 'icon-ess-add',
            title: 'Add User'
        });
        $("#user-id").val('');
        $("#u-branch").combobox('select', '');
        $('#u-nama').textbox('setValue','');
 
        $("#u-role").combobox('select', '');
        $("#u-nik").numberbox('setValue', '');
        $("#u-username").textbox('setValue', '');
        $("#u-email").textbox('setValue', '');
        
        $("#modal-add-user").window('open');
    });




   /* $("#u-branch").combobox({
        onChange: function(new_val, old_val) {
         if (new_val !='' ) {

            $('#u-region').combobox('select','');
            $('#u-region').combobox('readonly',true);
         } else {

            $('#u-region').combobox('select','');
            $('#u-region').combobox('readonly',false);
            }
        }
    });

     $("#u-region").combobox({
        onChange: function(new_val, old_val) {
         if (new_val !='' ) {

            $('#u-branch').combobox('select','');
            $('#u-branch').combobox('readonly',true);
         } else {

            $('#u-branch').combobox('select','');
            $('#u-branch').combobox('readonly',false);
            }
        }
    });*/


    $("#h-delete").click(function(event) {
        event.preventDefault();
        $('#h-delete').linkbutton('disable');
        if ($("#h-menu-id").val() != '') {
            $.messager.confirm('Confirm','Apakah anda yakin menghapus menu tersebut ? (Apabila menu memiliki detail, maka akan dihapus beserta detailnya)',function(r){
                if (r){
                    $.ajax({
                        url: 'Admin/delete_menu/',
                        type: 'POST',
                        data: {menu_id: $("#h-menu-id").val()},
                        success: function (msg) {
                            if (msg > 0) {
                                $("#l-menu").combobox('reload');
                                $("#l-mast-menu-name").combobox('reload');
                                $("#h-mast-menu-name").combobox('reload');
                                $("#h-role").combobox('reload');
                                $('#dt-manage-menu-l').datagrid('reload');
                                $('#dt-manage-menu-h').datagrid('reload');
                                $("#modal-add-menu").window('close');
                            } else {
                                $("#l-menu").combobox('reload');
                                $("#l-mast-menu-name").combobox('reload');
                                $("#h-mast-menu-name").combobox('reload');
                                $("#h-role").combobox('reload');
                                $('#dt-manage-menu-l').datagrid('reload');
                                $('#dt-manage-menu-h').datagrid('reload');
                                $("#modal-add-menu").window('close');
                                $.messager.alert('Warning','Menu gagal dihapus.');
                            }
                        }
                    });
                }
            });
        }
        $('#h-delete').linkbutton('enable');
    });

    $("#h-save").click(function(event) {
        event.preventDefault();
        $('#h-save').linkbutton('disable');
        if ($("#h-role").combobox('getValue') != '' && $("#h-is-detail").combobox('getValue') != '') {
            if ($("#h-is-detail").combobox('getValue') == 'Y') {
                if ($("#h-menu-name").textbox('getValue') != '' && $("#h-menu-desc").textbox('getValue') != '') {
                    $.ajax({
                        url: 'Admin/save_data_menu/',
                        type: 'POST',
                        data: {
                            menu_id: $("#h-menu-id").val(),
                            role_id: $("#h-role").combobox('getValue'),
                            is_detail: $("#h-is-detail").combobox('getValue'),
                            name: $("#h-menu-name").textbox('getValue'),
                            desc: $("#h-menu-desc").textbox('getValue'),
                            master_id: $("#h-mast-menu-name").combobox('getValue')
                        },
                        success: function (msg) {
                            if (msg > 0) {
                                $("#l-menu").combobox('reload');
                                $("#l-mast-menu-name").combobox('reload');
                                $("#h-mast-menu-name").combobox('reload');
                                $("#h-role").combobox('reload');
                                $('#dt-manage-menu-l').datagrid('reload');
                                $('#dt-manage-menu-h').datagrid('reload');
                                $("#modal-add-menu").window('close');
                            } else {
                                $("#l-menu").combobox('reload');
                                $("#l-mast-menu-name").combobox('reload');
                                $("#h-mast-menu-name").combobox('reload');
                                $("#h-role").combobox('reload');
                                $('#dt-manage-menu-l').datagrid('reload');
                                $('#dt-manage-menu-h').datagrid('reload');
                                $("#modal-add-menu").window('close');
                                $.messager.alert('Warning','Menu gagal disimpan.');
                            }
                        }
                    });
                } else {
                    $.messager.alert('Warning','Harap mengisi form dengan lengkap.');
                }
            } else {
                if ($("#h-mast-menu-name").combobox('getValue') != '') {
                    $.ajax({
                        url: 'Admin/save_data_menu/',
                        type: 'POST',
                        data: {
                            menu_id: $("#h-menu-id").val(),
                            role_id: $("#h-role").combobox('getValue'),
                            is_detail: $("#h-is-detail").combobox('getValue'),
                            name: $("#h-menu-name").textbox('getValue'),
                            desc: $("#h-menu-desc").textbox('getValue'),
                            master_id: $("#h-mast-menu-name").combobox('getValue')
                        },
                        success: function (msg) {
                            if (msg > 0) {
                                $("#l-menu").combobox('reload');
                                $("#l-mast-menu-name").combobox('reload');
                                $("#h-mast-menu-name").combobox('reload');
                                $("#h-role").combobox('reload');
                                $('#dt-manage-menu-l').datagrid('reload');
                                $('#dt-manage-menu-h').datagrid('reload');
                                $("#modal-add-menu").window('close');
                            } else {
                                $("#l-menu").combobox('reload');
                                $("#l-mast-menu-name").combobox('reload');
                                $("#h-mast-menu-name").combobox('reload');
                                $("#h-role").combobox('reload');
                                $('#dt-manage-menu-l').datagrid('reload');
                                $('#dt-manage-menu-h').datagrid('reload');
                                $("#modal-add-menu").window('close');
                                $.messager.alert('Warning','Menu gagal disimpan.');
                            }
                        }
                    });
                } else {
                    $.messager.alert('Warning','Harap mengisi form dengan lengkap.');
                }
            }
        } else {
            $.messager.alert('Warning','Harap mengisi form dengan lengkap.');
        }
        $('#h-save').linkbutton('enable');
    });

    
    $("#add-master-role").click(function(event) {
        event.preventDefault();
        $("#modal-add-role").window({
            iconCls: 'icon-ess-add',
            title: 'Add Master role'
        });
        $("#role-id").val('');
        $("#role-name").textbox('setValue', '');
        $("#role-desc").textbox('setValue', '');
        $("#modal-add-role").window('open');
    });

    $("#save-role").click(function(event) {
        event.preventDefault();
        $('#save-role').linkbutton('disable');
        if ($("#role-name").textbox('getValue') != '' && $("#role-desc").textbox('getValue') != '') {
            $.ajax({
                url: 'Admin/save_master_role/',
                type: 'POST',
                data: {
                    role_id: $("#role-id").val(),
                    role_name: $("#role-name").textbox('getValue'),
                    role_desc: $("#role-desc").textbox('getValue')
                },
                success: function (msg) {
                    if (msg > 0) {
                        $('#dt-master-role').datagrid('reload');
                        $("#modal-add-role").window('close');
                    } else {
                        $('#dt-master-role').datagrid('reload');
                        $("#modal-add-role").window('close');
                        $.messager.alert('Warning','Menu gagal disimpan.');
                    }
                }
            });    
        } else {
            $.messager.alert('Warning','Mohon mengisi form dengan lengkap.');
        }
        $('#save-role').linkbutton('enable');
    });

    $("#add-master-region").click(function(event) {
        event.preventDefault();
        $("#modal-add-region").window({
            iconCls: 'icon-ess-add',
            title: 'Add Master Region'
        });
        $("#region-code").textbox('setValue', '');
        $("#region-name").textbox('setValue', '');
        $("#region-id").textbox('setValue','');
        $("#region-base").hide();
        $("#modal-add-region").window('open');
    });

    $("#save-region").click(function(event) {
        event.preventDefault();
        $('#save-region').linkbutton('disable');
        var region_code= $("#region-code").textbox('getValue');
        var region_name= $("#region-name").textbox('getValue');
        var region_id=$('#region-id').textbox('getValue');

        if ($("#region-code").textbox('getValue') != '' && $("#region-name").textbox('getValue') != '') {
            $.ajax({
                url: 'Admin/save_master_region/',
                type: 'POST',
                data: {
                    region_code: region_code,
                    region_name: region_name,
                    region_id: region_id 
                },
                success: function (msg) {
                    if (msg > 0) {

                        $.messager.alert('Warning','Data region berhasil disimpan.');
                        $('#dt-master-region').datagrid('reload');
                        $('#region').combobox('reload');
                        $("#modal-add-region").window('close');

                    }  else{
                      $.messager.alert('Warning','Data gagal disimpan.');  
                    } 
                }
            }); 
        } else {
            $.messager.alert('Warning','Mohon mengisi form dengan lengkap.');
        }
        $('#save-region').linkbutton('disable');
    });

    $("#add-master-branch-region").click(function(event) {
        event.preventDefault();
        $("#modal-add-region-branch").window({
            iconCls: 'icon-ess-add',
            title: 'Add Master Region'
        });
        $('#branch').combobox('readonly',false);
        $("#region").combobox('select', '');
        $('#region-branch-base').hide();
        $("#branch").combobox('select', '');
        $("#branch-region-id").textbox('setValue','');
        $("#modal-add-region-branch").window('open');
    });

    $("#save-region-branch").click(function(event) {
        event.preventDefault();
        $('#save-region-branch').linkbutton('disable');
        var region= $("#region").combobox('getValue');
        var branch= $("#branch").combobox('getValue');
        var region_branch_id=$('#branch-region-id').textbox('getValue');

        if (region != '' && branch != '') {
            $.ajax({
                url: 'Admin/save_region_branch/',
                type: 'POST',
                data: {
                    region: region,
                    branch: branch,
                    region_branch_id: region_branch_id
                },
                success: function (msg) {
                    if (msg > 0) {

                        $.messager.alert('Warning','Data branch - region berhasil disimpan.');
                        $('#dt-master-region-branch').datagrid('reload');
                        $('#branch').combobox('reload');
                        $('#save-region-branch').linkbutton('enable');
                        $("#modal-add-region-branch").window('close');
                    }
                }
            }); 
        } else {
            $.messager.alert('Warning','Mohon mengisi form dengan lengkap.');
        }

    });


});