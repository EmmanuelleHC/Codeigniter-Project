   //function global
   function isEmail(email) {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
   }

   function validatePhone(txtPhone) {
                var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
                return filter.test(txtPhone);
   }

   function replaceAll(str, term, replacement) {
                return str.replace(new RegExp(escapeRegExp(term), 'g'), replacement);
   }

   function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
   }



   //end function global
   //start function log status
   function lihat_log() {
                var rows = $('#data-log-status').datagrid('getSelected');
                var form_num = replaceAll(rows.FORM_NUM, "/", "-");
                $('#modal-detail-status').window('open');

   }

   function doSearchLogStatus() {
                var noform = $('#search-no-form-status').textbox('getValue');

                $('#data-log-status').datagrid('load', {
                                noform: $('#search-no-form-status').textbox('getValue')
                });

   }

   //end function log status
   //function finalisasi TO

   function doSearchStatusTO(){
        var noform = $('#search-form-status-to').textbox('getValue');
        $('#data-status-to').datagrid('load', {
            noform: $('#search-form-status-to').textbox('getValue')
        });

   }
   //end finaliassi to

   //start function bapp

   function doSearchBAPP() {
                var bapp_num = $('#search-bapp-no').textbox('getValue');
                //replaceAll($("#search-tgltrf-start-ulok").datebox('getValue'), "/", "-");

                $('#data-list-bapp').datagrid('load', {
                                bapp: $('#search-bapp-no').textbox('getValue')
                });

   }
   //end function bapp
   // start function to

   function print_report_to(value) {
                var data = $('#data-trx-to-toko').datagrid('getSelected');
                var form_id = replaceAll(data.FORM_NUM, "/", "-");
                if (data) {
                                window.open('Ulok/print_form_pengajuan_to_toko/' + form_id);
                } else {
                                var form_id = replaceAll(value, "/", "-");
                                window.open('Ulok/print_form_pengajuan_to_toko/' + form_id);

                }
   }

   function rejectTO() {

       var session_role = $('#session-role').textbox('getValue');
       var data = $('#data-trx-to-toko').datagrid('getSelected');
       if (data) {
           var tipe_form = 'REJECTTO';
           var array = [];
           var flag_reject = false;
           if (data.STATUS == 'N') {
               flag_reject = true;
           }
           if (session_role == 1 || session_role == 3) {

               if (data.length != 0 && flag_reject) {

                   $.ajax({
                       url: 'Ulok/cekOldCode/',
                       type: 'POST',
                       async: false,
                       data: {
                           tipe_form: tipe_form
                       },
                       success: function(msg) {
                           var hasil = JSON.parse(msg);
                           if (hasil['kode_ref'] == '-') {
                               $.ajax({
                                   url: 'Ulok/requestNewCode/',
                                   type: 'POST',
                                   async: false,
                                   data: {
                                       tipe_form: tipe_form
                                   },
                                   success: function(msg) {
                                       var result = JSON.parse(msg);
                                       $('#input-ref-num-to').textbox('setValue', result['kode_ref']);
                                       $('#input-otp-reject-to').textbox('setValue', '');
                                       $('#div_message').hide();
                                       $('#otp-reject-to').window('open');
                                   }
                               });
                           } else {
                               $('#input-ref-num-to').textbox('setValue', hasil['kode_ref']);
                               $('#input-otp-reject-to').textbox('setValue', '');
                               $('#input-no-to').textbox('setValue', data.FORM_NUM);
                               $('#input-alasan-reject-to').textbox('setValue', '');
                               $('#div_message').show();
                               $('#otp-reject-to').window('open');
                           }
                       }
                   });
               } else {
                   $.messager.alert('Warning', 'data TO yang akan direject tidak valid .');
               }

           } else {

               $.messager.alert('Warning', 'Anda tidak mempunyai hak akses Reject.');
           }

       } else {
           $.messager.alert('Warning', 'Anda belum memilih data yg akan direject.');
       }

   }
function doSearchTO() {
    var tanggal_mulai = replaceAll($("#search-tgltrf-start-to").datebox('getValue'), "/", "-");
    var res_mulai = tanggal_mulai.substr(6, 4) + '-' + tanggal_mulai.substr(3, 2) + '-' + tanggal_mulai.substr(0, 2);
    var tanggal_akhir = replaceAll($("#search-tgltrf-end-to").datebox('getValue'), "/", "-");
    var res_akhir = tanggal_akhir.substr(6, 4) + '-' + tanggal_akhir.substr(3, 2) + '-' + tanggal_akhir.substr(0, 2);

    var tanggal_form_mulai = replaceAll($("#search-tglform-start-to").datebox('getValue'), "/", "-");
    var res_form_mulai = tanggal_form_mulai.substr(6, 4) + '-' + tanggal_form_mulai.substr(3, 2) + '-' + tanggal_form_mulai.substr(0, 2);
    var tanggal_form_akhir = replaceAll($("#search-tglform-end-to").datebox('getValue'), "/", "-");
    var res_form_akhir = tanggal_form_akhir.substr(6, 4) + '-' + tanggal_form_akhir.substr(3, 2) + '-' + tanggal_form_akhir.substr(0, 2);

    $('#data-trx-to-toko').datagrid('load', {
        noform_to: $('#search-no-form-to').textbox('getValue'),
        nama_to: $('#search-nama-to').textbox('getValue'),
        status_to: $('#search-status-to').combobox('getValue'),
        tanggal_mulai: res_mulai,
        tanggal_akhir: res_akhir,
        tanggal_form_mulai: res_form_mulai,
        tanggal_form_akhir: res_form_akhir
    });

}
function update_all_to() {
    var ul = document.getElementById("updatefileListTO");
    var items = ul.getElementsByTagName("li");
    var form_id = replaceAll($('#show-form-to-no').textbox('getValue'), "/", "-");

    for (var i = 0; i < items.length; ++i) {
        var li = ul.getElementsByTagName("li")[i].innerHTML;
        var tes = li.indexOf("<");
        var res = li.substring(0, tes);

        if (li != '') {

            $('#update_cek_file_to').textbox('setValue', 'D');

        } else {
            $.messager.alert('Warning', 'Anda tidak memilih file  .');
            $('#update_cek_file_to').textbox('setValue', '');
        }

    }
}
function update_file_to() {

    var jumlah_file = parseInt($('#update_to_file_amount').textbox('getValue'));
    var ukuran_file = $("#update_TO_filesToUpload")[0].files[0].size;
    var form_id = $('#update_to_inserted_id').textbox('getValue');

    if (ukuran_file > 3000000) {
        $.messager.alert('Warning', 'File size must not be more than 3 MB.');
        $('#update_TO_filesToUpload').val('');
    }

    if ($('#update_to_file_amount').textbox('getValue') == '5') {

        $.messager.alert('Warning', 'Maximum file upload : 5 file  .');

    }

    if (form_id != '') {
        if (ukuran_file < 3000000 && (jumlah_file >= 0 && jumlah_file < 5)) {
            var fileSelect = document.getElementById('update_TO_filesToUpload');
            var files = fileSelect.files;
            var formData = new FormData();
            var tipe_form = 'TO';
            var form_num = replaceAll($('#show-form-to-no').textbox('getValue'), "/", "-");
            for (var x = 0; x < files.length; x++) {
                var file = files[x];

                formData.append('filesToUpload', file, file.name);
                $.ajax({
                    url: 'Ulok/save_temp_file_ulok/' + form_num,
                    type: 'POST',
                    async: false,
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(msg) {

                        $.ajax({
                            url: 'Ulok/insert_ulok_master_file/',
                            type: 'POST',
                            async: false,
                            data: {
                                form_num: form_num,
                                file_bukti_trf: msg,
                                tipe_form: tipe_form
                            },
                            success: function(msg) {
                                $.messager.alert('Warning', 'File berhasil diupload.');
                            }
                        });
                    }
                });
            }

            makeFileListTo();
        }
    }

}

function makeFileListTo() {
    var input = document.getElementById("update_TO_filesToUpload");
    var ul = document.getElementById("updatefileListTO");
    var names = [];

    if (ul.firstChild == null) {


        var li = document.createElement("li");
        li.innerHTML = 'No Files Selected';
        ul.appendChild(li);

    }
    if (ul.hasChildNodes()) {
        var anak_pertama = ul.firstChild.innerHTML
        if (anak_pertama == 'No Files Selected') {
            ul.removeChild(ul.firstChild);
        }
    }

    for (var i = 0; i < input.files.length; i++) {
        var li = document.createElement("li");
        li.innerHTML = input.files[i].name;
        var nama_file_baru = replaceAll($('#show-form-to-no').textbox('getValue'), "/", "-") + '_' + input.files[i].name;
        li.setAttribute('id', nama_file_baru);
        var button = document.createElement("button");
        var button2 = document.createElement("button");

        button.id = input.files[i].name;
        button2.id = 'view' + input.files[i].name;
        button.setAttribute('type', 'button');
        button2.setAttribute('type', 'button');
        button.innerHTML = "Delete";
        button2.innerHTML = 'View';
        button2.style.fontSize = "x-small";
        button.style.fontSize = "x-small";
        names.push(input.files[i].name);
        $("input[name=file]").val(names);
        var form_num = replaceAll($('#show-form-to-no').textbox('getValue'), "/", "-");
        var tipe_form = 'TO';

        button.addEventListener("click", function() {
            var child = document.getElementById(li.id);
            var x = names.indexOf(child);
            ul.removeChild(child);
            names.splice(x, 1);
            var sebelum = parseInt($('#update_to_file_amount').textbox('getValue'));
            var sesudah = sebelum - 1;
            $('#update_to_file_amount').textbox('setValue', sesudah);
            var nama_filenya = this.id;
            var session_id = null;

            $.ajax({
                url: 'Ulok/delete_temp_file_ulok/',
                type: 'POST',
                async: false,
                data: {
                    form_num: form_num,
                    tipe_form: tipe_form,
                    nama_file: this.id,
                    session_id: session_id
                },
                success: function(msg) {
                    $('#update_cek_file_to').textbox('setValue', '');
                    $.messager.alert('Warning', 'File berhasil dihapus.');
                    $('#update_TO_filesToUpload').val('');

                }
            });
        }, false);

        button2.addEventListener("click", function(e) {
            e.preventDefault();
            window.open('uploads/bkt_trf/' + li.id);

        }, false);

        li.appendChild(button);
        li.appendChild(button2);
        ul.appendChild(li);
    }

    if (!ul.hasChildNodes()) {
        var li = document.createElement("li");
        li.innerHTML = 'No Files Selected';
        ul.appendChild(li);
    }

}
function see_report_to(value) {
    var data = $('#data-trx-to-toko').datagrid('getSelected');
    var form_id = replaceAll(data.FORM_NUM, "/", "-");
    if (data) {

        var ul = document.getElementById("updatefileListTO");
        var items = ul.getElementsByTagName("li");

        $.ajax({
            url: 'Ulok/count_amount_of_file/',
            type: 'POST',
            async: false,
            data: {
                form_num: data.FORM_NUM
            },
            success: function(msg) {
                var hasil = JSON.parse(msg);
                $('#update_to_file_amount').textbox('setValue', hasil['JUMLAH']);

            }
        });
        $.ajax({
            url: 'Ulok/get_data_to_form_where_to_form_num/',
            type: 'POST',
            async: false,
            data: {
                to_form_num: data.FORM_NUM
            },
            success: function(msg) {
                var hasil = JSON.parse(msg);
                $('#update_to_inserted_id').textbox('setValue', hasil['TO_FORM_ID']);
                $('#show-form-to-no').textbox('setValue', hasil['TO_FORM_NUM']);
                if (parseInt(hasil['TO_ACTUAL_INVESTMENT']) > 0) {
                    var actualinves = 0;
                    actualinves = parseInt(hasil['TO_ACTUAL_INVESTMENT']);

                }
                $('#show-form-to-no-1').textbox('setValue', hasil['TO_FORM_NUM']);
                var tanggal_form = hasil['TO_FORM_DATE'];
                var res_tgl_form = tanggal_form.substr(8, 2) + '-' + tanggal_form.substr(5, 2) + '-' + tanggal_form.substr(0, 4);
                $('#show-tgl-to-form').datebox('setValue', res_tgl_form);
                $('#show-noktp-to').textbox('setValue', hasil['NO_KTP']);
                $('#show-nama-lengkap-to').textbox('setValue', hasil['NAMA']);
                $('#show-alamat-lengkap-to').textbox('setValue', hasil['ALAMAT']);
                $('#show-provinsi-to').combobox('select', hasil['PROVINSI']);
                $('#show-kecamatan-to').combobox('select', hasil['KECAMATAN']);
                $('#show-kelurahan-to').combobox('select', hasil['KELURAHAN']);
                $('#show-kodya-to').combobox('select', hasil['KODYA_KAB']);
                $('#show-kode-pos-to').combobox('select', hasil['KODE_POS']);
                $('#show-telp-to').textbox('setValue', hasil['TELP']);
                $('#show-email-to').textbox('setValue', hasil['EMAIL']);
                $('#show-npwp-to').textbox('setValue', hasil['NPWP']);
                $('#show-kode-toko-to').textbox('setValue', hasil['TO_KODE_TOKO']);
                $('#show-nama-toko-to').textbox('setValue', hasil['TO_NAMA_TOKO']);
                $('#show-alamat-to').textbox('setValue', hasil['TO_ALAMAT']);
                $('#show-actual-investment-to').numberbox('setValue', parseInt(hasil['TO_ACTUAL_INVESTMENT']));
                $('#show-ppn-to').numberbox('setValue', hasil['TO_PPN']);
                $('#show-goodwill-to').numberbox('setValue', hasil['TO_GOOD_WILL']);
                $('#show-total-to').numberbox('setValue', hasil['TO_TOTAL']);
                $('#show-kodya-to-lok').combobox('setValue', hasil['TO_KODYA_KAB']);

                $('#show-provinsi-to-lok').combobox('select', hasil['TO_PROVINSI']);
                $('#show-kecamatan-to-lok').combobox('select', hasil['TO_KECAMATAN']);
                $('#show-kelurahan-to-lok').combobox('select', hasil['TO_KELURAHAN']);


                $('#show-kode-pos-to-lok').combobox('select', hasil['TO_KODE_POS']);
                $('#show-narek-to-pengirim').textbox('setValue', hasil['TO_AN_PENGIRIM']);
                $('#show-tipe-to').combobox('select', hasil['TO_TIPE_BAYAR']);

                $('#show-bank-to').combobox('select', hasil['TO_BANK_ID']);
                $('#show-cabang-bank-to').textbox('setValue', hasil['TO_CABANG_BANK']);
                $('#show-norek-to').textbox('setValue', hasil['TO_NO_REK']);
                $('#show-narek-to').textbox('setValue', hasil['TO_NAMA_REK']);
                $('#show-jumlah-swipe-to').numberbox('setValue', hasil['TO_AMOUNT_SWIPE']);
                $('#show-jumlah-masukrek-to').numberbox('setValue', hasil['TO_AMOUNT']);
                var tanggal_bayar = hasil['TO_BAYAR_DATE'];
                var res_tgl_bayar = tanggal_bayar.substr(8, 2) + '-' + tanggal_bayar.substr(5, 2) + '-' + tanggal_bayar.substr(0, 4);
                $('#show-tgl-to').datebox('setValue', res_tgl_bayar);
                $('#show-rt-rw-to').textbox('setValue', hasil['RT/RW']);
                $('#show-rt-rw-toko-to').textbox('setValue', hasil['TO_RT_RW']);
                $('#show-to-kredit').textbox('setValue', hasil['TO_KARTU_KREDIT']);
                if (hasil['TO_TIPE_BAYAR'] == 'Cash') {
                    $('#show-to-kredit').textbox('readonly', true);

                    $('#show-narek-to-pengirim').textbox('readonly', true);
                }
                var tipe_form = 'TO';
                $.ajax({
                    url: 'Ulok/get_file_uploaded/',
                    type: 'POST',
                    async: false,
                    data: {
                        form_num: hasil['TO_FORM_NUM'],
                        tipe_form: tipe_form
                    },
                    success: function(message) {
                        var input = document.getElementById("update_TO_filesToUpload");
                        var ul = document.getElementById("updatefileListTO");
                        var hasil_file = JSON.parse(message);
                        var names = [];
                        while (ul.hasChildNodes()) {
                            ul.removeChild(ul.firstChild);
                        }
                        var hasil_file = JSON.parse(message);
                        for (var i = 0; i < hasil_file.length; i++) {
                            var str = hasil_file[i]['FILE_BUKTI_TRF'];
                            var res = str.substring(43, str.length);
                            var li = document.createElement("li");
                            li.innerHTML = res;
                            li.setAttribute('id', res);
                            var button = document.createElement("button");
                            var button2 = document.createElement("button");
                            button.id = res;
                            button.innerHTML = "Delete";
                            button2.id = 'view' + res;
                            button.setAttribute('type', 'button');
                            button2.setAttribute('type', 'button');
                            button2.innerHTML = "View";
                            button2.style.fontSize = "x-small";
                            button.style.fontSize = "x-small";
                            names.push(res);
                            var tipe_form = 'TO';
                            ul.appendChild(li);
                            if (data.STATUS == 'N' || data.STATUS == 'New') {
                                li.appendChild(button);
                                li.appendChild(button2);
                            } else {
                                li.appendChild(button2);
                            }

                            button.addEventListener("click", function() {
                                var form_num = replaceAll($('#show-form-to-no').textbox('getValue'), "/", "-");
                                var child = document.getElementById(this.id);
                                var x = names.indexOf(child);
                                ul.removeChild(child);
                                names.splice(x, 1);
                                var sebelum = parseInt($('#update_to_file_amount').textbox('getValue'));
                                var sesudah = sebelum - 1;
                                $('#update_to_file_amount').textbox('setValue', sesudah);
                                var nama_filenya = "" + this.id;
                                var ext_file = nama_filenya.slice(-5);
                                if (ext_file == '.jpeg') {
                                    var res_file = nama_filenya.substring(0, nama_filenya.length - 5);
                                } else {
                                    var res_file = nama_filenya.substring(0, nama_filenya.length - 4);
                                }
                                var session_id = null;
                                var status = 'update';
                                $.ajax({
                                    url: 'Ulok/delete_temp_file_ulok/',
                                    type: 'POST',
                                    async: false,
                                    data: {
                                        form_num: form_num,
                                        tipe_form: tipe_form,
                                        nama_file: nama_filenya,
                                        status: status,
                                        session_id: session_id
                                    },
                                    success: function(msg) {
                                        $('#update_cek_file_to').textbox('setValue', '');
                                        $.messager.alert('Warning', 'File berhasil dihapus.');
                                        $('#update_TO_filesToUpload').val('');

                                    }
                                });

                            }, false);
                            button2.addEventListener("click", function(e) {
                                e.preventDefault();
                                window.open('uploads/bkt_trf/' + li.id);
                            }, false);
                        }
                    }
                });

            }
        });
        if (data.STATUS != 'New' && data.STATUS != 'N') {

            $.messager.alert('Warning', 'File sudah tidak dapat diedit.');
            $('#update_cek_file_to').textbox('setValue', 'D');
            $('#update_submit_file_to').linkbutton('disable');
            $('#update_TO_filesToUpload').prop('disabled', true);
            $('#show-form-to-no').textbox({
                editable: false
            });
            $('#show-tgl-to-form').combobox('readonly', true);
            $('#show-noktp-to').textbox({
                editable: false
            });
            $('#show-nama-lengkap-to').textbox({
                editable: false
            });
            $('#show-alamat-lengkap-to').textbox({
                editable: false
            });
            $('#show-rt-rw-to').textbox({
                editable: false
            });
            $('#show-kecamatan-to').combobox('readonly', true);
            $('#show-kelurahan-to').combobox('readonly', true);
            $('#show-kodya-to').combobox('readonly', true);
            $('#show-kode-pos-to').combobox('readonly', true);
            $('#show-provinsi-to').combobox('readonly', true);
            $('#show-email-to').textbox({
                editable: false
            });
            $('#show-telp-to').textbox({
                editable: false
            });
            $('#show-npwp-to').textbox({
                editable: false
            });
            $('#show-kode-toko-to').textbox({
                editable: false
            });
            $('#show-nama-toko-to').textbox({
                editable: false
            });
            $('#show-alamat-to').textbox({
                editable: false
            });
            $('#show-rt-rw-toko-to').textbox({
                editable: false
            });
            $('#show-kecamatan-to-lok').combobox('readonly', true);
            $('#show-kelurahan-to-lok').combobox('readonly', true);
            $('#show-kodya-to-lok').combobox('readonly', true);
            $('#show-kode-pos-to-lok').combobox('readonly', true);
            $('#show-provinsi-to-lok').combobox('readonly', true);

            $('#show-actual-investment-to').numberbox({
                editable: false
            });
            $('#show-ppn-to').textbox({
                editable: false
            });
            $('#show-goodwill-to').textbox({
                editable: false
            });
            $('#show-total-to').textbox({
                editable: false
            });
            $('#show-tipe-to').combobox('readonly', true);
            $('#show-bank-to').combobox('readonly', true);
            $('#show-cabang-bank-to').combobox('readonly', true);
            $('#show-norek-to').textbox({
                editable: false
            });
            $('#show-narek-to').textbox({
                editable: false
            });
            $('#show-jumlah-swipe-to').numberbox({
                editable: false
            });
            $('#show-jumlah-masukrek-to').numberbox({
                editable: false
            });
            $('#show-tgl-to').combobox('readonly', true);

        }
        $('#div_update_cek_file_to').hide();
        $('#div_update_to_inserted_id').hide();
        $('#div_update_to_file_amount').hide();


    }
    var form_id = replaceAll($('#show-form-to-no').textbox('getValue'), "/", "-");

    $('#data-list-detail-status-to').datagrid('load', '/Ulok/get_detail_log_status/' + form_id);

    $("#showDetailInquiryTO").window('open');;

}

   //end function to

   // start function ulok 
   function rejectUlok() {

      var session_role = $('#session-role').textbox('getValue');
      var data = $('#data-trx-frc-cab').datagrid('getSelected');
      var tipe_form = 'REJECTUlok';
      var array = [];
      var flag_reject = true;
      if (data.STATUS != 'N' && data.STATUS != 'New') {
          flag_reject = false;
      }
      if (session_role == 1 || session_role == 3) {
          if (data.length != 0 && flag_reject) {
             $.ajax({
               url: 'Ulok/cekOldCode/',
               type: 'POST',
               async: false,
               data: {
                   tipe_form: tipe_form
               },
               success: function(msg) {
                    var hasil = JSON.parse(msg);
                    if (hasil['kode_ref'] == '-') {
                        $.ajax({
                           url: 'Ulok/requestNewCode/',
                           type: 'POST',
                           async: false,
                           data: {
                                tipe_form: tipe_form
                            },
                            success: function(msg) {
                                var result = JSON.parse(msg);
                                $('#input-ref-num-ulok').textbox('setValue', result['kode_ref']);
                                $('#input-otp-reject-ulok').textbox('setValue', '');
                                $('#div_message').hide();
                                $('#otp-reject-ulok').window('open');
                            }
                           });
                      } else {
                          $('#input-ref-num-ulok').textbox('setValue', hasil['kode_ref']);
                          $('#input-otp-reject-ulok').textbox('setValue', '');
                          $('#input-no-ulok').textbox('setValue', data.FORM_NUM);
                          $('#input-alasan-reject-ulok').textbox('setValue', '');
                          $('#div_message').show();
                          $('#otp-reject-ulok').window('open');
                      }
                  }
              });
          } else {
              $.messager.alert('Warning', 'data ULOK yang akan direject tidak valid .');
          }

      } else {

          $.messager.alert('Warning', 'Anda tidak mempunyai hak akses Reject.');
      }
  }

   function update_all() {
       var ul = document.getElementById("updatefileList");
       var items = ul.getElementsByTagName("li");
       var form_id = replaceAll($('#show-ulok-form-no').textbox('getValue'), "/", "-");

       for (var i = 0; i < items.length; ++i) {
           var li = ul.getElementsByTagName("li")[i].innerHTML;
           var tes = li.indexOf("<");
           var res = li.substring(0, tes);

           if (li != '') {

               $('#update_cek_file').textbox('setValue', 'D');

           } else {
               $.messager.alert('Warning', 'Anda tidak memilih file  .');
               $('#update_cek_file').textbox('setValue', '');
           }

       }
   }

function update_file() {

    var jumlah_file = parseInt($('#file_amount').textbox('getValue'));
    var ukuran_file = $("#update_filesToUpload")[0].files[0].size;
    var form_id = $('#inserted_id').textbox('getValue');

    if (ukuran_file > 3000000) {
        $.messager.alert('Warning', 'File size must not be more than 3 MB.');
        $('#update_filesToUpload').val('');
    }

    if ($('#file_amount').textbox('getValue') == '5') {

        $.messager.alert('Warning', 'Maximum file upload : 5 file  .');

    }

    if (form_id != '') {


        if (ukuran_file < 3000000 && (jumlah_file >= 0 && jumlah_file < 5)) {
            var fileSelect = document.getElementById('update_filesToUpload');
            var files = fileSelect.files;
            var formData = new FormData();
            var tipe_form = 'ULOK';
            var form_num = replaceAll($('#show-ulok-form-no').textbox('getValue'), "/", "-");
            for (var x = 0; x < files.length; x++) {
                var file = files[x];

                formData.append('filesToUpload', file, file.name);
                $.ajax({
                    url: 'Ulok/save_temp_file_ulok/' + form_num,
                    type: 'POST',
                    async: false,
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(msg) {

                        $.ajax({
                            url: 'Ulok/insert_ulok_master_file/',
                            type: 'POST',
                            async: false,
                            data: {
                                form_num: form_num,
                                file_bukti_trf: msg,
                                tipe_form: tipe_form
                            },
                            success: function(msg) {
                                $.messager.alert('Warning', 'File berhasil diupload.');


                            }
                        });
                    }
                });
            }
            makeFileList();
        }
    }

}
function makeFileList() {
    var input = document.getElementById("update_filesToUpload");
    var ul = document.getElementById("updatefileList");
    var names = [];

    if (ul.firstChild == null) {


        var li = document.createElement("li");
        li.innerHTML = 'No Files Selected';
        ul.appendChild(li);

    }
    if (ul.hasChildNodes()) {
        var anak_pertama = ul.firstChild.innerHTML
        if (anak_pertama == 'No Files Selected') {
            ul.removeChild(ul.firstChild);
        }
    }

    for (var i = 0; i < input.files.length; i++) {

        var li = document.createElement("li");
        li.innerHTML = input.files[i].name;
        var nama_file_baru = replaceAll($('#show-ulok-form-no').textbox('getValue'), "/", "-") + '_' + input.files[i].name;
        li.setAttribute('id', nama_file_baru);
        var button = document.createElement("button");
        button.id = input.files[i].name;
        button.innerHTML = "Delete";
        var button2 = document.createElement("button");
        button2.id = 'view' + input.files[i].name;
        button.setAttribute('type', 'button');
        button2.setAttribute('type', 'button');
        button2.innerHTML = "View";
        button2.style.fontSize = "x-small";
        button.style.fontSize = "x-small";

        names.push(input.files[i].name);
        $("input[name=file]").val(names);
        var form_num = replaceAll($('#show-ulok-form-no').textbox('getValue'), "/", "-");
        var tipe_form = 'ULOK';

        button.addEventListener("click", function() {

            var child = document.getElementById(li.id);
            var x = names.indexOf(child);
            ul.removeChild(child);
            names.splice(x, 1);
            var sebelum = parseInt($('#file_amount').textbox('getValue'));
            var sesudah = sebelum - 1;
            $('#file_amount').textbox('setValue', sesudah);
            var session_id = null;

            $.ajax({
                url: 'Ulok/delete_temp_file_ulok/',
                type: 'POST',
                async: false,
                data: {
                    form_num: form_num,
                    tipe_form: tipe_form,
                    nama_file: this.id,
                    session_id: session_id

                },
                success: function(msg) {
                    $('#cek_file').textbox('setValue', '');

                    $.messager.alert('Warning', 'File berhasil dihapus.');
                    $('#update_filesToUpload').val('');
                }
            });
        }, false);

        button2.addEventListener("click", function(e) {
            e.preventDefault();
            window.open('uploads/bkt_trf/' + li.id);

        }, false);
        var sebelum = parseInt($('#file_amount').textbox('getValue'));
        var sesudah = sebelum + 1;
        $('#file_amount').textbox('setValue', sesudah);
        li.appendChild(button);
        li.appendChild(button2);
        ul.appendChild(li);
    }

    if (!ul.hasChildNodes()) {
        var li = document.createElement("li");
        li.innerHTML = 'No Files Selected';
        ul.appendChild(li);
    }

}
function doSearchUlok() {
    var tanggal_mulai = replaceAll($("#search-tgltrf-start-ulok").datebox('getValue'), "/", "-");
    var res_mulai = tanggal_mulai.substr(6, 4) + '-' + tanggal_mulai.substr(3, 2) + '-' + tanggal_mulai.substr(0, 2);
    var tanggal_akhir = replaceAll($("#search-tgltrf-end-ulok").datebox('getValue'), "/", "-");
    var res_akhir = tanggal_akhir.substr(6, 4) + '-' + tanggal_akhir.substr(3, 2) + '-' + tanggal_akhir.substr(0, 2);

    var tanggal_form_mulai = replaceAll($("#search-tglform-start-ulok").datebox('getValue'), "/", "-");
    var res_form_mulai = tanggal_form_mulai.substr(6, 4) + '-' + tanggal_form_mulai.substr(3, 2) + '-' + tanggal_form_mulai.substr(0, 2);
    var tanggal_form_akhir = replaceAll($("#search-tglform-end-ulok").datebox('getValue'), "/", "-");
    var res_form_akhir = tanggal_form_akhir.substr(6, 4) + '-' + tanggal_form_akhir.substr(3, 2) + '-' + tanggal_form_akhir.substr(0, 2);

    $('#data-trx-frc-cab').datagrid('load', {
        noform_ulok: $('#search-no-form-ulok').textbox('getValue'),
        nama_ulok: $('#search-nama-ulok').textbox('getValue'),
        status_ulok: $('#search-status-ulok').combobox('getValue'),
        tanggal_mulai: res_mulai,
        tanggal_akhir: res_akhir,
        tanggal_form_mulai: res_form_mulai,
        tanggal_form_akhir: res_form_akhir
    });

}
function print_report_ulok() {

    var data = $('#data-trx-frc-cab').datagrid('getSelected');
    var form_id = replaceAll(data.FORM_NUM, "/", "-");
    if (data) {}
    window.open('Ulok/print_form_pengajuan_ulok/' + form_id);
}
function see_report_ulok(value) {

    var data = $('#data-trx-frc-cab').datagrid('getSelected');
    if (data) {
        $('#update_cek_file').textbox('setValue', '');
        var form_id = replaceAll(data.FORM_NUM, "/", "-");
        var ul = document.getElementById("updatefileList");
        var items = ul.getElementsByTagName("li");


        $.ajax({
            url: 'Ulok/count_amount_of_file/',
            type: 'POST',
            async: false,
            data: {
                form_num: data.FORM_NUM
            },
            success: function(msg) {
                var hasil = JSON.parse(msg);
                $('#file_amount').textbox('setValue', hasil["JUMLAH"]);
            }
        });
        $.ajax({
            url: 'Ulok/get_data_ulok_form_where_ulok_form_num/',
            type: 'POST',
            async: false,
            data: {
                ulok_form_num: data.FORM_NUM
            },
            success: function(msg) {
                var hasil = JSON.parse(msg);
                $("#showDetailInquiry").window({
                    iconCls: 'icon-ess-add',
                    title: 'Edit ULOK '
                });
                $('#inserted_id').textbox('setValue', hasil['ULOK_FORM_ID']);

                $('#show-ulok-form-no').textbox('setValue', hasil['ULOK_FORM_NUM']);
                $('#show-ulok-form-no-1').textbox('setValue', hasil['ULOK_FORM_NUM']);
                $('#show-ulok-kecamatan').combobox('select', hasil['KECAMATAN']);
                var tanggal_form = hasil['ULOK_FORM_DATE'];
                var res_tgl_form = tanggal_form.substr(8, 2) + '-' + tanggal_form.substr(5, 2) + '-' + tanggal_form.substr(0, 4);
                $('#show-ulok-provinsi').combobox('select', hasil['PROVINSI']);
                $('#show-ulok-tgl-form').datebox('setValue', res_tgl_form);
                $('#show-ulok-kelurahan').combobox('select', hasil['KELURAHAN']);
                $('#show-ulok-sumber-ulok').combobox('select', hasil['SUMBER_ULOK']);
                $('#show-ulok-kodya').combobox('select', hasil['KODYA_KAB']);
                $('#show-ulok-noktp').textbox('setValue', hasil['NO_KTP']);
                $('#show-ulok-kode-pos').combobox('select', hasil['KODE_POS']);
                $('#show-ulok-nama-lengkap').textbox('setValue', hasil['NAMA']);
                $('#show-ulok-email').textbox('setValue', hasil['EMAIL']);
                $('#show-ulok-alamat-lengkap').textbox('setValue', hasil['ALAMAT']);
                $('#show-ulok-npwp').textbox('setValue', hasil['NPWP']);
                $('#show-ulok-telp').textbox('setValue', hasil['TELP']);
                $('#show-ulok-alamat-lok').textbox('setValue', hasil['ULOK_ALAMAT']);

                $('#show-ulok-provinsi-lok').combobox('select', hasil['ULOK_PROVINSI']);
                $('#show-ulok-kecamatan-lok').combobox('select', hasil['ULOK_KECAMATAN']);
                $('#show-ulok-kelurahan-lok').combobox('select', hasil['ULOK_KELURAHAN']);
                $('#show-ulok-kodya-lok').combobox('select', hasil['ULOK_KODYA_KAB']);
                $('#show-ulok-kode-pos-lok').combobox('select', hasil['ULOK_KODE_POS']);
                $('#show-ulok-ukuran-panjang').numberbox('setValue', hasil['ULOK_UKURAN_PJG']);
                $('#show-ulok-ukuran-lebar').numberbox('setValue', hasil['ULOK_UKURAN_LBR']);
                $('#show-ulok-bentuk-lok').combobox('select', hasil['ULOK_BENTUK']);
                $('#show-ulok-jumlah-unit').numberbox('setValue', hasil['ULOK_JML_UNIT']);
                $('#show-ulok-jumlah-lantai').numberbox('setValue', hasil['ULOK_JML_LT']);
                $('#show-ulok-status-lokasi').combobox('select', hasil['ULOK_STATUS_LOK']);
                $('#show-ulok-status-lokasi-lain').textbox('setValue', hasil['ULOK_STATUS_LOK_LN']);
                $('#show-ulok-dok-milik').combobox('select', hasil['ULOK_DOK']);
                $('#show-ulok-dok-milik-lain').textbox('setValue', hasil['ULOK_DOK_LN']);
                $('#show-ulok-lahan-parkir').combobox('select', hasil['ULOK_LHN_PKR']);
                $('#show-ulok-lahan-parkir-lain').textbox('setValue', hasil['ULOK_LHN_PKR_LN']);
                $('#show-ulok-denah').combobox('select', hasil['ULOK_LAMPIRAN']);
                $('#show-ulok-izin-bangun').combobox('select', hasil['ULOK_IZIN_BGN']);
                $('#show-ulok-izin-untuk').combobox('select', hasil['ULOK_IZIN_UTK']);
                $('#show-ulok-izin-untuk-lain').textbox('setValue', hasil['ULOK_IZIN_UTK_LN']);
                $('#show-ulok-pasar').combobox('select', hasil['ULOK_PASAR']);
                $('#show-ulok-pasar-ada').textbox('setValue', hasil['ULOK_PASAR_LN']);
                $('#show-ulok-minimarket').combobox('select', hasil['ULOK_MINIMARKET']);
                $('#show-ulok-minimarket-ada').textbox('setValue', hasil['ULOK_MINIMARKET_LN']);
                $('#show-ulok-idm-dekat').combobox('select', hasil['ULOK_IDM_TDK']);
                $('#show-ulok-idm-dekat-ada').textbox('setValue', hasil['ULOK_IDM_TDK_LN']);
                $('#show-ulok-tipe').combobox('select', hasil['ULOK_TIPE_BAYAR']);
                $('#show-ulok-bank').combobox('select', hasil['ULOK_BANK_ID']);
                $('#show-ulok-cabang-bank').textbox('setValue', hasil['ULOK_CABANG_BANK']);
                $('#show-ulok-norek').textbox('setValue', hasil['ULOK_NO_REK']);
                $('#show-ulok-narek').textbox('setValue', hasil['ULOK_NAMA_REK']);
                $('#show-ulok-narek-pengirim').textbox('setValue', hasil['ULOK_AN_PENGIRIM']);
                $('#show-ulok-jumlah-swipe').numberbox('setValue', parseInt(hasil['ULOK_AMOUNT_SWIPE']));
                $('#show-ulok-jumlah-masukrek').numberbox('setValue', parseInt(hasil['ULOK_AMOUNT']));
                $('#show-ulok-kredit').textbox('setValue', hasil['ULOK_KARTU_KREDIT']);
                $('#show-ulok-bentuk-lok-lain').textbox('setValue', hasil['ULOK_BENTUK_LOK_LAIN']);
                var tanggal_bayar = hasil['ULOK_BAYAR_DATE'];
                var res_tgl_bayar = tanggal_bayar.substr(8, 2) + '-' + tanggal_bayar.substr(5, 2) + '-' + tanggal_bayar.substr(0, 4);
                $('#show-ulok-tgl').datebox('setValue', res_tgl_bayar);
                $('#show-ulok-rt-rw').textbox('setValue', hasil['RT/RW']);
                $('#show-ulok-rt-rw-lok').textbox('setValue', hasil['ULOK_RT_RW']);

                var tipe_form = 'ULOK';
                $.ajax({
                    url: 'Ulok/get_file_uploaded/',
                    type: 'POST',
                    async: false,
                    data: {
                        form_num: hasil['ULOK_FORM_NUM'],
                        tipe_form: tipe_form
                    },
                    success: function(message) {
                        var input = document.getElementById("update_filesToUpload");
                        var ul = document.getElementById("updatefileList");
                        var hasil_file = JSON.parse(message);
                        var names = [];
                        while (ul.hasChildNodes()) {
                            ul.removeChild(ul.firstChild);
                        }
                        var hasil_file = JSON.parse(message);
                        for (var i = 0; i < hasil_file.length; i++) {

                            var str = hasil_file[i]['FILE_BUKTI_TRF'];
                            var res = str.substring(43, str.length);
                            var li = document.createElement("li");
                            li.innerHTML = res;
                            li.setAttribute('id', res);
                            var button = document.createElement("button");
                            button.id = res;
                            button.innerHTML = "Delete";
                            var button2 = document.createElement("button");
                            button2.id = 'view' + res;
                            button.setAttribute('type', 'button');
                            button2.setAttribute('type', 'button');
                            button2.innerHTML = "View";
                            button2.style.fontSize = "x-small";
                            button.style.fontSize = "x-small";
                            names.push(res);
                            var tipe_form = 'ULOK';

                            ul.appendChild(li);
                            if (data.STATUS == 'N' || data.STATUS == 'New') {
                                li.appendChild(button);
                                li.appendChild(button2);
                            } else {
                                li.appendChild(button2);
                            }
                            button.addEventListener("click", function() {
                                var form_num = replaceAll($('#show-ulok-form-no').textbox('getValue'), "/", "-");
                                var child = document.getElementById(this.id);
                                var x = names.indexOf(child);
                                ul.removeChild(child);
                                names.splice(x, 1);
                                var sebelum = parseInt($('#file_amount').textbox('getValue'));
                                var sesudah = sebelum - 1;
                                $('#file_amount').textbox('setValue', sesudah);
                                var nama_filenya = "" + this.id;
                                var ext_file = nama_filenya.slice(-5);
                                if (ext_file == '.jpeg') {
                                    var res_file = nama_filenya.substring(0, nama_filenya.length - 5);
                                } else {
                                    var res_file = nama_filenya.substring(0, nama_filenya.length - 4);
                                }
                                var status = 'update';
                                $.ajax({
                                    url: 'Ulok/delete_temp_file_ulok/',
                                    type: 'POST',
                                    async: false,
                                    data: {
                                        form_num: form_num,
                                        tipe_form: tipe_form,
                                        nama_file: nama_filenya,
                                        status: status
                                    },
                                    success: function(msg) {
                                        $.messager.alert('Warning', 'File berhasil dihapus.');
                                        $('#update_filesToUpload').val('');

                                    }
                                });



                            }, false);
                            button2.addEventListener("click", function(e) {
                                e.preventDefault();
                                window.open('uploads/bkt_trf/' + li.id);
                            }, false);

                        }
                    }
                });


            }
        });


        var form_id = replaceAll($('#show-ulok-form-no-1').textbox('getValue'), "/", "-");
        $('#data-list-detail-status').datagrid('load', 'Ulok/get_detail_log_status/' + form_id);
        $("#showDetailInquiry").window('open');
        if (data.STATUS != 'N' && data.STATUS != 'New') {
            $.messager.alert('Warning', 'File sudah tidak dapat diedit.');
            $('#update_filesToUpload').prop('disabled', true);
            $('#show-ulok-sumber-ulok').combobox('readonly', true);
            $('#show-ulok-kecamatan').combobox('readonly', true);
            $('#show-ulok-kelurahan').combobox('readonly', true);
            $('#show-ulok-sumber-ulok').combobox('readonly', true);
            $('#show-ulok-kodya').combobox('readonly', true);
            $('#show-ulok-kode-pos').combobox('readonly', true);
            $('#show-ulok-provinsi').combobox('readonly', true);
            $('#show-ulok-noktp').textbox({
                editable: false
            });
            $('#show-ulok-nama-lengkap').textbox({
                editable: false
            });
            $('#show-ulok-email').textbox({
                editable: false
            });
            $('#show-ulok-alamat-lengkap').textbox({
                editable: false
            });
            $('#show-ulok-npwp').textbox({
                editable: false
            });
            $('#show-ulok-telp').textbox({
                editable: false
            });
            $('#show-ulok-alamat-lok').textbox({
                editable: false
            });
            $('#show-ulok-provinsi-lok').combobox('readonly', true);
            $('#show-ulok-kecamatan-lok').combobox('readonly', true);
            $('#show-ulok-kelurahan-lok').combobox('readonly', true);
            $('#show-ulok-kodya-lok').combobox('readonly', true);
            $('#show-ulok-kode-pos-lok').combobox('readonly', true);
            $('#show-ulok-ukuran-panjang').textbox({
                editable: false
            });
            $('#show-ulok-ukuran-lebar').textbox({
                editable: false
            });
            $('#show-ulok-narek-pengirim').textbox({
                editable: false
            });

            $('#show-ulok-bentuk-lok').combobox('readonly', true);
            $('#show-ulok-jumlah-unit').textbox({
                editable: false
            });
            $('#show-ulok-jumlah-lantai').textbox({
                editable: false
            });
            $('#show-ulok-status-lokasi').combobox('readonly', true);
            $('#show-ulok-status-lokasi-lain').textbox({
                editable: false
            });
            $('#show-ulok-dok-milik').combobox('readonly', true);
            $('#show-ulok-dok-milik-lain').textbox({
                editable: false
            });
            $('#show-ulok-lahan-parkir').combobox('readonly', true);
            $('#show-ulok-lahan-parkir-lain').textbox({
                editable: false
            });
            $('#show-ulok-denah').combobox('readonly', true);
            $('#show-ulok-izin-bangun').combobox('readonly', true);
            $('#show-ulok-izin-untuk').combobox('readonly', true);
            $('#show-ulok-izin-untuk-lain').textbox({
                editable: false
            });
            $('#show-ulok-pasar').combobox('readonly', true);
            $('#show-ulok-pasar-ada').textbox({
                editable: false
            });
            $('#show-ulok-minimarket').combobox('readonly', true);
            $('#show-ulok-minimarket-ada').textbox({
                editable: false
            });
            $('#show-ulok-idm-dekat').combobox('readonly', true);
            $('#show-ulok-idm-dekat-ada').textbox({
                editable: false
            });
            $('#show-ulok-tipe').combobox('readonly', true);
            $('#show-ulok-bank').combobox('readonly', true);
            $('#show-ulok-cabang-bank').textbox({
                editable: false
            });
            $('#show-ulok-norek').textbox({
                editable: false
            });
            $('#show-ulok-narek').textbox({
                editable: false
            });
            $('#show-ulok-jumlah-swipe').numberbox({
                editable: false
            });
            $('#show-ulok-jumlah-masukrek').numberbox({
                editable: false
            });
            $('#show-ulok-rt-rw-lok').textbox({
                editable: false
            });
            $('#show-ulok-tgl-form').combobox('readonly', true);
            $('#show-ulok-tgl').combobox('readonly', true);
            $('#show-ulok-rt-rw').textbox({
                editable: false
            });
        }
        $('#div_update_cek_file').hide();
        $('#div_inserted_id').hide();
        $('#div_file_amount').show();
        $('#div_file_amount').hide();

    } else {
        var form_id = replaceAll(value, "/", "-");
        window.open('Ulok/print_form_pengajuan_ulok/' + form_id);
    }

    //$("#showDetailInquiry").window('open');
}
   //end function ulok

   //start function ulok survey
function doSearchUlokSurvey() {
    var tanggal_mulai = replaceAll($("#search-tglsurvey-start-to").datebox('getValue'), "/", "-");
    var res_mulai = tanggal_mulai.substr(6, 4) + '-' + tanggal_mulai.substr(3, 2) + '-' + tanggal_mulai.substr(0, 2);
    var tanggal_akhir = replaceAll($("#search-tglsurvey-end-to").datebox('getValue'), "/", "-");
    var res_akhir = tanggal_akhir.substr(6, 4) + '-' + tanggal_akhir.substr(3, 2) + '-' + tanggal_akhir.substr(0, 2);

    $('#data-survey-ulok-toko').datagrid('load', {
        noform: $('#search-form-survey').textbox('getValue'),
        status_cbg: $('#search-status-cabang-survey').combobox('getValue'),
        tanggal_mulai: res_mulai,
        tanggal_akhir: res_akhir
    });

}
function input_hasil_survey() {
    var data = $('#data-survey-ulok-toko').datagrid('getSelected');
    var form_id = replaceAll(data.FORM_NUM, "/", "-");
    if (data) {
        if (form_id.substring(0, 2) == 'TO') {
            //$('#file_amount_survey').textbox('hide'); 
            var tipe_form = 'TO';
            $('#div_session_role_to').hide();
            $('#to-input-no-form').textbox('setValue', data.FORM_NUM);
            document.getElementById('form-id-field').value = data.FORM_ID;
            var nama = data.NAMA;
            var tipe_form = 'TO';
            $.ajax({
                url: 'Ulok/get_survey_data_ulok_specific/',
                type: 'POST',
                async: false,
                data: {
                    form_id: data.FORM_ID,
                    tipe_form: tipe_form

                },
                success: function(msg) {
                    var hasil = JSON.parse(msg);
                    var tgl_penyampai_survey = hasil[0]['TGL_PENYAMPAI_SURVEY'];
                    if (tgl_penyampai_survey) {

                        var res_tgl_penyampai_survey = tgl_penyampai_survey.substr(8, 2) + '-' + tgl_penyampai_survey.substr(5, 2) + '-' + tgl_penyampai_survey.substr(0, 4);
                    } else {
                        var res_tgl_penyampai_survey = '';
                    }
                    $('#to-input-survey-nama').textbox('setValue', nama);
                    //  $('#to-input-survey-tgl-penyampai-survey').datebox('setValue','13-09-2018');

                    $('#to-input-survey-tgl-penyampai-survey').datebox('setValue', res_tgl_penyampai_survey);
                    if (hasil[0]['STATUS_ULOK'] == 'OK') {
                        $status_ulok = 'Lanjut TO';
                        $('#to_input_status_ulok').combobox('select', $status_ulok);
                    } else if (hasil[0]['STATUS_ULOK'] == 'NOK') {
                        $status_ulok = 'Tdk Lanjut TO';
                        $('#to_input_status_ulok').combobox('select', $status_ulok);
                    }
                    $('#to-input-alasan-status-ulok').textbox('setValue', hasil[0]['KET_STATUS_ULOK']);

                    if (hasil[0]['STATUS'] == 'N') {
                        $status_cbg = 'N';
                    } else {
                        $status_cbg = hasil[0]['STATUS'];
                    }
                    $("#to_input_status_cabang").combobox('select', $status_cbg);
                    $('#to_input_status_ho').combobox('select', hasil[0]['STATUS_HO']);
                    $('#to_input_status_cabang').combobox('readonly',true);
                    $('#to_input_status_ho').combobox('readonly',true);

                }
            });

            if ($('#session-role-to').textbox('getValue') == '1') {
                //admin
                $('#to-input-no-form').textbox({
                    editable: false
                });
              
                $('#to-input-survey-nama').textbox({
                    editable: false
                });
                $('#to-input-survey-nama').textbox({
                    editable: false
                });

                $('#submit-penyampaian-proposal-to').linkbutton('enable');
            } else if ($('#session-role-to').textbox('getValue') == '2') {
                //franchise cabang

                if (data.STATUS_CABANG == 'N' || data.STATUS_CABANG == 'FIN' || data.STATUS_CABANG == 'New') {
                    $('#to-input-no-form').textbox('readonly',true);
               
                    $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);

                    $('#to_input_status_ulok').combobox('readonly',true);
                   
                    $('#to-input-alasan-status-ulok').textbox('readonly', true);
                    $('#to-input-survey-nama').textbox('readonly',true);
                    $('#submit-penyampaian-proposal-to').linkbutton('enable');
                } else if (data.STATUS_CABANG == 'BBT' || data.STATUS_CABANG == 'S-OK' || data.STATUS_CABANG == 'S-NOK') {

                    $('#to-input-no-form').textbox('readonly',true);
            
                    $('#to-input-alasan-status-ulok').textbox('readonly',true);
                    $('#to-input-survey-nama').textbox('readonly',true);
                    $('#submit-penyampaian-proposal-to').linkbutton('enable');

                } else {
                    $('#to-input-no-form').textbox('readonly',true);
               
                    $('#to-input-survey-nama').textbox('readonly',true);
                    $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);
                    $('#to_input_status_ulok').combobox('readonly',true);
                    $('#to-input-alasan-status-ulok').textbox('readonly', true);
                    $('#submit-penyampaian-proposal-to').linkbutton('disable');
                }

                //end franchise cbg
            } else if ($('#session-role-to').textbox('getValue') == '5') {
                //franchise mgr cabang

                if (data.STATUS_CABANG != 'S-OK' && data.STATUS_CABANG != 'S-NOK' && data.STATUS_CABANG != 'F-OK' && data.STATUS_CABANG != 'F-NOK') {
                    // frc mgr cabang ga bs edit lagi atau tidak punya hak edit
                    $('#to-input-no-form').textbox('readonly',true);
             
                    $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);

                    $('#to_input_status_ulok').combobox('readonly',true);
                    $('#to-input-alasan-status-ulok').textbox('readonly', true);
                    $('#to-input-survey-nama').textbox('readonly',true);
                    $('#submit-penyampaian-proposal-to').linkbutton('disable');
                } else if (data.STATUS_CABANG == 'F-OK' && data.STATUS_CABANG == 'S-OK' && data.STATUS_CABANG == 'S-NOK' && data.STATUS_CABANG == 'F-NOK') {
                    //frc mgr cabang bisa edit
                    $('#to-input-no-form').textbox('readonly',true);
                    
                    $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);

                    $('#to_input_status_ulok').combobox('readonly',true);
                    $('#to-input-alasan-status-ulok').textbox('readonly',true);
                    $('#to-input-survey-nama').textbox('readonly',true);
                    $('#submit-penyampaian-proposal-to').linkbutton('enable');


                } else {
                    $('#to-input-no-form').textbox('readonly',true);
                 
                    $('#to-input-survey-nama').textbox('readonly',true);
                    $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);
                    $('#to_input_status_ulok').combobox('readonly',true);
                    $('#to-input-alasan-status-ulok').textbox('readonly',true);
                    $('#to-input-alasan-status-ulok').textbox('readonly', true);
                    $('#submit-penyampaian-proposal-to').linkbutton('disable');
                }

                //end franchise  mgr cbg
            } else if ($('#session-role-to').textbox('getValue') == '4') {
                //RFM

                if (data.STATUS_CABANG != 'F-NOK' && data.STATUS_CABANG != 'Final-NOK') {
                    // RFM ga bs edit lagi atau tidak punya hak edit
                    $('#to-input-no-form').textbox('readonly',true);
                  
                    $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);

                    $('#to_input_status_ulok').combobox('readonly',true);
                    $('#to-input-alasan-status-ulok').textbox('readonly', true);
                    $('#to-input-survey-nama').textbox('readonly',true);
                    $('#submit-penyampaian-proposal-to').linkbutton('disable');
                } else if (data.STATUS_CABANG == 'F-NOK' && data.STATUS_CABANG == 'Final-NOK') {
                    //RFM bisa edit
                    $('#to-input-no-form').textbox('readonly',true);
           
                    $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);

                    $('#to_input_status_ulok').combobox('readonly',true);
                    $('#to-input-alasan-status-ulok').textbox('readonly',true);
                    $('#to-input-survey-nama').textbox('readonly',true);
                    $('#submit-penyampaian-proposal-to').linkbutton('enable');

                } else {
                    $('#to-input-no-form').textbox('readonly',true);
                
                    $('#to-input-survey-nama').textbox('readonly',true);
                    $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);
                    $('#to_input_status_ulok').combobox('readonly',true);
                    $('#to-input-alasan-status-ulok').textbox('readonly',true);
                    $('#to-input-alasan-status-ulok').textbox('readonly', true);
                    $('#submit-penyampaian-proposal-to').linkbutton('disable');
                }

                //end RFM
            } else if ($('#session-role-to').textbox('getValue') == '3') {
                //franchise HO
                $('#to-input-no-form').textbox('readonly',true);
             
                $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);

                $('#to_input_status_ulok').combobox('readonly',true);
                $('#to-input-alasan-status-ulok').textbox('readonly',true);
                $('#to-input-survey-nama').textbox('readonly',true);
                $('#submit-penyampaian-proposal-to').linkbutton('disable');


                //end franchise HO
            } else {
                $('#to-input-no-form').textbox('readonly',true);        
                $('#to-input-survey-nama').textbox('readonly',true);
                $('#to-input-survey-tgl-penyampai-survey').combobox('readonly',true);
                $('#to_input_status_ulok').combobox('readonly',true);
                $('#to-input-alasan-status-ulok').textbox('readonly', true);
                $('#submit-penyampaian-proposal-to').linkbutton('disable');
            }
            $("#modal-input-hasil-penyampaian-to").window('open');
        } else if (form_id.substring(0, 4) == 'ULOK') {
            $('#div_session_role').hide();
            var tipe_form = 'ULOK';
            $('#div_amount_survey_ulok').hide();
            $('#input-survey-no-form').textbox('setValue', data.FORM_NUM);
            document.getElementById('form-id-field').value = data.FORM_ID;
            //$('#form-id-field').textbox('setValue',data.FORM_ID);
            $('#input-survey-no-form').textbox({
                editable: false
            });
            $('#input-survey-nama').textbox('setValue', data.NAMA);
            $('#input-survey-nama').textbox({
                editable: false
            });
            //  alert(data.STATUS_CABANG);
            $('#input_status_cabang').combobox('select', data.STATUS_CABANG);
           
            $('#input_status_ho').combobox('select', data.STATUS_HO);
            $('#input_status_cabang').combobox('readonly',true);
            $('#input_status_ho').combobox('readonly',true);
            var ul = document.getElementById("fileListSurveyUlok");
            if (ul) {
                var items = ul.getElementsByTagName("li");
                var tipe_form = 'ULOK_SURVEY';

                $.ajax({
                    url: 'Ulok/count_amount_of_file_survey/',
                    type: 'POST',
                    async: false,
                    data: {
                        form_num: data.FORM_NUM,
                        tipe_form: tipe_form
                    },
                    success: function(msg) {
                        var hasil = JSON.parse(msg);
                        var form_num = $('#input-survey-no-form').textbox('getValue');
                        $('#file_amount_survey').textbox('setValue', hasil['JUMLAH']);
                        if ((hasil['JUMLAH'])) {
                            $.ajax({
                                url: 'Ulok/get_file_uploaded/',
                                type: 'POST',
                                async: false,
                                data: {
                                    form_num: form_num,
                                    tipe_form: tipe_form
                                },
                                success: function(message) {
                                    var input = document.getElementById("filesToUploadSurvey");
                                    var ul = document.getElementById("fileListSurveyUlok");
                                    var hasil_file = JSON.parse(message);
                                    var names = [];
                                    while (ul.hasChildNodes()) {
                                        ul.removeChild(ul.firstChild);
                                    }
                                    var hasil_file = JSON.parse(message);
                                    for (var i = 0; i < hasil_file.length; i++) {
                                        var str = hasil_file[i]['FILE_BUKTI_TRF'];
                                        var res = str.substring(43, str.length);
                                        var li = document.createElement("li");
                                        li.innerHTML = res;
                                        li.setAttribute('id', res);
                                        var button = document.createElement("button");
                                        button.id = res;
                                        button.innerHTML = "Delete";
                                        var button2 = document.createElement("button");
                                        button.setAttribute('type', 'button');
                                        button2.setAttribute('type', 'button');
                                        button2.id = 'view' + res;
                                        button2.innerHTML = "View";
                                        button2.style.fontSize = "x-small";
                                        button.style.fontSize = "x-small";
                                        names.push(res);
                                        var tipe_form = 'ULOK_SURVEY';
                                        ul.appendChild(li);
                                        //  li.appendChild(button);

                                        if (data.STATUS_CABANG == 'EMAIL') {

                                            li.appendChild(button);
                                            li.appendChild(button2);
                                        } else {
                                            li.appendChild(button2);
                                        }
                                        button.addEventListener("click", function() {
                                            var form_num = replaceAll($('#input-survey-no-form').textbox('getValue'), "/", "-");
                                            var child = document.getElementById(this.id);
                                            var x = names.indexOf(child);
                                            ul.removeChild(child);
                                            names.splice(x, 1);
                                            var sebelum = parseInt($('#file_amount_survey').textbox('getValue'));
                                            var sesudah = sebelum - 1;
                                            $('#file_amount_survey').textbox('setValue', sesudah);
                                            var nama_filenya = "" + this.id;
                                            var ext_file = nama_filenya.slice(-5);
                                            if (ext_file == '.jpeg') {
                                                var res_file = nama_filenya.substring(0, nama_filenya.length - 5);
                                            } else {
                                                var res_file = nama_filenya.substring(0, nama_filenya.length - 4);
                                            }

                                            var status = 'update';
                                            $.ajax({
                                                url: 'Ulok/delete_temp_file_ulok_survey/',
                                                type: 'POST',
                                                async: false,
                                                data: {
                                                    form_num: form_num,
                                                    tipe_form: tipe_form,
                                                    nama_file: nama_filenya,
                                                    status: status
                                                },
                                                success: function(msg) {
                                                    $.messager.alert('Warning', 'File berhasil dihapus.');
                                                    $('#filesToUploadSurvey').val('');

                                                }
                                            });



                                        }, false);
                                        button2.addEventListener("click", function(e) {
                                            e.preventDefault();
                                            window.open('uploads/bkt_trf/' + li.id);
                                        }, false);

                                    }
                                }
                            });
                        }
                    }
                });
            }
            var tipe_form = 'ULOK';
            $.ajax({
                url: 'Ulok/get_survey_data_ulok_specific/',
                type: 'POST',
                async: false,
                data: {
                    form_id: data.FORM_ID,
                    tipe_form: tipe_form

                },
                success: function(msg) {
                    var hasil = JSON.parse(msg);

                    for (var x = 0; x < hasil.length; x++) {

                        if (hasil[x]['TGL_SURVEY'] != null) {

                            var tgl_survey = hasil[0]['TGL_SURVEY'];
                            var res_tgl_survey = tgl_survey.substr(8, 2) + '-' + tgl_survey.substr(5, 2) + '-' + tgl_survey.substr(0, 4);

                            $('#input-survey-tgl-survey').datebox('setValue', res_tgl_survey);
                        } else {
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1; //January is 0!
                            var yyyy = today.getFullYear();

                            if (dd < 10) {
                                dd = '0' + dd;
                            }

                            if (mm < 10) {
                                mm = '0' + mm;
                            }

                            today = dd + '-' + mm + '-' + yyyy;
                            $('#input-survey-tgl-survey').datebox('setValue', today);

                        }
                        if (hasil[x]['SURVEY_HASIL'] != null) {
                            $('#input_hasil_survey').combobox('select', hasil[0]['SURVEY_HASIL']);
                        } else {
                            $('#input_hasil_survey').combobox('select', '');
                        }
                        if (hasil[x]['KETERANGAN'] != null) {
                            $('#input-alasan-survey').textbox('setValue', hasil[0]['KETERANGAN']);
                        } else {
                            $('#input-alasan-survey').textbox('setValue', '');
                        }

                        if (hasil[x]['TGL_PENYAMPAI_SURVEY'] != null) {
                            var tgl_penyampai_survey = hasil[0]['TGL_PENYAMPAI_SURVEY'];
                            var res_tgl_penyampai_survey = tgl_penyampai_survey.substr(8, 2) + '-' + tgl_penyampai_survey.substr(5, 2) + '-' + tgl_penyampai_survey.substr(0, 4);
                            $('#input-survey-tgl-penyampai-survey').datebox('setValue', res_tgl_penyampai_survey);
                        } else {
                            $('#input-survey-tgl-penyampai-survey').datebox().datebox('calendar').calendar({
                                validator: function(date) {
                                    // var now = new Date();

                                    if (hasil[0]['TGL_SURVEY'] != null) {
                                        var d1 = new Date(hasil[0]['TGL_SURVEY']);

                                    } else {
                                        var d1 = new Date();
                                    }

                                    d1.setDate(d1.getDate() - 1);
                                    // return d1;
                                    //alert(d3);
                                    return date >= d1;
                                }
                            });
                            // $('#input-survey-tgl-penyampai-survey').datebox('setValue', '');
                        }
                        if (hasil[x]['STATUS_ULOK'] != null) {
                            if (hasil[0]['STATUS_ULOK'] == 'OK') {
                                $status_ulok = 'Lanjut Buka';
                                $('#input_status_ulok').combobox('select', $status_ulok);
                            } else if (hasil[0]['STATUS_ULOK'] == 'NOK') {
                                $status_ulok = 'Tdk Lanjut Buka';
                                $('#input_status_ulok').combobox('select', $status_ulok);
                            }
                        } else {
                            $('#input_status_ulok').combobox('select', '');
                        }
                        if (hasil[x]['KET_STATUS_ULOK'] != null) {
                            $('#input-alasan-status-ulok').textbox('setValue', hasil[0]['KET_STATUS_ULOK']);
                        } else {
                            $('#input-alasan-status-ulok').textbox('setValue', '');
                        }
                        if (hasil[x]['STATUS'] != '') {

                            if (hasil[0]['STATUS'] == 'N') {
                                $status_cbg = 'New';
                            } else {
                                $status_cbg = hasil[0]['STATUS'];
                            }
                            $("#input_status_cabang").combobox('select', $status_cbg);
                            $('#input_status_ho').combobox('select', hasil[0]['STATUS_HO']);
                        } else {

                            $("#input_status_cabang").combobox('select', '');
                            $('#input_status_ho').combobox('select', '');
                        }
                    }
                    if (($('#session-role').textbox('getValue') == '2') && (data.STATUS_CABANG == 'EMAIL')) {
                        //kalo frc cbg DAN MASIH BOLEH NGEDIT
                        $('#input-survey-tgl-penyampai-survey').combobox('readonly', false);
                        $('#input_status_ulok').combobox('readonly', false);
                        $('#input_hasil_survey').combobox('readonly', false);
                        if (hasil[0]['SURVEY_HASIL'] == 'OK' || hasil[0]['SURVEY_HASIL'] != 'NOK') {

                            $('#input-alasan-survey').textbox('readonly', true);
                        } else {
                            $('#input-alasan-survey').textbox('readonly', false);
                        }
                        if (hasil[0]['STATUS_ULOK'] == 'OK' || hasil[0]['STATUS_ULOK'] != 'NOK') {


                            $('#input-alasan-status-ulok').textbox({
                                editable: false
                            });
                            $('#input-alasan-status-ulok').textbox('readonly', true);
                        } else if (hasil[0]['STATUS_ULOK'] == 'NOK') {
                            $('#input-alasan-status-ulok').textbox('readonly', false);
                        }
                        $('#filesToUploadSurvey').prop('disabled', false);
                    } else if ($('#session-role').textbox('getValue') == '2' && (data.STATUS_CABANG == 'S-OK' || data.STATUS_CABANG == 'S-NOK')) {

                        $('#input-survey-tgl-penyampai-survey').combobox('readonly', true);
                        $('#input_status_ulok').combobox('readonly', false);
                        $('#input_hasil_survey').combobox('readonly', true);
                        if (hasil[0]['SURVEY_HASIL'] == 'OK') {

                            $('#input-alasan-survey').textbox('readonly', true);
                        } else {
                            $('#input-alasan-survey').textbox('readonly', false);
                        }
                        if (hasil[0]['STATUS_ULOK'] == 'OK') {


                            $('#input-alasan-status-ulok').textbox({
                                editable: false,
                                readonly: true
                            });
                        } else {
                            $('#input-alasan-status-ulok').textbox({
                                editable: true,
                                readonly: false
                            });
                        }
                        $('#filesToUploadSurvey').prop('disabled', false);
                    } else if (($('#session-role').textbox('getValue') == '2') && (data.STATUS_CABANG != 'S-OK' && data.STATUS_CABANG != 'S-NOK' && data.STATUS_CABANG != 'EMAIL')) {
                        // kalo frc cabang dan uda  ga boleh edit  

                        $('#input-survey-no-form').textbox({
                            editable: false
                        });
                        $('#input_hasil_survey').combobox('readonly', true);
                        $('#input-alasan-survey').textbox('readonly', true);
                        $('#input-survey-tgl-penyampai-survey').combobox('readonly', true);
                        $('#input_status_ulok').combobox('readonly', true);

                        $('#input-alasan-status-ulok').textbox({
                            editable: false,
                            readonly: true
                        });
                        $('#filesToUploadSurvey').prop('disabled', true);


                    } else if (($('#session-role').textbox('getValue') == '5') && (data.STATUS_CABANG == 'S-NOK' || data.STATUS_CABANG == 'S-OK')) {
                        //kalo frc manager cbg dan  bisa diedit
                        $('#input-survey-no-form').textbox({
                            editable: false
                        });
                 

                        $('#input_status_ulok').combobox('readonly', true);
                        $('#input-alasan-status-ulok').textbox({
                            editable: false,
                            readonly: true
                        });

                        $('#filesToUploadSurvey').prop('disabled', true);
                    } else if (($('#session-role').textbox('getValue') == '5') && (data.STATUS_CABANG != 'S-OK' || data.STATUS_CABANG != 'S-NOK')) {
                        //kalo frc manager cbg TAPI STATUS SUDAH TIDAK BS DIOTAK ATIK

                        $('#input-survey-no-form').textbox({
                            editable: false
                        });
                        // $('#input_status_cabang').combobox({
                        //     editable: false,
                        //     readonly: true
                        // });
                        $('#input_hasil_survey').combobox('readonly', true);
                        $('#input-alasan-survey').textbox('readonly', true);
                        $('#input-survey-tgl-penyampai-survey').combobox('readonly', true);
                        $('#input_status_ulok').combobox('readonly', true);

                        $('#input-alasan-status-ulok').textbox({
                            editable: false
                        });
                        $('#input-alasan-status-ulok').textbox('readonly', true);
                        $('#filesToUploadSurvey').prop('disabled', true);

                    } else if ($('#session-role').textbox('getValue') == '4' /* && (data.STATUS_CABANG == 'Final-NOK' || data.STATUS_CABANG == 'F-NOK')*/ ) {
                        //kalo rfm

                        $('#input-survey-no-form').textbox({
                            editable: false
                        });
                        $('#input_hasil_survey').combobox('readonly', true);
                        $('#input-alasan-survey').textbox('readonly', true);
                        $('#input-survey-tgl-penyampai-survey').combobox('readonly', true);
                        $('#input_status_ulok').combobox('readonly', true);

                        $('#input-alasan-status-ulok').textbox({
                            editable: false
                        });
                        $('#input-alasan-status-ulok').textbox('readonly', true);
                        $('#filesToUploadSurvey').prop('disabled', true);
                    } else if ($('#session-role').textbox('getValue') == '1') {
                        //kalo admin
                        $('#input_hasil_survey').combobox('readonly', false);
                        $('#input-survey-tgl-penyampai-survey').combobox('readonly', false);
                        $('#input_status_ulok').combobox('readonly', false);

                        $('#input-alasan-status-ulok').textbox({
                            editable: false
                        });
                        $('#input-alasan-status-ulok').textbox('readonly', true);
                        $('#filesToUploadSurvey').prop('disabled', false);
                    } else if ($('#session-role').textbox('getValue') == '3') {
                        $('#input-survey-no-form').textbox({
                            editable: false
                        });
                        $('#input_hasil_survey').combobox('readonly', true);
                        $('#input-alasan-survey').textbox('readonly', true);
                        $('#input-survey-tgl-penyampai-survey').combobox('readonly', true);
                        $('#input_status_ulok').combobox('readonly', true);

                        $('#input-alasan-status-ulok').textbox({
                            editable: false
                        });
                        $('#input-alasan-status-ulok').textbox('readonly', true);
                        $('#filesToUploadSurvey').prop('disabled', true);
                    }

                }
            });
            $('#div_session_role').hide();
            $('#div_session_form_id_field').hide();
            $("#modal-input-hasil-survey-ulok").window('open');
        }
    }

}
function makeFileListSurveyUlok() {
    var input = document.getElementById("filesToUploadSurvey");
    var ul = document.getElementById("fileListSurveyUlok");
    var names = [];
    if (ul.firstChild == null) {
        var li = document.createElement("li");
        li.innerHTML = 'No Files Selected';
        ul.appendChild(li);
    }
    if (ul.hasChildNodes()) {
        var anak_pertama = ul.firstChild.innerHTML
        if (anak_pertama == 'No Files Selected') {
            ul.removeChild(ul.firstChild);
        }
    }

    for (var i = 0; i < input.files.length; i++) {
        var li = document.createElement("li");
        li.innerHTML = input.files[i].name;
        var nama_file_baru = replaceAll($('#input-survey-no-form').textbox('getValue'), "/", "-") + '_SURVEY_' + input.files[i].name;
        li.setAttribute('id', nama_file_baru);
        var button = document.createElement("button");
        button.id = input.files[i].name;
        button.innerHTML = "Delete";
        var button2 = document.createElement("button");
        button2.id = 'view' + input.files[i].name;
        button.setAttribute('type', 'button');
        button2.setAttribute('type', 'button');
        button2.innerHTML = "View";
        button2.style.fontSize = "x-small";
        button.style.fontSize = "x-small";
        names.push(input.files[i].name);
        $("input[name=file]").val(names);
        var form_num = replaceAll($('#input-survey-no-form').textbox('getValue'), "/", "-");
        var tipe_form = 'ULOK_SURVEY';
        if ($('#file_amount_survey').textbox('getValue') != '') {
            var sebelum = parseInt($('#file_amount_survey').textbox('getValue'));
        } else {
            var sebelum = 0;
        }
        button.addEventListener("click", function() {

            var child = document.getElementById(li.id);
            var x = names.indexOf(child);
            ul.removeChild(child);
            names.splice(x, 1);
            var sebelum = parseInt($('#file_amount_survey').textbox('getValue'));
            var sesudah = sebelum - 1;
            $('#file_amount_survey').textbox('setValue', sesudah);

            $.ajax({
                url: 'Ulok/delete_temp_file_ulok_survey/',
                type: 'POST',
                async: false,
                data: {
                    form_num: form_num,
                    tipe_form: tipe_form,
                    nama_file: this.id

                },
                success: function(msg) {
                    $.messager.alert('Warning', 'File berhasil dihapus.');
                    $('#filesToUploadSurvey').val('');
                }
            });
        }, false);

        button2.addEventListener("click", function(e) {
            e.preventDefault();
            window.open('uploads/bkt_trf/' + li.id);
        }, false);

        var sesudah = sebelum + 1;

        $('#filesToUploadSurvey').val('');
        $('#file_amount_survey').textbox('setValue', sesudah);
        li.appendChild(button);
        li.appendChild(button2);
        ul.appendChild(li);
    }

    if (!ul.hasChildNodes()) {
        var li = document.createElement("li");
        li.innerHTML = 'No Files Selected';
        ul.appendChild(li);
    }

}

   //end function ulok survey
   //start function lduk
function validasilduk() {

    var session_role = document.getElementById('session_role').value;
    var data = $('#data-list-lduk').datagrid('getSelections');
    $('#input-otp-lduk').textbox('setValue', '');
    var tipe_form = 'lduk';

    if (session_role == 1 || session_role == 3) {
        if (data.length != 0) {
            $.ajax({
                url: 'Ulok/cekOldCode/',
                type: 'POST',
                async: false,
                data: {
                    tipe_form: tipe_form
                },
                success: function(msg) {
                    var hasil = JSON.parse(msg);
                    if (hasil['kode_ref'] == '-') {
                        $.ajax({
                            url: 'Ulok/requestNewCode/',
                            type: 'POST',
                            async: false,
                            data: {
                                tipe_form: tipe_form
                            },
                            success: function(msg) {
                                var result = JSON.parse(msg);
                                $('#input-ref-num').textbox('setValue', result['kode_ref']);
                                $('#input-otp-lduk').textbox('setValue', '');
                                $('#div_message').hide();
                                $('#otp-validasi-lduk').window('open');
                            }
                        });
                    } else {
                        $('#input-ref-num').textbox('setValue', hasil['kode_ref']);
                        $('#input-otp-lduk').textbox('setValue', '');
                        $('#div_message').show();
                        $('#otp-validasi-lduk').window('open');
                    }
                }
            });
        } else {
            $.messager.alert('Warning', 'Anda belum memilih data LDUK yg harus difinalisasi .');
        }

    } else {

        $.messager.alert('Warning', 'Anda tidak mempunyai hak akses LDUK .');
    }
}

   function doSearchLDUK() {

       var noform_lduk = $('#search-lduk-no').textbox('getValue');
       var periode = $('#search-periode-lduk').combobox('getValue');
       //var region = $('#search-region-lduk').combobox('getValue');
       var region = '';
       var cabang = $('#search-lduk-cabang').combobox('getValue');

       $('#data-list-lduk').datagrid('load', {
           noform_lduk: noform_lduk,
           periode: periode,
           region: region,
           cabang: cabang
       });

   }
   function lihat_lduk() {

       var data = $('#data-list-lduk').datagrid('getSelected');
       var lduk_form = data.LDUK_NUM;
       var lduk_id = data.LDUK_ID;
       if (data) {

           $.ajax({
               url: 'Ulok/get_report_lduk_detail/',
               type: 'POST',
               async: false,
               data: {

                   lduk: lduk_form
               },
               success: function(msg) {
                   var hasil = JSON.parse(msg);

                   if (hasil['BRANCH_ID']) {
                       var cabang = hasil['BRANCH_ID'];
                   } else {
                       var cabang = 0;
                   }

                   var lduk = replaceAll(data.LDUK_NUM, "/", "-");
                   window.open('Ulok/print_laporan_uangmuka_kembali/' + cabang + '/' + data.PERIODE + '/' + lduk + '/' + lduk_id + '/0');
                   //  window.open('Ulok/print_laporan_uangmuka_kembali/' + cabang + '/1/' + data.PERIODE + '/' + lduk + '/' + lduk_id);
               }
           });

       }
   }
   //end function lduk

   //start function lpdu
   function doSearchLPDU() {

       var noform_lpdu = $('#search-lpdu-no').textbox('getValue');
       var periode = $('#search-lpdu-periode').combobox('getValue');
       // var region = $('#search-lpdu-region').combobox('getValue');
       var region = '';
       var cabang = $('#search-lpdu-cabang').combobox('getValue');

       $('#data-list-lpdu').datagrid('load', {
           noform_lpdu: noform_lpdu,
           periode: periode,
           region: region,
           cabang: cabang
       });

   }


   function lihat_lpdu(value) {

       var data = $('#data-list-lpdu').datagrid('getSelected');
       var lpdu_form = data.LPDU_NUM;
       var lpdu_id = data.LPDU_ID;
       if (data) {
           $.ajax({
               url: 'Ulok/get_report_lpdu_detail/',
               type: 'POST',
               async: false,
               data: {

                   lpdu: lpdu_form
               },
               success: function(msg) {
                   var hasil = JSON.parse(msg);
                   if (hasil['REGION_ID']) {
                       var region = hasil['REGION_ID'];
                   } else {
                       var region = 0;
                   }
                   if (hasil['BRANCH_ID']) {
                       var cabang = hasil['BRANCH_ID'];
                   } else {
                       var cabang = 0;
                   }
                   var lpdu = replaceAll(data.LPDU_NUM, "/", "-");
                   window.open('Ulok/print_lap_penerimaan_ulok/' + cabang + '/' + data.PERIODE + '/' + lpdu + '/' + lpdu_id + '/0');
               }
           });

       } else {

       }

   }
   //end function lpdu

   //start datagrid
 

$("#data-log-status").datagrid({
    url: 'Ulok/get_data_log_status/',
    striped: true,
    rownumbers: true,
    remoteSort: true,
    singleSelect: false,
    pagination: true,
    fit: false,
    autoRowHeight: false,
    fitColumns: true,
    columns: [
        [{
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
 
  // datagrid inquirylog status
   $(document).ready(function() {


    //start ulok survey dan to survey
    $('#input-alasan-survey').textbox({
        editable: false
    });
    $('#input-alasan-status-ulok').textbox({
        editable: false
    });
    $('#search-no-form-to').textbox({
        inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
            keyup: function(e) {
                var code = e.keyCode || e.which;
                if (code == 13) { //Enter keycode
                    $("#search-inq-to").click();
                }
            }
        })
    });
    $('#search-nama-to').textbox({
        inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
            keyup: function(e) {
                var code = e.keyCode || e.which;
                if (code == 13) { //Enter keycode
                    $("#search-inq-to").click();
                }
            }
        })
    });
    $('#search-no-form-ulok').textbox({
        inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
            keyup: function(e) {
                var code = e.keyCode || e.which;
                if (code == 13) { //Enter keycode
                    $("#search-inq-ulok").click();
                }
            }
        })
    });

   $('#search-nama-ulok').textbox({
       inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
           keyup: function(e) {
               var code = e.keyCode || e.which;
               if (code == 13) { //Enter keycode
                   $("#search-inq-ulok").click();
               }
           }
       })
   });

   $('#search-lduk-no').textbox({
       inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
           keyup: function(e) {
               var code = e.keyCode || e.which;
               if (code == 13) { //Enter keycode
                   $("#search-inq-lduk").click();
               }
           }
       })
   });

   $('#search-lpdu-no').textbox({
       inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
           keyup: function(e) {
               var code = e.keyCode || e.which;
               if (code == 13) { //Enter keycode
                   $("#search-inq-lpdu").click();
               }
           }
       })
   });

   $('#search-form-survey').textbox({
       inputEvents: $.extend({}, $.fn.textbox.defaults.inputEvents, {
           keyup: function(e) {
               var code = e.keyCode || e.which;
               if (code == 13) { //Enter keycode
                   $("#search-inq-survey").click();
               }
           }
       })
   });

    $('#filesToUploadSurvey').on('change', function(evt) {
       var jumlah_file = document.getElementById('file_amount_survey').value;
       var ukuran_file = $("#filesToUploadSurvey")[0].files[0].size;

       if (ukuran_file > 3000000) {
           $.messager.alert('Warning', 'File size must not be more than 3 MB.');
           $('#filesToUploadSurvey').val('');
       }

       if (this.files.length == 0) {

           $.messager.alert('Warning', 'Anda tidak memilih file  .');

       }
       if (jumlah_file == 1) {

           $.messager.alert('Warning', 'Maximum file upload : 1 file  .');

       }


       if (ukuran_file < 3000000 && (jumlah_file >= 0 && jumlah_file < 1)) {
           var fileSelect = document.getElementById('filesToUploadSurvey');
           var files = fileSelect.files;
           var formData = new FormData();
           var tipe_form = 'ULOK_SURVEY';
           var form_num = replaceAll($('#input-survey-no-form').textbox('getValue'), "/", "-");
           for (var x = 0; x < files.length; x++) {
               var file = files[x];

               formData.append('filesToUploadSurvey', file, file.name);
               $.ajax({
                   url: 'Ulok/save_temp_file_ulok_survey/' + form_num,
                   type: 'POST',
                   async: false,
                   dataType: 'text',
                   cache: false,
                   contentType: false,
                   processData: false,
                   data: formData,
                   success: function(msg) {

                       $.ajax({
                           url: 'Ulok/insert_ulok_master_file/',
                           type: 'POST',
                           async: false,
                           data: {
                               form_num: form_num,
                               file_bukti_trf: msg,
                               tipe_form: tipe_form
                           },
                           success: function(msg) {
                               $.messager.alert('Warning', 'File berhasil diupload.');


                           }
                       });
                   }
               });
           }
           makeFileListSurveyUlok();
       }
   });

  $("#input_status_ulok").combobox({
      onChange: function(new_val, old_val) {
          $("#input-alasan-status-ulok").textbox('setValue', '');
          if (new_val == 'NOK' || new_val == 'Tdk Lanjut Buka') {

              $('#input-alasan-status-ulok').textbox('readonly', false);
              $('#input-alasan-status-ulok').textbox({
                  editable: true
              });
          } else {
              $('#input-alasan-status-ulok').textbox('readonly', true);
          }
      }
  });

$("#to_input_status_ulok").combobox({
    onChange: function(new_val, old_val) {
        $("#to-input-alasan-status-ulok").textbox('setValue', '');
        if (new_val == 'NOK' || new_val == 'Tdk Lanjut TO') {

            $('#to-input-alasan-status-ulok').textbox('readonly', false);
            $('#to-input-alasan-status-ulok').textbox({
                editable: true
            });
        } else {
            $('#to-input-alasan-status-ulok').textbox('readonly', true);
        }
    }
});

$("#generate-lpdu-cabang").combobox({
    onChange: function() {
        if ($('#generate-lpdu-cabang').combobox('getValue') != '') {
            /*  $('#generate-lpdu-region').combobox({
                              editable: false,
                              readonly: true
              });*/

        } else {
            /* $('#generate-lpdu-region').combobox({
                             editable: false,
                             readonly: false
             });*/

        }
    }
});
$("#generate-lduk-cabang").combobox({
    onChange: function() {
        if ($('#generate-lduk-cabang').combobox('getValue') != '') {
            /*  $('#generate-lduk-region').combobox({
                              editable: false,
                              readonly: true
              });*/

        } else {
            $('#generate-lduk-cabang').combobox({
                editable: false,
                readonly: false
            });

        }
    }
});
$("#search-lpdu-cabang").combobox({
    onChange: function() {
        if ($('#search-lpdu-cabang').combobox('getValue') != '') {
            /* $('#search-lpdu-region').combobox({
                             editable: false,
                             readonly: true
             });*/

        } else {
            /*    $('#search-lpdu-region').combobox({
                                editable: false,
                                readonly: false
                });*/

        }
    }
});
$("#cancel-req-generate-lpdu").click(function(event) {
    event.preventDefault();
    $('#generate-lpdu-cabang').combobox('select', '');
    $('#generate-lpdu-periode').combobox('select', '');
    $('#generate-lpdu-cabang').combobox({
        editable: true,
        readonly: false
    });
    $('#modal-generate-lpdu').window('close');

});
$("#cancel-req-generate-lduk").click(function(event) {
    event.preventDefault();
    $('#generate-lduk-cabang').combobox('select', '');
    $('#generate-lduk-periode').combobox('select', '');
    $('#modal-generate-lduk').window('close');
});
 $("#search-inq-to").click(function(event) {
     event.preventDefault();
     var noform_to = $('#search-no-form-to').textbox('getValue');
     var nama_to = $('#search-nama-to').textbox('getValue');
     var status_to = $('#search-status-to').combobox('getValue');
     var tanggal_mulai = $('#search-tgltrf-start-to').datebox('getValue');
     var tanggal_akhir = $('#search-tgltrf-end-to').datebox('getValue');
     var tanggal_form_mulai = $('#search-tglform-start-to').datebox('getValue');
     var tanggal_form_akhir = $('#search-tglform-end-to').datebox('getValue');

     if (noform_to == "" && nama_to == "" && status_to == "" && ((tanggal_mulai == "" && tanggal_akhir == "") || (tanggal_mulai != "" && tanggal_akhir == "") || (tanggal_mulai == "" && tanggal_akhir != "")) && ((tanggal_form_mulai == "" && tanggal_form_akhir == "") || (tanggal_form_mulai != "" && tanggal_form_akhir == "") || (tanggal_form_mulai == "" && tanggal_form_akhir != ""))) {
         $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
     } else if (noform_to != "" || nama_to != "" || status_to != "" || tanggal_mulai != "" || tanggal_akhir != "" || tanggal_form_mulai != "" || tanggal_form_akhir != "") {
         doSearchTO();
     }
 });
 $("#search-inq-status").click(function(event) {
     event.preventDefault();
     var noform = $('#search-no-form-status').textbox('getValue');

     if (noform == "") {
         $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
     } else if (noform != "") {
         doSearchLogStatus();
     }
 });

 $("#clear-inq-to").click(function(event) {
     event.preventDefault();
     $('#search-no-form-to').textbox('setValue', '');
     $('#search-nama-to').textbox('setValue', '');
     $('#search-tgltrf-start-to').datebox('setValue', '');
     $('#search-tgltrf-end-to').datebox('setValue', '');
     $('#search-tglform-start-to').datebox('setValue', '');
     $('#search-tglform-end-to').datebox('setValue', '');
     $('#search-status-to').combobox('select', '');
     $('#data-trx-to-toko').datagrid('load', {
         noform_to: null,
         nama_to: null,
         status_to: null,
         tanggal_mulai: null,
         tanggal_akhir: null,
         tanggal_form_mulai: null,
         tanggal_form_akhir: null
     });
 });
 $("#clear-inq-status").click(function(event) {
     event.preventDefault();
     $('#search-no-form-status').textbox('setValue', '');
     $('#data-log-status').datagrid('reload');

 });
 $("#cancel-otp-to").click(function(event) {
     event.preventDefault();
     $('#input-otp-to').textbox('setValue', '');
 });

 $("#cancel-otp-ulok").click(function(event) {
     event.preventDefault();
     $('#input-otp-ulok').textbox('setValue', '');
 });

  $("#submit-ulok").click(function(event) {
      event.preventDefault();
      $('#submit-ulok').linkbutton('disable');
      var ids = [];
      var status_cbg = 'F-OK';
      var rows = $('#data-survey-ulok-toko').datagrid('getSelections');
      for (var i = 0; i < rows.length; i++) {
          ids.push(rows[i].FORM_ID);
          if (rows[i].STATUS_CABANG != 'F-OK' && rows[i].STATUS_CABANG != 'F-NOK') {

              $.ajax({
                  url: 'Ulok/update_ulok_trx_status_cbg/',
                  type: 'POST',
                  async: false,
                  data: {
                      status: rows[i].STATUS_CABANG,
                      form_id: rows[i].FORM_ID,
                      tipe_form: rows[i].TIPE_FORM
                  },
                  success: function(msg) {
                      $('#data-survey-ulok-toko').datagrid('reload');
                      $.messager.alert('Warning', 'Data berhasil diupdate');
                  }
              });
          }
      }
      $('#submit-ulok').linkbutton('enable');
  });


  $("#finalisasi-ulok").click(function(event) {
      event.preventDefault();
      $('#finalisasi-ulok').linkbutton('disable');
      var ids = [];
      var rows = $('#data-survey-ulok-toko').datagrid('getSelections');
      for (var i = 0; i < rows.length; i++) {
          ids.push(rows[i].FORM_ID);
          if (rows[i].STATUS_CABANG == 'F-OK') {
              var status_ho = 'FINAL-OK';
          } else if (rows[i].STATUS_CABANG == 'F-NOK') {
              var status_ho = 'FINAL-NOK';
          }
          $.ajax({
              url: 'Ulok/update_ulok_trx_status_HO/',
              type: 'POST',
              async: false,
              data: {
                  status: status_ho,
                  form_id: rows[i].FORM_ID,
                  tipe_form: rows[i].TIPE_FORM
              },
              success: function(msg) {
                  $('#data-survey-ulok-toko').datagrid('reload');
                  $.messager.alert('Warning', 'Data berhasil diupdate');
              }
          });
      }
      $('#finalisasi-ulok').linkbutton('enable');
  });

$("#submit-survey-ulok").click(function(event) {
    event.preventDefault();
    $('#submit-survey-ulok').linkbutton('disable');
    var rows = $('#data-survey-ulok-toko').datagrid('getSelected');
    var form_id = $('#input-survey-no-form').textbox('getValue');
    var survey_tgl = $("#input-survey-tgl-survey").datebox('getValue');
    var tgl_survey = survey_tgl.substr(6, 4) + '-' + survey_tgl.substr(3, 2) + '-' + survey_tgl.substr(0, 2);
    var hasil_survey = $("#input_hasil_survey").combobox('getValue');
    var alasan_survey = $("#input-alasan-survey").textbox('getValue');
    var alasan_survey_length = $("#input-alasan-survey").textbox('getValue').length;
    if ($("#input-survey-tgl-penyampai-survey").datebox('getValue') != '') {
        var penyampai_survey = $("#input-survey-tgl-penyampai-survey").datebox('getValue');
        var tgl_penyampai_survey = penyampai_survey.substr(6, 4) + '-' + penyampai_survey.substr(3, 2) + '-' + penyampai_survey.substr(0, 2);

    } else {
        var tgl_penyampai_survey = null;
    }
    var status_ulok = null;
    var alasan_status_ulok = $("#input-alasan-status-ulok").textbox('getValue');
    var alasan_status_ulok_length = $("#input-alasan-status-ulok").textbox('getValue').length;
    var jumlah_file = $('#file_amount_survey').textbox('getValue');
    var tipe_form = 'ULOK';


    if ($("#input_status_ulok").combobox('getValue') == 'Lanjut Buka' || $("#input_status_ulok").combobox('getValue') == 'OK') {
        status_ulok = 'OK';
    } else if ($("#input_status_ulok").combobox('getValue') == 'Tdk Lanjut Buka' || $("#input_status_ulok").combobox('getValue') == 'NOK') {
        status_ulok = 'NOK';
    } else {
        status_ulok = '';
    }
    if (($('#session-role').textbox('getValue') == '5')) {
        if (((status_ulok == '') || (status_ulok == 'OK' && alasan_status_ulok == '') || (status_ulok == 'NOK' && alasan_status_ulok_length >= 10)) && ((hasil_survey == 'OK' && alasan_survey == '') || (hasil_survey == 'NOK' && alasan_survey_length >= 10)) && tgl_penyampai_survey != '' && (jumlah_file != '' && jumlah_file != '0')) {

            $.ajax({
                url: 'Ulok/update_ulok_survey_by_frc_mgr/',
                type: 'POST',
                async: false,
                data: {
                    hasil_survey: hasil_survey,
                    alasan_survey: alasan_survey,
                    tgl_penyampai_survey: tgl_penyampai_survey,
                    tipe_form: tipe_form,
                    form_id: form_id
                },
                success: function(msg) {
                    $('#data-survey-ulok-toko').datagrid('reload');
                    $.messager.alert('Warning', 'Data berhasil diupdate');
                    $("#modal-input-hasil-survey-ulok").window('close');

                }
            });
        } else {
            if ((jumlah_file == '' || jumlah_file == 0)) {
                $.messager.alert('Warning', 'Harap lengkapi file upload terlebih dahulu');
            } else {
                if (alasan_status_ulok_length < 10) {

                    $.messager.alert('Warning', 'Harap lengkapi data terlebih dahulu,alasan min 10 karakter');
                } else if (alasan_survey_length < 10) {

                    $.messager.alert('Warning', 'Harap lengkapi data terlebih dahulu,alasan min 10 karakter');
                } else {
                    $.messager.alert('Warning', 'Harap lengkapi data terlebih dahulu');
                }
            }
        }

    }
     if (($('#session-role').textbox('getValue') == '1') || ($('#session-role').textbox('getValue') == '2')) {


        if (tgl_survey != '' && ((
                    (status_ulok == '') ||
                    (status_ulok == 'OK' && tgl_penyampai_survey != '') ||
                    (status_ulok == 'Lanjut Buka' && tgl_penyampai_survey != '') ||
                    (status_ulok == 'NOK' && alasan_status_ulok_length >= 10 && tgl_penyampai_survey != '') ||
                    (status_ulok == 'Tdk Lanjut Buka' && alasan_status_ulok_length >= 10 && tgl_penyampai_survey != '')) &&
                (hasil_survey == 'OK') || (hasil_survey == 'NOK' && alasan_survey_length >= 10)) &&
            form_id != '' && (jumlah_file != 0)) {

            $.ajax({
                url: 'Ulok/update_ulok_survey_trx/',
                type: 'POST',
                async: false,
                data: {
                    tgl_survey: tgl_survey,
                    hasil_survey: hasil_survey,
                    alasan_survey: alasan_survey,
                    tgl_penyampai_survey: tgl_penyampai_survey,
                    status_ulok: status_ulok,
                    alasan_status_ulok: alasan_status_ulok,
                    tipe_form: tipe_form,
                    form_id: form_id
                },
                success: function(msg) {
                    if (msg == 'HANGUS') {
                        var tipe_form = 'ULOK';
                        $.ajax({
                            url: 'Ulok/generate_bapp/',
                            type: 'POST',
                            async: false,
                            data: {
                                form_num: $('#input-survey-no-form').textbox('getValue'),
                                tipe_form: tipe_form
                            },
                            success: function(msg) {

                                window.open('Ulok/print_form_bapp/' + msg);

                            }
                        });
                    }
                    $('#data-survey-ulok-toko').datagrid('reload');
                    $.messager.alert('Warning', 'Data berhasil diupdate');
                    $("#modal-input-hasil-survey-ulok").window('close');

                }
            });

        } else {
            if ((jumlah_file == '' || jumlah_file == 0)) {
                $.messager.alert('Warning', 'Harap upload data terlebih dahulu');

            } else {
                if (alasan_status_ulok_length < 10) {

                    $.messager.alert('Warning', 'Harap lengkapi data terlebih dahulu,alasan status ulok min 10 karakter');
                } else if (alasan_survey_length < 10) {

                    $.messager.alert('Warning', 'Harap lengkapi data terlebih dahulu,alasan status survey min 10 karakter');
                } else {
                    $.messager.alert('Warning', 'Harap lengkapi data terlebih dahulu');
                }
            }
        }
    } else if ($('#session-role').textbox('getValue') == '4') {
        $.messager.alert('Warning', 'Tidak bisa mengubah data');

    }
    $('#submit-survey-ulok').linkbutton('enable');
});
  $("#cancel-survey-ulok").click(function(event) {
      event.preventDefault();
      $('#modal-input-hasil-survey-ulok').window('close');
  });
  $("#validate-ulok-status").click(function(event) {
      event.preventDefault();
      var ids = [];
      var rows = $('#data-trx-frc-cab').datagrid('getSelected');
      if (rows != "") {
          for (var i = 0; i < rows.length; i++) {
              ids.push(rows[i].FORM_NUM);
          }
          $("#otp-update-status-ulok").window('open');
      } else {
          $.messager.alert('Warning', 'Harap pilih data terlebih dahulu');
      }
  });

  $("#generate-lpdu").click(function(event) {
      event.preventDefault();
      $('#generate-lpdu').linkbutton('disable');
      $('#generate-lpdu-cabang').combobox('select', '');
      $('#generate-lpdu-periode').combobox('select', '');
      $.ajax({
          url: 'Ulok/generate_lpdu_num/',
          type: 'POST',
          async: false,
          data: {

          },
          success: function(msg) {
              var hasil = JSON.parse(msg);

              $('#lpdu').textbox('setValue', hasil);
          }
      });
      $('#content').panel('refresh');
      $('#generate-lpdu').linkbutton('enable');
      $('#modal-generate-lpdu').window('open');
  });


   $("#generate-lduk").click(function(event) {
       event.preventDefault();
       $('#generate-lduk').linkbutton('disable');
       $('#generate-lduk-cabang').combobox('select', '');
       $('#generate-lduk-periode').combobox('select', '');
       $.ajax({
           url: 'Ulok/generate_lduk_num/',
           type: 'POST',
           async: false,
           success: function(msg) {
               var hasil = JSON.parse(msg);
               //document.getElementById('lduk').value=new String(hasil);
               $('#lduk_num').textbox('setValue', hasil);
           }
       });
       $('#content').panel('refresh');
       $('#generate-lduk').linkbutton('enable');
       $('#modal-generate-lduk').window('open');
   });

    $("#submit-req-generate-lduk").click(function(event) {
       event.preventDefault();
       $('#submit-req-generate-lduk').linkbutton('disable');
       var cabang = $('#generate-lduk-cabang').combobox('getValue');
       var region = '';
       var periode = $('#generate-lduk-periode').combobox('getValue');
       var lduk_form = $('#lduk_num').textbox('getValue');
       var lduk = replaceAll(lduk_form, "/", "-");
       if ((cabang != '' && periode != '') || (region != '' && periode != '')) {
           if (region == '') {
               $.ajax({
                   url: 'Ulok/count_data_lduk/',
                   type: 'POST',
                   async: false,
                   data: {
                       cabang: cabang,
                       region: region,
                       periode: periode
                   },
                   success: function(msg) {
                       if (msg > 0) {
                           $.ajax({
                               url: 'Ulok/generate_lduk/',
                               type: 'POST',
                               async: false,
                               data: {
                                   cabang: cabang,
                                   region: region,
                                   periode: periode,
                                   lduk: lduk_form
                               },
                               success: function(msg) {
                                   $.ajax({
                                       url: 'Ulok/get_lduk_id/',
                                       type: 'POST',
                                       async: false,
                                       data: {
                                           lduk_form_num: $('#lduk_num').textbox('getValue')
                                       },
                                       success: function(msg) {
                                           var id = JSON.parse(msg);
                                           if (cabang == '' && region != '') {
                                               window.open('Ulok/print_laporan_uangmuka_kembali/0/' + region + '/' + periode + '/' + lduk + '/' + id + '/1');

                                               $('#modal-generate-lduk').window('close');

                                               $('#data-list-lduk').datagrid('load', {
                                                   noform_lduk: null,
                                                   periode: null,
                                                   region: null,
                                                   cabang: null
                                               });
                                           } else if (cabang != '' && region == '') {
                                               window.open('Ulok/print_laporan_uangmuka_kembali/' + cabang + '/' + periode + '/' + lduk + '/' + id + '/1');
                                               $('#modal-generate-lduk').window('close');
                                               $('#data-list-lduk').datagrid('load', {
                                                   noform_lduk: null,
                                                   periode: null,
                                                   region: null,
                                                   cabang: null
                                               });
                                           }
                                           $.messager.alert('Warning', 'Data has been updated .');
                                           $('#data-list-lduk').datagrid('reload');

                                       }
                                   });
                               }
                           });
                       } else {
                           $('#modal-generate-lduk').window('close');
                           $.messager.alert('Warning', 'Tidak ada data baru di LDUK .');

                       }
                   }
               });

           } else if (cabang == '') {
               $.ajax({
                   url: 'Ulok/count_data_lduk/',
                   type: 'POST',
                   async: false,
                   data: {
                       cabang: cabang,
                       region: region,
                       periode: periode
                   },
                   success: function(msg) {

                       if (msg > 0) {
                           $.ajax({
                               url: 'Ulok/get_branch_from_region/',
                               type: 'POST',
                               async: false,
                               data: {
                                   region: region
                               },
                               success: function(msg) {
                                   var hasil_cbg = JSON.parse(msg);

                                   $('#modal-generate-lduk').window('close');

                                   $.messager.alert('Warning', 'Data has been updated .');
                               }
                           });
                       } else {
                           $('#modal-generate-lduk').window('close');
                           $.messager.alert('Warning', 'Tidak ada data baru di LDUK .');
                       }
                   }
               });
           }
           $('#generate-lduk-cabang').combobox('select', '');
           $('#generate-lduk-periode').combobox('select', '');
       }
       $('#submit-req-generate-lduk').linkbutton('enable');
   });


   $("#validate-to-status").click(function(event) {
       event.preventDefault();
       $('#validate-to-status').linkbutton('disable');
       var ids = [];
       var rows = $('#data-trx-to-toko').datagrid('getSelections');
       if (rows != "") {
           for (var i = 0; i < rows.length; i++) {
               ids.push(rows[i].FORM_NUM);
           }

           $("#otp-update-status-to").window('open');
       } else {
           $.messager.alert('Warning', 'Harap pilih data terlebih dahulu');
       }
       $('#validate-to-status').linkbutton('enable');


   });
    $("#submit-req-generate-lpdu").click(function(event) {
     event.preventDefault();
     $('#submit-req-generate-lpdu').linkbutton('disable');
     var cabang = $('#generate-lpdu-cabang').combobox('getValue');
     var region = "";
     var periode = $('#generate-lpdu-periode').combobox('getValue');
     var lpdu_form = $('#lpdu').textbox('getValue');
     var lpdu = replaceAll(lpdu_form, "/", "-"); 

     if ((cabang == '' || periode == '')) {
         $.messager.alert('Warning', 'Harap lengkapi parameter.');
         alert(cabang);
     }else if ((cabang != '' && periode != '') || (region != '' && periode != '')) {

         if (region == '' && cabang != '0') {

             $.ajax({
                 url: 'Ulok/count_data_lpdu/',
                 type: 'POST',
                 async: false,
                 data: {
                     cabang: cabang,
                     region: region,
                     periode: periode
                 },
                 success: function(msg) {

                     if (msg > 0) {

                         $.ajax({
                             url: 'Ulok/generate_lpdu/',
                             type: 'POST',
                             async: false,
                             data: {
                                 cabang: cabang,
                                 region: region,
                                 periode: periode,
                                 lpdu: lpdu_form
                             },
                             success: function(msg) {
                                 $.ajax({
                                     url: 'Ulok/get_form_num_from_lpdu/',
                                     type: 'POST',
                                     async: false,
                                     data: {
                                         cabang: cabang,
                                         periode: periode
                                     },
                                     success: function(msg) {
                                         var hasil = JSON.parse(msg);
                                         var status_awal = 'N';
                                         var status_akhir = 'FIN';
                                         for (var i = 0; i < hasil.length; i++) {
                                             $.ajax({
                                                 url: 'Ulok/update_status_cbg/',
                                                 type: 'POST',
                                                 async: false,
                                                 data: {
                                                     ulok_form_num: hasil[i]['ULOK_FORM_NUM'],
                                                     status_awal: status_awal,
                                                     status_akhir: status_akhir,
                                                     tipe_form: hasil[i]['TIPE_FORM']
                                                 },
                                                 success: function(msg) {

                                                 }
                                             });
                                         }
                                     }
                                 });
                             }
                         });

                         $.ajax({
                             url: 'Ulok/get_lpdu_id/',
                             type: 'POST',
                             async: false,
                             data: {
                                 lpdu_form_num: $('#lpdu').textbox('getValue')

                             },
                             success: function(msg) {
                                 var id = JSON.parse(msg);
                                 if (cabang == '' && region != '') {
                                     window.open('Ulok/print_lap_penerimaan_ulok/0/' + region + '/' + periode + '/' + lpdu + '/' + id + '/1');

                                     $('#modal-generate-lpdu').window('close');

                                     $('#data-list-lpdu').datagrid('load', {
                                         noform_lpdu: null,
                                         periode: null,
                                         region: null,
                                         cabang: null
                                     });
                                 } else if (cabang != '' && region == '') {

                                     window.open('Ulok/print_lap_penerimaan_ulok/' + cabang + '/' + periode + '/' + lpdu + '/' + id + '/1');
                                     $('#modal-generate-lpdu').window('close');
                                     $('#data-list-lpdu').datagrid('load', {
                                         noform_lpdu: null,
                                         periode: null,
                                         region: null,
                                         cabang: null
                                     });
                                 }
                             }
                         });
                     } else {
                         $('#modal-generate-lpdu').window('close');
                         $.messager.alert('Warning', 'Tidak ada data baru di LPDU .');
                     }
                 }
             });
             $('#generate-lpdu-cabang').combobox('select', '');
             $('#generate-lpdu-periode').combobox('select', '');
             $('#data-list-lpdu').datagrid('reload');

         } else if (cabang == '0') {
             $.ajax({
                 url: 'Ulok/count_data_lpdu/',
                 type: 'POST',
                 async: false,
                 data: {
                     cabang: cabang,
                     region: region,
                     periode: periode
                 },
                 success: function(msg) {

                     if (msg > 0) {

                         $.ajax({
                             url: 'Ulok/generate_lpdu/',
                             type: 'POST',
                             async: false,
                             data: {
                                 cabang: cabang,
                                 region: region,
                                 periode: periode,
                                 lpdu: lpdu_form
                             },
                             success: function(msg) {
                                 $.ajax({
                                     url: 'Ulok/get_form_num_from_lpdu/',
                                     type: 'POST',
                                     async: false,
                                     data: {
                                         cabang: cabang,
                                         periode: periode
                                     },
                                     success: function(msg) {
                                         var hasil = JSON.parse(msg);
                                         var status_awal = 'N';
                                         var status_akhir = 'FIN';
                                         for (var i = 0; i < hasil.length; i++) {
                                             $.ajax({
                                                 url: 'Ulok/update_status_cbg/',
                                                 type: 'POST',
                                                 async: false,
                                                 data: {
                                                     ulok_form_num: hasil[i]['ULOK_FORM_NUM'],
                                                     status_awal: status_awal,
                                                     status_akhir: status_akhir,
                                                     tipe_form: hasil[i]['TIPE_FORM']
                                                 },
                                                 success: function(msg) {



                                                 }
                                             });
                                         }
                                     }
                                 });
                             }
                         });
                         $.ajax({
                             url: 'Ulok/get_lpdu_id/',
                             type: 'POST',
                             async: false,
                             data: {
                                 lpdu_form_num: $('#lpdu').textbox('getValue')

                             },
                             success: function(msg) {

                                 var id = JSON.parse(msg);


                                 if (cabang == '' && region != '') {
                                     window.open('Ulok/print_lap_penerimaan_ulok/0/' + region + '/' + periode + '/' + lpdu + '/' + id + '/1');

                                     $('#modal-generate-lpdu').window('close');

                                     $('#data-list-lpdu').datagrid('load', {
                                         noform_lpdu: null,
                                         periode: null,
                                         region: null,
                                         cabang: null
                                     });
                                 } else if (cabang != '' && region == '') {

                                     window.open('Ulok/print_lap_penerimaan_ulok/' + cabang + '/' + periode + '/' + lpdu + '/' + id + '/1');
                                     $('#modal-generate-lpdu').window('close');
                                     $('#data-list-lpdu').datagrid('load', {
                                         noform_lpdu: null,
                                         periode: null,
                                         region: null,
                                         cabang: null
                                     });
                                 }
                             }
                         });
                     } else {
                         $('#modal-generate-lpdu').window('close');
                         $.messager.alert('Warning', 'Tidak ada data baru di LPDU .');
                     }

                 }
             });
             $('#generate-lpdu-cabang').combobox('select', '');
             $('#generate-lpdu-periode').combobox('select', '');
             $('#data-list-lpdu').datagrid('reload');
         }
     }
    $('#submit-req-generate-lpdu').linkbutton('enable');
 });

$("#print-formulir-pengajuan-to-toko").click(function(event) {
     event.preventDefault();
     window.open('Ulok/print_form_pengajuan_to_toko');
 });

$("#print-listing-status-ulok").click(function(event) {
      event.preventDefault();
      var session_role = $('#session-role').textbox('getValue');
      var session_branch_id = $('#session-branch-id').textbox('getValue');
      if (session_role == '5' || session_role == '2') {
          $('#show-cabang').combobox('select', session_branch_id);
          $('#show-cabang').combobox('readonly', true);
          $('#show-periode').combobox('select', '');
          $('#div_session_branch_id').hide();
          $('#modal-req-liststatusulok').window('open');
          //frc manager 
      } else if (session_role == '4' || session_role == '1' || session_role == '3') {
          //rfm dan admin
          $('#show-cabang').combobox('select', '');
          $('#show-periode').combobox('select', '');
          $('#div_session_branch_id').hide();
          $('#modal-req-liststatusulok').window('open');
      } else if (session_role != '4' && session_role != '1' && session_role != '2' && session_role != '5') {
          $.messager.alert('Warning', 'Maaf,Anda tidak punya hak akses akses');
          alert(session_role);
      }
  });

$("#print-listing-status-to").click(function(event) {
     event.preventDefault();
     var session_role = $('#session-role-to').textbox('getValue');
     var session_branch_id = $('#session-branch-id-to').textbox('getValue');
     if (session_role == '5' || session_role == '2') {
         $('#div_session_branch_id_to').hide();
         $('#show-cabang-to').combobox('select', session_branch_id);
         $('#show-cabang-to').combobox('readonly', true);
         $('#modal-req-liststatusto').window('open');
         //frc manager 
     } else if (session_role == '4' || session_role == '1' || session_role == '3') {
         //rfm dan admin
         $('#div_session_branch_id_to').hide();
         $('#modal-req-liststatusto').window('open');
     } else if (session_role != '4' && session_role != '1' && session_role != '2' && session_role != '5') {
         $.messager.alert('Warning', 'Maaf,Anda tidak punya hak akses ');
     }
 });

    $("#submit-req-liststatusulok").click(function(event) {
       event.preventDefault();
       $('#submit-req-liststatusulok').linkbutton('disable');
       var cabang = $('#show-cabang').combobox('getValue');
       var periode = $('#show-periode').combobox('getValue');
       if (cabang != '' && periode != '') {
           $.ajax({
               url: 'Ulok/count_listing_status_ulok/',
               type: 'POST',
               async: false,
               data: {
                   cabang: cabang,
                   periode: periode
               },
               success: function(msg) {

                   if (msg > 0) {
                       window.open('Ulok/print_listing_status_ulok_calon_franchisee/' + cabang + '/' + periode);
                       $('#modal-req-liststatusulok').window('close');
                   } else {

                       $.messager.alert('Warning', 'Tidak ada data baru');
                   }
               }
           });
       } else {
           $.messager.alert('Warning', 'Parameter tidak lengkap');
       }
       $('#submit-req-liststatusulok').linkbutton('enable');
   });
    $("#submit-req-liststatusto").click(function(event) {
       event.preventDefault();
       $('#submit-req-liststatusto').linkbutton('disable');
       var cabang = $('#show-cabang-to').combobox('getValue');
       var periode = $('#show-periode-to').combobox('getValue');
       if (cabang != '' && periode != '') {
           $.ajax({
               url: 'Ulok/count_listing_status_to/',
               type: 'POST',
               async: false,
               data: {
                   cabang: cabang,
                   periode: periode
               },
               success: function(msg) {

                   if (msg > 0) {
                       window.open('Ulok/print_listing_status_to_calon_franchisee/' + cabang + '/' + periode);
                       $('#modal-req-liststatusto').window('close');
                   } else {

                       $.messager.alert('Warning', 'Tidak ada data baru');
                   }
               }
           });

       } else {
           $.messager.alert('Warning', 'Parameter tidak lengkap');

       }
       $('#submit-req-liststatusto').linkbutton('enable');
   });

    $("#search-inq-ulok").click(function(event) {
     event.preventDefault();
     var noform_ulok = $('#search-no-form-ulok').textbox('getValue');
     var nama_ulok = $('#search-nama-ulok').textbox('getValue');
     var status_ulok = $('#search-status-ulok').combobox('getValue');
     var tanggal_mulai = $('#search-tgltrf-start-ulok').datebox('getValue');
     var tanggal_akhir = $('#search-tgltrf-end-ulok').datebox('getValue');
     var tanggal_form_mulai = $('#search-tglform-start-ulok').datebox('getValue');
     var tanggal_form_akhir = $('#search-tglform-end-ulok').datebox('getValue');

     if (noform_ulok == "" && nama_ulok == "" && status_ulok == "" && ((tanggal_mulai == "" && tanggal_akhir == "") || (tanggal_mulai != "" && tanggal_akhir == "") || (tanggal_mulai == "" && tanggal_akhir != "")) && ((tanggal_form_mulai == "" && tanggal_form_akhir == "") || (tanggal_form_mulai != "" && tanggal_form_akhir == "") || (tanggal_form_mulai == "" && tanggal_form_akhir != ""))) {
         $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
     } else if (noform_ulok != "" || nama_ulok != "" || status_ulok != "" || tanggal_mulai != "" || tanggal_akhir != "" || tanggal_form_mulai != "" || tanggal_form_akhir != "") {
         doSearchUlok();
     }

 });

    $("#search-inq-lpdu").click(function(event) {
        event.preventDefault();
        var noform_lpdu = $('#search-lpdu-no').textbox('getValue');
        var periode = $('#search-lpdu-periode').combobox('getValue');
        //  var region = $('#search-lpdu-region').combobox('getValue');
        var cabang = $('#search-lpdu-cabang').combobox('getValue');
        var region = "";
        if (noform_lpdu == "" && periode == "" && region == "" && cabang == "") {
            $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
        } else if (noform_lpdu != "" || periode != "" || region != "" || cabang != "") {
            doSearchLPDU();
        }

    });
     $("#search-inq-lduk").click(function(event) {
        event.preventDefault();
        var noform_lduk = $('#search-lduk-no').textbox('getValue');
        var periode = $('#search-periode-lduk').combobox('getValue');
        //var region = $('#search-region-lduk').combobox('getValue');
        var region = '';
        var cabang = $('#search-lduk-cabang').combobox('getValue');
        if (noform_lduk == "" && periode == "" && region == "" && cabang == "") {
             $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
        } else if (noform_lduk != "" || periode != "" || region != "" || cabang != "") {
            doSearchLDUK();
        }
    });
$("#clear-inq-ulok").click(function(event) {
    event.preventDefault();
    $('#search-no-form-ulok').textbox('setValue', '');
    $('#search-nama-ulok').textbox('setValue', '');
    $('#search-tgltrf-start-ulok').datebox('setValue', '');
    $('#search-tgltrf-end-ulok').datebox('setValue', '');
    $('#search-tglform-start-ulok').datebox('setValue', '');
    $('#search-tglform-end-ulok').datebox('setValue', '');
    $('#search-status-ulok').combobox('select', '');
    $('#data-trx-frc-cab').datagrid('load', {
        noform_ulok: null,
        nama_ulok: null,
        status_ulok: null,
        tanggal_mulai: null,
        tanggal_akhir: null,
        tanggal_form_mulai: null,
        tanggal_form_akhir: null
    });
    //$('#content').panel('refresh'); 
});
$("#clear-inq-lpdu").click(function(event) {
      event.preventDefault();
      $('#search-lpdu-no').textbox('setValue', '');
      $('#search-lpdu-cabang').combobox('select', '');
      $('#search-lpdu-periode').combobox('select', '');
      $('#data-list-lpdu').datagrid('load', {
          noform_lpdu: null,
          periode: null,
          region: null,
          cabang: null
      });
      //$('#content').panel('refresh'); 
});
$("#clear-inq-lduk").click(function(event) {
    event.preventDefault();
    $('#search-lduk-no').textbox('setValue', '');
    $('#search-lduk-cabang').combobox('select', '');
    $('#search-periode-lduk').combobox('select', '');
        //  $('#search-region-lduk').combobox('select', '');

    $('#data-list-lduk').datagrid('load', {
        noform_lduk: null,
        periode: null,
        region: null,
        cabang: null
        });
        // $('#content').panel('refresh'); 
});
    $("#clear-inq-survey").click(function(event) {
        event.preventDefault();
        $('#search-form-survey').textbox('setValue', '');
        $('#search-tglsurvey-start-to').datebox('setValue', '');
        $('#search-tglsurvey-end-to').datebox('setValue', '');
        $('#search-status-cabang-survey').combobox('select', '');
        $('#data-survey-ulok-toko').datagrid('load', {
            noform: null,
            status_cbg: null,
            tanggal_mulai: null,
            tanggal_akhir: null
        });
    });


$("#submit-penyampaian-proposal-to").click(function(event) {
    event.preventDefault();
    $('#submit-penyampaian-proposal-to').linkbutton('disable');
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + day;
    var penyampai_survey = $("#to-input-survey-tgl-penyampai-survey").datebox('getValue');
    var tgl_penyampai_survey = penyampai_survey.substr(6, 4) + '-' + penyampai_survey.substr(3, 2) + '-' + penyampai_survey.substr(0, 2);

    if ($('#to_input_status_ulok').combobox('getValue') == 'Lanjut TO' || $('#to_input_status_ulok').combobox('getValue') == 'OK') {

        var status_ulok = "OK";
    } else if ($('#to_input_status_ulok').combobox('getValue') == 'Tdk Lanjut TO' || $('#to_input_status_ulok').combobox('getValue') == 'NOK') {
        var status_ulok = "NOK";
    } else {
        var status_ulok = null;
    }
    var alasan_status_ulok = $('#to-input-alasan-status-ulok').textbox('getValue');
    var alasan_status_ulok_length = $('#to-input-alasan-status-ulok').textbox('getValue').length;
    var tipe_form = 'TO';
    var tgl_survey = output;
    var hasil_survey = 'OK';
    var alasan_survey = null;
    var form_id = $('#to-input-no-form').textbox('getValue');
    if (tgl_penyampai_survey != '' && (status_ulok == '' || status_ulok == 'OK' || (status_ulok == 'NOK' && alasan_status_ulok_length >= 10))) {
        $.ajax({
            url: 'Ulok/update_ulok_survey_trx/',
            type: 'POST',
            async: false,
            data: {
                tgl_survey: tgl_survey,
                hasil_survey: hasil_survey,
                alasan_survey: alasan_survey,
                tgl_penyampai_survey: tgl_penyampai_survey,
                status_ulok: status_ulok,
                alasan_status_ulok: alasan_status_ulok,
                tipe_form: tipe_form,
                form_id: form_id

            },
            success: function(msg) {
                $.messager.alert('Warning', 'Data berhasil diupdate');
                $('#data-survey-ulok-toko').datagrid('reload');
                $('#modal-input-hasil-penyampaian-to').window('close');
            }
        });
    } else {

        $.messager.alert('Warning', 'Harap Lengkapi data terlebih dahulu');
    }
    $('#submit-penyampaian-proposal-to').linkbutton('enable');
});

   $("#cancel-penyampaian-proposal-to").click(function(event) {
       event.preventDefault();

       $('#modal-input-hasil-penyampaian-to').window('close');
   });

   $("#search-inq-survey").click(function(event) {
       event.preventDefault();
       var noform_ulok = $('#search-form-survey').textbox('getValue');
       var tanggal_mulai = $('#search-tglsurvey-start-to').datebox('getValue');
       var tanggal_akhir = $('#search-tglsurvey-end-to').datebox('getValue');
       //var status_ho = $('#search-status-ho-survey').combobox('getValue');

       var status_cbg = $('#search-status-cabang-survey').combobox('getValue');

       if (noform_ulok == "" && status_cbg == "" && ((tanggal_mulai == "" && tanggal_akhir == "") || (tanggal_mulai != "" && tanggal_akhir == "") || (tanggal_mulai == "" && tanggal_akhir != ""))) {
           $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
       } else if (noform_ulok != "" || status_cbg != "" || tanggal_mulai != "" || tanggal_akhir != "") {
           doSearchUlokSurvey();
       }

   });

   $("#cancel-req-liststatusulok").click(function(event) {
       event.preventDefault();
       $('#show-cabang').combobox('select', '');
       $('#show-periode').combobox('select', '');
       $('#modal-req-liststatusulok').window('close');

   });

   $('#cancel-otp-lduk').click(function(event) {
       event.preventDefault();

       $('#input-otp-lduk').textbox('setValue', '');
       $('#otp-validasi-lduk').window('close');

   });

   $('#cancel-otp-lpdu').click(function(event) {
       event.preventDefault();
       $('#input-otp-lpdu').textbox('setValue', '');
       $('#"otp-validasi-lpdu').window('close');
   });

   $('#cancel-otp-reject-ulok').click(function(event) {
       event.preventDefault();
       $('#input-otp-reject-ulok').textbox('setValue', '');
       $('#input-alasan-reject-ulok').textbox('setValue', '');

   });

   $('#cancel-otp-reject-to').click(function(event) {
       event.preventDefault();
       $('#input-otp-reject-to').textbox('setValue', '');
       $('#input-alasan-reject-to').textbox('setValue', '');
       $('#otp-reject-to').window('close');

   });
$('#submit-otp-reject-ulok').click(function(event) {
    event.preventDefault();
    $('#submit-otp-reject-ulok').linkbutton('disable');
    var password = $('#input-otp-reject-ulok').textbox('getValue');
    var ref_num = $('#input-ref-num-ulok').textbox('getValue');
    var alasan_reject = $('#input-alasan-reject-ulok').textbox('getValue');
    var ids = [];
    var tipe_form = 'REJECTUlok';
    if (password != '' && alasan_reject.length >= 10) {

        $.ajax({
            url: 'Ulok/submit_otp/',
            type: 'POST',
            async: false,
            data: {
                ref_num: ref_num,
                input_otp: password,
                tipe_form: tipe_form
            },
            success: function(msg) {
                var res = JSON.parse(msg);

                if (res['hasil'] == 'success') {
                    var rows = $('#data-trx-frc-cab').datagrid('getSelected');
                    var status_ho = 'REJECT';
                    var status_cbg = 'REJECT';
                    var tipe_form = 'ULOK';
                    $.ajax({
                        url: 'Ulok/update_ulok_trx_status_HO_cabang/',
                        type: 'POST',
                        async: false,
                        data: {

                            status_ho: status_ho,
                            status_cbg: status_cbg,
                            form_id: rows.FORM_NUM,
                            tipe_form: tipe_form,
                            alasan_reject: alasan_reject
                        },
                        success: function(msg) {
                            $.messager.alert('Warning', 'Data Ulok berhasil direject');
                            $('#data-trx-frc-cab').datagrid('reload');

                        }
                    });
                    $('#otp-reject-ulok').window('close')

                } else  if (res['hasil'] != 'success')  {
                    $.messager.alert('Warning', 'Password salah');
                }
            }
        });
    } else {
        $.messager.alert('Warning', 'Anda belum menginput OTP dan alasan Reject min 10 karakter.');
    }
    $('#submit-otp-reject-ulok').linkbutton('enable');
});

$('#submit-otp-reject-to').click(function(event) {
     event.preventDefault();
    $('#submit-otp-reject-to').linkbutton('disable');
     var password = $('#input-otp-reject-to').textbox('getValue');
     var ref_num = $('#input-ref-num-to').textbox('getValue');
     var alasan_reject = $('#input-alasan-reject-to').textbox('getValue');
     var ids = [];
     var tipe_form = 'REJECTTO';
     if (password != '' && alasan_reject.length >= 10) {
         $.ajax({
             url: 'Ulok/submit_otp/',
             type: 'POST',
             async: false,
             data: {
                 ref_num: ref_num,
                 input_otp: password,
                 tipe_form: tipe_form
             },
             success: function(msg) {
                 var res = JSON.parse(msg);

                 if (res['hasil'] == 'success') {
                     var rows = $('#data-trx-to-toko').datagrid('getSelected');
                     var status_ho = 'REJECT';
                     var status_cbg = 'REJECT';
                     var tipe_form = 'TO';
                     $.ajax({
                         url: 'Ulok/update_ulok_trx_status_HO_cabang/',
                         type: 'POST',
                         async: false,
                         data: {
                             status_ho: status_ho,
                             status_cbg: status_cbg,
                             form_id: rows.FORM_NUM,
                             tipe_form: tipe_form,
                             alasan_reject: alasan_reject
                         },
                         success: function(msg) {
                             $.messager.alert('Warning', 'Data TO berhasil direject');
                             $('#data-trx-to-toko').datagrid('reload');

                         }
                     });
                     $('#otp-reject-to').window('close')

                 } else {
                     $.messager.alert('Warning', 'Password salah');
                 }
             }
         });
     } else {
         $.messager.alert('Warning', 'Anda belum menginput OTP dan alasan Reject min 10 karakter.');
     }
    $('#submit-otp-reject-to').linkbutton('enable');
 });

$('#submit-otp-lduk').click(function(event) {
     event.preventDefault();
     $('#submit-otp-lduk').linkbutton('disable');
     var password = $('#input-otp-lduk').textbox('getValue');
     var ref_num = $('#input-ref-num').textbox('getValue');
     var ids = [];
     var tipe_form = 'lduk';
     if (password != '') {

         $.ajax({
             url: 'Ulok/submit_otp/',
             type: 'POST',
             async: false,
             data: {
                 ref_num: ref_num,
                 input_otp: password,
                 tipe_form: tipe_form
             },
             success: function(msg) {
                 var res = JSON.parse(msg);

                 if (res['hasil'] == 'success') {
                     var rows = $('#data-list-lduk').datagrid('getSelections');
                     for (var i = 0; i < rows.length; i++) {
                         ids.push(rows[i].LDUK_NUM);
                         $.ajax({
                             url: 'Ulok/get_data_from_lduk/',
                             type: 'POST',
                             async: false,
                             data: {
                                 lduk: rows[i].LDUK_NUM
                             },
                             success: function(msg) {
                                 var result = JSON.parse(msg);
                                 var status = 'LDUK';
                                 for (var x = 0; x < result.length; x++) {
                                     $.ajax({
                                         url: 'Ulok/update_ulok_trx_status_HO/',
                                         type: 'POST',
                                         async: false,
                                         data: {
                                             status: status,
                                             form_id: result[x]['FORM_ID'],
                                             tipe_form: result[x]['TIPE_FORM']
                                         },
                                         success: function(msg) {

                                         }
                                     });
                                 }
                             }
                         });
                         $('#input-otp-lduk').textbox('setValue', '');
                         $.messager.alert('Warning', 'LDUK berhasil divalidasi');
                         $('#otp-validasi-lduk').window('close')
                     }
                 } else {
                     $.messager.alert('Warning', 'Password salah');
                 }
             }
         });
     } else {
         $.messager.alert('Warning', 'Anda belum menginput OTP  .');
     }
    $('#submit-otp-lduk').linkbutton('enable');
 });

$("#cancel-req-liststatusto").click(function(event) {
     event.preventDefault();
     $('#show-cabang-to').combobox('select', '');
     $('#show-periode-to').combobox('select', '');
     $('#modal-req-liststatusto').window('close');
 });

 $('#f-tgltrf-start').datebox({
     formatter: function(date) {
         var y = date.getFullYear();
         var m = date.getMonth() + 1;
         var d = date.getDate();
         return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
     },
     parser: function(s) {
         if (!s) return new Date();
         var ss = s.split('-');
         var y = parseInt(ss[0], 10);
         var m = parseInt(ss[1], 10);
         var d = parseInt(ss[2], 10);
         if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
             return new Date(y, m - 1, d);
         } else {
             return new Date();
         }
     }
 });
$('#search-tglform-start-ulok').datebox({
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
$('#search-tglform-end-ulok').datebox({
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
$('#search-tgltrf-start-ulok').datebox({
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

      $('#search-tgltrf-end-ulok').datebox({
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

    $('#search-tglform-start-to').datebox({
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
  $('#search-tglform-end-to').datebox({
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
  $('#f-tgltrf-end').datebox({
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


  $('#search-tglsurvey-start-to').datebox({
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

  $('#search-tglsurvey-end-to').datebox({
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


  $('#to-input-survey-tgl-penyampai-survey').datebox({
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
  $('#input-survey-tgl-survey').datebox({
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
  $('#input-survey-tgl-penyampai-survey').datebox({
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
$("#wizard-inquiryTO").steps({
    headerTag: "h2",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    enableAllSteps: true,
    enableFinishButton: true,
    enablePagination: true,
    setStep: 0,
    labels: {
        finish: "Done"
    },
    onStepChanging: function(event, currentIndex, newIndex) {
        if (newIndex < currentIndex) {
            return true;
        }
        if (currentIndex == '0') {
            $("#show-form-to-no-1").textbox('setValue', $('#show-form-to-no').textbox('getValue'));
            var tgl_form = $("#show-tgl-to-form").datebox('getValue');
            var noktp = $("#show-noktp-to").textbox('getValue');
            var noktp_length=($("#show-noktp-to").textbox('getValue')).length;
            var nama = $("#show-nama-lengkap-to").textbox('getValue');
            var alamat = $("#show-alamat-lengkap-to").textbox('getValue');
            var rtrw = $("#show-rt-rw-to").textbox('getValue').length;
            var kecamatan = $("#show-kecamatan-to").combobox('getValue');
            var kelurahan = $("#show-kelurahan-to").combobox('getValue');
            var kodya = $("#show-kodya-to").combobox('getValue');
            var kd_pos = $("#show-kode-pos-to").combobox('getValue');
            var provinsi = $('#show-provinsi-to').combobox('getValue');
            var email = $("#show-email-to").textbox('getValue');
            var npwp = $("#show-npwp-to").textbox('getValue');
            var npwp_length=($("#show-npwp-to").textbox('getValue')).length;
            var telp = $("#show-telp-to").textbox('getValue');
            var telp_length = ($("#show-telp-to").textbox('getValue')).length;
            $('#message_inquiry_to').html('');
            if ((npwp_length== 0 || npwp_length==15 ) && provinsi != '' && tgl_form != '' && noktp != ''  && noktp_length ==16 && nama != '' && alamat != '' && rtrw == 7 && kecamatan != '' && kelurahan != '' && kodya != '' && kd_pos != '' && validatePhone(telp) && telp_length <= 15 && isEmail(email)) {
                $('#data-list-detail-status-to').datagrid('reload');
                return true;
            } else {
                if (rtrw != 7) {
                    $('#message_inquiry_to').html('Error : RT RW  wajib 7  karakter');
                    return false;
                } else if (!isEmail(email)) {
                    $('#message_inquiry_to').html('Error : Email tidak valid');
                    return false;
                } else if (!validatePhone(telp)) {
                    $('#message_inquiry_to').html('Error : Telp tidak valid');
                    return false;
                } else if (telp_length > 15) {
                    $('#message_inquiry_to').html('Error : Telp tidak valid,maks 15 digit');
                    return false;
                } else if(noktp_length != 16){
                    $('#message_inquiry_to').html('Error : No KTP wajib 16 digit');
                    return false;
                }else if(npwp_length !=0 && npwp_length != 15){
                    $('#message_inquiry_to').html('Error : NPWP wajib 15 digit');
                    return false;
                }else{
                    $('#message_inquiry_to').html('Error : Harap lengkapi data');
                    return false;
                }
            }
        } else if (currentIndex == '1') {
            var kd_toko_lok = $("#show-kode-toko-to").textbox('getValue');
            var nm_toko_lok = $("#show-nama-toko-to").textbox('getValue');

            var provinsi_lok = $('#show-provinsi-to-lok').combobox('getValue');
            var kodya_lok = $('#show-kodya-to-lok').combobox('getValue');
            var kecamatan_lok = $('#show-kecamatan-to-lok').combobox('getValue');
            var kelurahan_lok = $('#show-kelurahan-to-lok').combobox('getValue');
            var kodepos_lok = $('#show-kode-pos-to-lok').combobox('getValue');
            var alamat_lok = $("#show-alamat-to").textbox('getValue');
            var rtrw_lok = $("#show-rt-rw-toko-to").textbox('getValue').length;
            var actualinves = $("#show-actual-investment-to").numberbox('getValue');
            var ppn_lok = $("#show-ppn-to").numberbox('getValue');
            var goodwill_lok = $("#show-goodwill-to").numberbox('getValue');
            var total_lok = $("#show-total-to").numberbox('getValue');
            if (((provinsi_lok != '' && kecamatan != '' && kelurahan != '' && kodya != '' && kd_pos != '' && kd_toko_lok != '' && nm_toko_lok != '' && alamat_lok != '' && rtrw_lok == 7) || (kd_toko_lok != '' && nm_toko_lok != '' && rtrw_lok == 0)) && actualinves != '' && ppn_lok != '' && goodwill_lok != '' && total_lok != '') {
                $('#message_inquiry_to2').html('');
                $('#data-list-detail-status-to').datagrid('reload');
                return true;
            } else {
                if (rtrw_lok != 7 && provinsi_lok !='' && kecamatan !='' && kelurahan!='' && kodya !='' && kd_pos !='') {
                    $('#message_inquiry_to2').html('Error : RT RW wajib 7 karakter');
                    return false;
                } else {

                    $('#message_inquiry_to2').html('Error : Harap lengkapi data');
                    return false;
                }
            }
        } else if (currentIndex == '2') {
            var tipe_bayar = $("#show-tipe-to").combobox('getValue');
            var bank = $("#show-bank-to").combobox('getValue');
            var cbg_bank = $("#show-cabang-bank-to").textbox('getValue');
            var no_rek = $('#show-norek-to').textbox('getValue');
            var na_rek = $('#show-narek-to').textbox('getValue');
            var jml_swipe = $('#show-jumlah-swipe-to').numberbox('getValue');
            var jml_rek = $('#show-jumlah-masukrek-to').numberbox('getValue');
            var tgl_trsfr = $('#show-tgl-to').datebox('getValue');
            var bukti_trf = $('#update_cek_file_to').textbox('getValue');
            var kartukredit = $('#show-to-kredit').textbox('getValue');
            var jumlah_file = $('#update_to_file_amount').textbox('getValue');
            var narek_pengirim = $('#show-narek-to-pengirim').textbox('getValue');
            if ( jml_swipe >= 3600000 &&jumlah_file != 0 && jumlah_file != '' && ((tipe_bayar != 'Cash' && kartukredit != '' && narek_pengirim != '') || (tipe_bayar == 'Cash' && kartukredit == '' && narek_pengirim == '')) && bank != '' && cbg_bank != '' && no_rek != '' && na_rek != '' &&  jml_rek != '' && tgl_trsfr != '') {

                update_all_to();
                var is_finish = $('#update_cek_file_to').textbox('getValue');
                var form_id = replaceAll($('#show-form-to-no').textbox('getValue'), "/", "-");
                if (is_finish) {
                    $('#form-lihat-inquiryTO').form('submit', {
                        success: function() {
                            $('#content').panel('refresh');
                            window.open('Ulok/print_form_pengajuan_to_toko/' + form_id);

                        }
                    });
                }else{

                }
                $('#data-list-detail-status-to').datagrid('reload');
                return true;
          
            }else{
              return false;
            }
        }
    },
    onFinishing: function(event, currentIndex) {

        $('#showDetailInquiryTO').window('close');
    },
    onFinished: function(event, currentIndex) {
        $('#showDetailInquiryTO').window('close');
    }
});

$("#wizard-inquiry").steps({
       headerTag: "h2",
       bodyTag: "section",
       transitionEffect: "slideLeft",
       enableAllSteps: true,
       enableFinishButton: true,
       enablePagination: true,
       setStep: 0,
       labels: {
           finish: "Done"


       },
       onStepChanging: function(event, currentIndex, newIndex) {

           if (newIndex < currentIndex) {
               return true;
           }
           if (currentIndex == '0') {
               $("#show-ulok-form-no-1").textbox('setValue', $('#show-ulok-form-no').textbox('getValue'));
               var tgl_form = $("#show-ulok-tgl-form").datebox('getValue');
               var sumber_ulok = $("#show-ulok-sumber-ulok").combobox('getValue');
               var npwp = $("#show-ulok-npwp").textbox('getValue');
               var npwp_length=($("#show-ulok-npwp").textbox('getValue')).length;
               var noktp = $("#show-ulok-noktp").textbox('getValue');
               var noktp_length = ($("#show-ulok-noktp").textbox('getValue')).length;
               var nama = $("#show-ulok-nama-lengkap").textbox('getValue');
               var alamat = $("#show-ulok-alamat-lengkap").textbox('getValue');
               var rtrw = $("#show-ulok-rt-rw").textbox('getValue').length;
               var kecamatan = $("#show-ulok-kecamatan").combobox('getValue');
               var kelurahan = $("#show-ulok-kelurahan").combobox('getValue');
               var kodya = $("#show-ulok-kodya").combobox('getValue');
               var provinsi = $('#show-ulok-provinsi').combobox('getValue');
               var kd_pos = $("#show-ulok-kode-pos").combobox('getValue');
               var telp = $("#show-ulok-telp").textbox('getValue');
               var telp_length = $("#show-ulok-telp").textbox('getValue').length;
               var email = $("#show-ulok-email").textbox('getValue');
               $('#message_inquiry').html('');
               if ((npwp_length ==0 || npwp_length ==15 ) && tgl_form != '' && sumber_ulok != '' && noktp != '' && noktp_length ==16 && nama != '' && alamat != '' && rtrw == 7 && kecamatan != '' && kelurahan != '' && kodya != '' && kd_pos != '' && provinsi != '' && validatePhone(telp) && telp_length <= 15 && isEmail(email)) {
                   $('#message_inquiry').html('');
                   $('#data-list-detail-status').datagrid('reload');
                   return true;
               } else {
                   if (rtrw != 7) {

                       $('#message_inquiry').html('Error : RT dan RW  wajib 7 karakter');
                   }else if (!isEmail(email)) {
                       $('#message_inquiry').html('Error : Email tidak valid');
                   }else if (!validatePhone(telp)) {
                       $('#message_inquiry').html('Error : Telp tidak valid');
                   }else if (telp_length > 15) {
                       $('#message_inquiry').html('Error : Telp tidak valid,maks 15 digit');
                   }else if(noktp_length !=16){
                       $('#message_inquiry').html('Error : No KTP wajib 16 digit');
                   }else if(npwp_length == 0 && npwp_length ==15){
                       $('#message_inquiry').html('Error : NPWP wajib 15 digit');
                   }else{
                       $('#message_inquiry').html('Error : Lengkapi data terlebih dahulu');

                   }
                   return false;
               }
           } else if (currentIndex == '1') {
               var alamat_lok = $("#show-ulok-alamat-lok").textbox('getValue');
               var rtrw_lok = $("#show-ulok-rt-rw-lok").textbox('getValue').length;
               var kelurahan_lok = $("#show-ulok-kelurahan-lok").combobox('getValue');
               var kecamatan_lok = $("#show-ulok-kecamatan-lok").combobox('getValue');
               var provinsi_lok = $('#show-ulok-provinsi-lok').combobox('getValue');
               var kodya_lok = $("#show-ulok-kodya-lok").combobox('getValue');
               var kd_pos_lok = $("#show-ulok-kode-pos-lok").combobox('getValue');
               var bentuk_lok = $("#show-ulok-bentuk-lok").combobox('getValue');
               var bentuk_lok_lain = $('#show-ulok-bentuk-lok-lain').textbox('getValue');
               var panjang_lok = $("#show-ulok-ukuran-panjang").textbox('getValue');
               var lebar_lok = $("#show-ulok-ukuran-lebar").textbox('getValue');
               var status_lok = $("#show-ulok-status-lokasi").combobox('getValue');
               var dok_milik_lok = $("#show-ulok-dok-milik").combobox('getValue');
               var lahan_parkir_lok = $("#show-ulok-lahan-parkir").combobox('getValue');
               var izin_bangunan_lok = $("#show-ulok-izin-bangun").combobox('getValue');
               var pasar_lok = $("#show-ulok-pasar").combobox('getValue');
               var minimarket_lok = $("#show-ulok-minimarket").combobox('getValue');
               var denah_lok = $("#show-ulok-denah").combobox('getValue');
               var peruntuk_izin_lok = $('#show-ulok-izin-untuk').combobox('getValue');
               var ket_peruntuk_izin_lok = $('#show-ulok-izin-untuk-lain').textbox('getValue');
               var ket_status_lok = $('#show-ulok-status-lokasi-lain').textbox('getValue');
               var ket_lahan_parkir_lok = $("#show-ulok-lahan-parkir-lain").textbox('getValue');
               var ket_pasar_lok = $("#show-ulok-pasar-ada").textbox('getValue');
               var ket_minimarket_lok = $("#show-ulok-minimarket").textbox('getValue');
               var ket_dok_milik_lok = $("#show-ulok-dok-milik-lain").textbox('getValue');
               var idm_lok = $("#show-ulok-idm-dekat").combobox('getValue');
               var ket_idm_lok = $('#show-ulok-idm-dekat-ada').textbox('getValue');
               var jml_unit = $("#show-ulok-jumlah-unit").textbox('getValue');
               var jml_lantai = $("#show-ulok-jumlah-lantai").textbox('getValue');
               $('#message_inquiry2').html('');
               if (provinsi_lok != "" && alamat_lok != "" && rtrw_lok == 7 && kelurahan_lok != "" && kecamatan_lok != "" && kodya_lok != "" && kd_pos_lok != "" && bentuk_lok != "" && panjang_lok != "" && lebar_lok != "" && status_lok != "" && dok_milik_lok != "" && lahan_parkir_lok != "" && izin_bangunan_lok != "" && pasar_lok != "" && minimarket_lok != "" && denah_lok != "" && peruntuk_izin_lok != "" && idm_lok != "") {
                   if (((bentuk_lok == 'Tanah Kosong') || (bentuk_lok == 'Lainnya' && bentuk_lok_lain != '' && (jml_unit != '' && jml_lantai != '')) || ((bentuk_lok != 'Tanah Kosong' && bentuk_lok != 'Lainnya') && (jml_unit != '' && jml_lantai != ''))) && ((status_lok != 'Lainnya') || (status_lok == 'Lainnya' && ket_status_lok != '')) &&
                       ((lahan_parkir_lok != 'Lainnya') || (lahan_parkir_lok == 'Lainnya' && ket_lahan_parkir_lok != '')) &&
                       ((pasar_lok == 'Tidak Ada' || pasar_lok =='Tidak Tahu') || (pasar_lok != 'Tidak Ada'  && pasar_lok !='Tidak Tahu' && ket_pasar_lok != '')) &&
                       ((minimarket_lok == 'Tidak Ada' || minimarket_lok =='Tidak Tahu') || (minimarket_lok != 'Tidak Ada' && minimarket_lok !='Tidak Tahu' && ket_minimarket_lok != '')) &&
                       ((dok_milik_lok != 'Lainnya') || (dok_milik_lok == 'Lainnya' && ket_dok_milik_lok != '')) &&
                       ((idm_lok == 'Tidak Ada' || idm_lok =='Tidak Tahu') || (idm_lok != 'Tidak Ada'  && idm_lok !='Tidak Tahu' && ket_idm_lok != '')) &&
                       ((peruntuk_izin_lok != 'Lainnya') || (peruntuk_izin_lok == 'Lainnya' && ket_peruntuk_izin_lok != ''))
                   ) {

                       $('#data-list-detail-status').datagrid('reload');
                       return true;

                   } else {

                       $('#message_inquiry2').html('Error : Harap lengkapi data terlebih dahulu');
                       return false;
                   }
               } else {
                   if (rtrw_lok != 7) {
                       $('#message_inquiry2').html('Error : RT dan RW  wajib 7 karakter ');
                       return false;
                   } else {

                       $('#message_inquiry2').html('Error : Harap lengkapi data terlebih dahulu');
                       return false;
                   }
               }
           } else if (currentIndex == '2') {
               var form_num = $('#show-ulok-form-no-1').textbox('getValue');
               var narek_pengirim = $('#show-ulok-narek-pengirim').textbox('getValue');
               var tipe_bayar = $("#show-ulok-tipe").combobox('getValue');
               var kartukredit = $('#show-ulok-kredit').textbox('getValue')
               var bank = $("#show-ulok-bank").combobox('getValue');
               var cbg_bank = $("#show-ulok-cabang-bank").textbox('getValue');
               var no_rek = $('#show-ulok-norek').textbox('getValue');
               var na_rek = $('#show-ulok-narek').textbox('getValue');
               var jml_swipe = $('#show-ulok-jumlah-swipe').numberbox('getValue');
               var jml_rek = $('#show-ulok-jumlah-masukrek').numberbox('getValue');
               var tgl_trsfr = $('#show-ulok-tgl').datebox('getValue');
               var jumlah_file = $('#file_amount').textbox('getValue');
               if (jumlah_file != 0 && jumlah_file != '' && ((tipe_bayar != 'Cash' && kartukredit != '' && narek_pengirim != '') || (tipe_bayar == 'Cash' && kartukredit == '' && narek_pengirim == '')) && bank != '' && cbg_bank != '' && no_rek != '' && na_rek != '' && jml_swipe >=3600000 && jml_rek != '' && tgl_trsfr != '') {

                   update_all();
                   var is_finish = $('#update_cek_file').textbox('getValue');
                   var form_id = replaceAll($('#show-ulok-form-no').textbox('getValue'), "/", "-");
                   if (is_finish) {
                       $('#form-lihat-inquiry').form('submit', {
                           success: function() {

                               // $('#showDetailInquiry').window('close');
                               $('#content').panel('refresh');
                               window.open('Ulok/print_form_pengajuan_ulok/' + form_id);
                           }
                       });
                       //  window.open('http://192.168.10.238:8181/ULOK/Ulok/print_form_pengajuan_ulok/'+form_id);

                       //         return true;
                   } else {

                       //       return false;
                   }
                  $('#data-list-detail-status').datagrid('reload');
                  return true;
               }else{
                return false;
               }

           

           }
    
       },
       onFinishing: function(event, currentIndex) {

           $('#showDetailInquiry').window('close');
       },
       onFinished: function(event, currentIndex) {

           $('#showDetailInquiry').window('close');
       }
   });
 $('#show-actual-investment-to').numberbox({
     onChange: function(value) {
         var ppn = parseInt($('#show-ppn-to').numberbox('getValue'));
         var goodwill = parseInt($('#show-goodwill-to').numberbox('getValue'));
         var actualinvesment = value;
         var total = parseInt(ppn) + parseInt(goodwill) + parseInt(actualinvesment);
         $('#show-total-to').numberbox('setValue', total);
     }
 });

 $('#show-ppn-to').numberbox({
     onChange: function(value) {
         var ppn = value;
         var goodwill = parseInt($('#show-goodwill-to').numberbox('getValue'));
         var actualinvesment = parseInt($('#show-actual-investment-to').numberbox('getValue'));
         var total = parseInt(ppn) + parseInt(goodwill) + parseInt(actualinvesment);
         $('#show-total-to').numberbox('setValue', total);
     }
 });

 $("#show-provinsi-to").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-kodya-to').combobox('select', '');
             $('#show-kecamatan-to').combobox('select', '');
             $('#show-kelurahan-to').combobox('select', '');
             $('#show-kode-pos-to').combobox('select', '');
         } else {

             $('#show-kodya-to').combobox('reload', 'Ulok/get_all_kab_name/' + new_val);
         }

     }
 });
 $("#show-provinsi-to-lok").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-kodya-to-lok').combobox('select', '');
             $('#show-kecamatan-to-lok').combobox('select', '');
             $('#show-kelurahan-to-lok').combobox('select', '');
             $('#show-kode-pos-to-lok').combobox('select', '');
         } else {

             $('#show-kodya-to-lok').combobox('reload', 'Ulok/get_all_kab_name/' + new_val);
         }

     }
 });

 $("#show-tipe-to").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == 'Cash') {
             $('#show-to-kredit').textbox('readonly', true);
             $('#show-narek-to-pengirim').textbox('readonly', true);
             $('#show-to-kredit').textbox('setValue', '');
             $('#show-narek-to-pengirim').textbox('setValue', '');
         } else {
             $('#show-to-kredit').textbox('readonly', false);
             $('#show-narek-to-pengirim').textbox('readonly', false);
         }

     }
 });
 $("#show-ulok-tipe").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == 'Cash') {
             $('#show-ulok-kredit').textbox('readonly', true);
             $('#show-ulok-narek-pengirim').textbox('readonly', true);
             $('#show-ulok-kredit').textbox('setValue', '');
             $('#show-ulok-narek-pengirim').textbox('setValue', '');
         } else {
             $('#show-ulok-kredit').textbox('readonly', false);
             $('#show-ulok-narek-pengirim').textbox('readonly', false);
         }

     }
 });



 $('#show-goodwill-to').numberbox({
     onChange: function(value) {
         var ppn = parseInt($('#show-ppn-to').numberbox('getValue'));
         var goodwill = value;
         var actualinves = parseInt($('#show-actual-investment-to').numberbox('getValue'));

         var total = parseInt(ppn) + parseInt(goodwill) + parseInt(actualinves);
         $('#show-total-to').numberbox('setValue', total);
     }
 });



 $("#show-ulok-bentuk-lok").combobox({
     onChange: function(new_val, old_val) {
         $("#show-ulok-jumlah-unit").numberbox('setValue', '');
         $("#show-ulok-jumlah-lantai").numberbox('setValue', '');
         if (new_val == '' || new_val == 'Tanah Kosong') {
             $('#show-ulok-jumlah-unit').numberbox('readonly', true);
             $('#show-ulok-jumlah-lantai').numberbox('readonly', true);
             $('#show-ulok-bentuk-lok-lain').textbox('setValue', '');
             $('#show-ulok-bentuk-lok-lain').textbox('readonly', true);
             //$("#l-jumlah-lantai").numberbox('disable');
         } else if (new_val == 'Lainnya') {
             $('#show-ulok-bentuk-lok-lain').textbox('readonly', false);
             $('#show-ulok-jumlah-unit').numberbox('readonly', false);
             $('#show-ulok-bentuk-lok-lain').textbox('setValue', '');
             $('#show-ulok-jumlah-lantai').numberbox('readonly', false);
         } else {

             $('#show-ulok-bentuk-lok-lain').textbox('readonly', true);
             $('#show-ulok-jumlah-unit').numberbox('readonly', false);
             $('#show-ulok-bentuk-lok-lain').textbox('setValue', '');
             $('#show-ulok-jumlah-lantai').numberbox('readonly', false);

             // $("#l-jumlah-lantai").numberbox('enable');
         }
     }
 });

 $("#show-ulok-lahan-parkir").combobox({
     onChange: function(new_val, old_val) {
         $("#show-ulok-lahan-parkir-lain").textbox('setValue', '');
         if (new_val == 'Lainnya') {
             $('#show-ulok-lahan-parkir-lain').textbox('readonly', false);
             //$("#l-lahan-parkir-lain").textbox('enable');
         } else {
             $('#show-ulok-lahan-parkir-lain').textbox('readonly', true);
             //$("#l-lahan-parkir-lain").textbox('disable');
         }
     }
 });


 $("#show-ulok-status-lokasi").combobox({
     onChange: function(new_val, old_val) {
         $("#show-ulok-status-lokasi-lain").textbox('setValue', '');
         if (new_val == 'Lainnya') {
             $('#show-ulok-status-lokasi-lain').textbox('readonly', false);
         } else {
             $('#show-ulok-status-lokasi-lain').textbox('readonly', true);
         }
     }
 });


 $("#show-ulok-dok-milik").combobox({
     onChange: function(new_val, old_val) {
         $("#show-ulok-dok-milik-lain").textbox('setValue', '');
         if (new_val == 'Lainnya') {
             $('#show-ulok-dok-milik-lain').textbox('readonly', false);
         } else {
             $('#show-ulok-dok-milik-lain').textbox('readonly', true);
         }
     }
 });


 $("#show-ulok-pasar").combobox({
     onChange: function(new_val, old_val) {
         $("#show-ulok-pasar-ada").textbox('setValue', '');
         if (new_val == 'Tidak Ada' || new_val =='Tidak Tahu') {
             $('#show-ulok-pasar-ada').textbox('readonly', true);
         } else {
             $('#show-ulok-pasar-ada').textbox('readonly', false);
         }
     }
 });


 $("#show-ulok-minimarket").combobox({
     onChange: function(new_val, old_val) {
         $("#show-ulok-minimarket-ada").textbox('setValue', '');
         if (new_val == 'Tidak Ada' || new_val =='Tidak Tahu') {
             $('#show-ulok-minimarket-ada').textbox('readonly', true);
         } else {
             $('#show-ulok-minimarket-ada').textbox('readonly', false);
         }
     }
 });

 $("#show-ulok-izin-untuk").combobox({
     onChange: function(new_val, old_val) {
         $("#show-ulok-izin-untuk-lain").textbox('setValue', '');
         if (new_val == 'Lainnya') {
             $('#show-ulok-izin-untuk-lain').textbox('readonly', false);
             //$("#l-izin-untuk-lain").textbox('enable');
         } else {
             //$("#l-izin-untuk-lain").textbox('disable');
             $('#show-ulok-izin-untuk-lain').textbox('readonly', true);
         }
     }
 });

 $("#show-ulok-idm-dekat").combobox({
     onChange: function(new_val, old_val) {
         $("#show-ulok-idm-dekat-ada").textbox('setValue', '');
         if (new_val == 'Tidak Ada' || new_val =='Tidak Tahu') {
             $('#show-ulok-idm-dekat-ada').textbox('readonly', true);
         } else {
             $('#show-ulok-idm-dekat-ada').textbox('readonly', false);

         }
     }
 });

 $('#show-ulok-tgl').datebox({
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
 $('#search-tglform-start-ulok').datebox({
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
 $('#search-tglform-end-ulok').datebox({
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
 $("#show-ulok-provinsi").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-ulok-kodya').combobox('select', '');
             $('#show-ulok-kecamatan').combobox('select', '');
             $('#show-ulok-kelurahan').combobox('select', '');
             $('#show-ulok-kode-pos').combobox('select', '');
         } else {

             $('#show-ulok-kodya').combobox('reload', 'Ulok/get_all_kab_name/' + new_val);
         }

     }
 });
 $("#show-ulok-provinsi-lok").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-ulok-kodya-lok').combobox('select', '');
             $('#show-ulok-kecamatan-lok').combobox('select', '');
             $('#show-ulok-kelurahan-lok').combobox('select', '');
             $('#show-ulok-kode-pos-lok').combobox('select', '');
         } else {

             $('#show-ulok-kodya-lok').combobox('reload', 'Ulok/get_all_kab_name/' + new_val);
         }

     }
 });
 $("#show-ulok-kodya").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-ulok-kecamatan').combobox('select', '');
             $('#show-ulok-kelurahan').combobox('select', '');
             $('#show-ulok-kode-pos').combobox('select', '');
         } else {

             $('#show-ulok-kecamatan').combobox('reload', 'Ulok/get_all_kec_name/' + new_val);
         }

     }
 });
 $("#show-ulok-kodya-lok").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-ulok-kecamatan-lok').combobox('select', '');
             $('#show-ulok-kelurahan-lok').combobox('select', '');
             $('#show-ulok-kode-pos-lok').combobox('select', '');
         } else {

             $('#show-ulok-kecamatan-lok').combobox('reload', 'Ulok/get_all_kec_name/' + new_val);
         }

     }
 });

 $("#show-ulok-kecamatan").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-ulok-kelurahan').combobox('select', '');
             $('#show-ulok-kode-pos').combobox('select', '');
         } else {

             $('#show-ulok-kelurahan').combobox('reload', 'Ulok/get_all_kel_name/' + new_val);
         }

     }
 });
 $("#show-ulok-kecamatan-lok").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-ulok-kelurahan-lok').combobox('select', '');
             $('#show-ulok-kode-pos-lok').combobox('select', '');
         } else {

             $('#show-ulok-kelurahan-lok').combobox('reload', 'Ulok/get_all_kel_name/' + new_val);
         }

     }
 });
 $("#show-ulok-kelurahan").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {

             $('#show-ulok-kode-pos').combobox('select', '');
         } else {

             $('#show-ulok-kode-pos').combobox('reload', 'Ulok/get_all_kdpos/' + new_val);
         }

     }
 });
 $("#show-ulok-kelurahan-lok").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {

             $('#show-ulok-kode-pos-lok').combobox('select', '');
         } else {

             $('#show-ulok-kode-pos-lok').combobox('reload', 'Ulok/get_all_kdpos/' + new_val);
         }

     }
 });
 $("#show-kodya-to-lok").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-kecamatan-to-lok').combobox('select', '');
             $('#show-kelurahan-to-lok').combobox('select', '');
             $('#show-kode-pos-to-lok').combobox('select', '');
         } else {

             $('#show-kecamatan-to-lok').combobox('reload', 'Ulok/get_all_kec_name/' + new_val);
         }

     }
 });
 $("#show-kodya-to").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-kecamatan-to').combobox('select', '');
             $('#show-kelurahan-to').combobox('select', '');
             $('#show-kode-pos-to').combobox('select', '');
         } else {

             $('#show-kecamatan-to').combobox('reload', 'Ulok/get_all_kec_name/' + new_val);
         }

     }
 });
 $("#show-kecamatan-to").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-kelurahan-to').combobox('select', '');
             $('#show-kode-pos-to').combobox('select', '');
         } else {

             $('#show-kelurahan-to').combobox('reload', 'Ulok/get_all_kel_name/' + new_val);
         }

     }
 });
 $("#show-kecamatan-to-lok").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#show-kelurahan-to-lok').combobox('select', '');
             $('#show-kode-pos-to-lok').combobox('select', '');
         } else {

             $('#show-kelurahan-to-lok').combobox('reload', 'Ulok/get_all_kel_name/' + new_val);
         }

     }
 });
 $("#show-kelurahan-to-lok").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {

             $('#show-kode-pos-to-lok').combobox('select', '');
         } else {

             $('#show-kode-pos-to-lok').combobox('reload', 'Ulok/get_all_kdpos/' + new_val);
         }

     }
 });
 $("#show-kelurahan-to").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {

             $('#show-kode-pos-to').combobox('select', '');
         } else {

             $('#show-kode-pos-to').combobox('reload', 'Ulok/get_all_kdpos/' + new_val);
         }

     }
 });
 $('#show-tgl-to').datebox({
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
 $('#show-ulok-tgl-form').datebox({
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
 $('#show-tgl-to-form').datebox({
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
 $("#input_hasil_survey").combobox({
     onChange: function() {
         if ($('#input_hasil_survey').combobox('getValue') == 'NOK') {
             $('#input-alasan-survey').textbox({
                 editable: true
             });
             $('#input-alasan-survey').textbox('readonly', false);
         } else {
             $('#input-alasan-survey').textbox('setValue', '');
             $('#input-alasan-survey').textbox({
                 editable: false
             });

         }
     }
 });
 $('#search-tgltrf-start-ulok').datebox({
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

 $('#search-tgltrf-end-ulok').datebox({
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
 //end inquiry ulok
 //start log history status
 $("#search-inq-status").click(function(event) {
     event.preventDefault();
     var noform = $('#search-no-form-status').textbox('getValue');

     if (noform == "") {
         $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
     } else if (noform != "") {
         doSearchLogStatus();
     }
 });


 $("#clear-inq-status").click(function(event) {
     event.preventDefault();
     $('#search-no-form-status').textbox('setValue', '');
     $('#data-log-status').datagrid('reload');

 });

 //end log history status  


 // START FINALISASI TO


$("#clear-inq-status-to").click(function(event) {
     event.preventDefault();
    $('#search-form-status-to').textbox('setValue', '');
     //$('#data-status-to').datagrid('reload');
    $('#data-status-to').datagrid('load', {
        noform: null
    });

 });


$("#finalisasi-to").click(function(event) {
     event.preventDefault();
     var data= $('#data-status-to').datagrid('getSelected');
     if(data){
        $('#form-id').textbox('setValue',data.FORM_ID);
        $('#no-form-to').textbox('setValue',data.TO_FORM_NUM);
        $('#no-form-to').textbox('readonly',true);
        $('#modal-finalisasi-to').window('open');  
     }else{
        
         $.messager.alert('Warning', 'Harap memilih data TO terlebih dahulu');        
     }
     
 });

$("#cancel-status-to").click(function(event) {
     event.preventDefault();
     $('#modal-finalisasi-to').window('close');  
 });

$("#submit-status-to").click(function(event) {
    event.preventDefault();
    $('#submit-status-to').linkbutton('disable');
    var noform  = $('#no-form-to').textbox('getValue');
    var status =$('#status-cabang-to').combobox('getValue'); 
    var form_id= $('#form-id').textbox('getValue');
    $.ajax({
            url: 'Ulok/updateStatusFinalisasiTO/',
            type: 'POST',
            async: false,
            data: {
                form_id :form_id,
                form_num: noform,
                status :status
            },
            success: function(msg) {
                if(status=='HANGUS'){
                   var tipe_form = 'TO';
                   $.ajax({
                            url: 'Ulok/generate_bapp/',
                            type: 'POST',
                            async: false,
                            data: {
                                            form_num: noform,
                                            tipe_form: tipe_form
                            },
                            success: function(msg) {
                                window.open('Ulok/print_form_bapp/' + msg);

                            }
                    });
                }
            }

    });
    
$('#data-status-to').datagrid('reload');
$.messager.alert('Warning', 'Data berhasil diupdate');
$('#submit-status-to').linkbutton('enable');
$("#modal-finalisasi-to").window('close');
});
 

$("#search-inq-status-to").click(function(event) {
     event.preventDefault();
     var noform = $('#search-form-status-to').textbox('getValue');

     if (noform == "") {
         $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
     } else if (noform != "") {
         doSearchStatusTO();
     }
 });
 //  END FINALISASI TO
 $('#f-tgltrf-start').datebox({
     formatter: function(date) {
         var y = date.getFullYear();
         var m = date.getMonth() + 1;
         var d = date.getDate();
         return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
     },
     parser: function(s) {
         if (!s) return new Date();
         var ss = s.split('-');
         var y = parseInt(ss[0], 10);
         var m = parseInt(ss[1], 10);
         var d = parseInt(ss[2], 10);
         if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
             return new Date(y, m - 1, d);
         } else {
             return new Date();
         }
     }
 });

 $('#f-tgltrf-end').datebox({
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