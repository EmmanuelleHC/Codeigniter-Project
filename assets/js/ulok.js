//function global
function replaceAll(str, term, replacement) {
                return str.replace(new RegExp(escapeRegExp(term), 'g'), replacement);
}

function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}

function isEmail(email) {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
}

function validatePhone(txtPhone) {
                var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
                return filter.test(txtPhone);
}

//input ulok

function submit_file_ulok() {
    var ul = document.getElementById("fileList");
    var items = ul.getElementsByTagName("li");

    var form_id = replaceAll($('#form-num').textbox('getValue'), "/", "-");

    for (var i = 0; i < items.length; ++i) {
        var li = ul.getElementsByTagName("li")[i].innerHTML;
        var tes = li.indexOf("<");
        var res = li.substring(0, tes);
        if (res != '') {
            document.getElementById('cek_file').value = 'D';
        } else {
            $.messager.alert('Warning', 'Anda tidak memilih file  .');
            document.getElementById('cek_file').value = '';

        }

    }
}

function makeFileList() {
    var input = document.getElementById("filesToUpload");
    var ul = document.getElementById("fileList");
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
        var nama_file_baru = input.files[i].name;
        li.setAttribute('id', nama_file_baru);
        var button = document.createElement("button");
        button.setAttribute('type', 'button');
        var button2 = document.createElement("button");
        button.id = input.files[i].name;
        button.innerHTML = "Delete";
        button.style.fontSize = "x-small";
        button2.id = 'view' + input.files[i].name;
        button2.setAttribute('type', 'button');
        button2.innerHTML = "View";
        button2.style.fontSize = "x-small";
        names.push(input.files[i].name);
        $("input[name=file]").val(names);
        var tipe_form = 'ULOK';
        var form_num = null;
        button.addEventListener("click", function(e) {
            e.preventDefault();
            var child = document.getElementById(li.id);
            var x = names.indexOf(child);
            ul.removeChild(child);
            names.splice(x, 1);
            var sebelum = parseInt(document.getElementById('file_amount').value);
            var sesudah = sebelum - 1;
            var session_id = document.getElementById('f-form-no').value;
            document.getElementById('file_amount').value = sesudah;
            $.ajax({
                url: 'Ulok/delete_temp_file_ulok/',
                type: 'POST',
                async: false,
                data: {
                    form_num: form_num,
                    tipe_form: tipe_form,
                    nama_file: li.id,
                    session_id: session_id

                },
                success: function(msg) {
                    $.messager.alert('Warning', 'File berhasil dihapus.');
                    $('#filesToUpload').val('');

                }
            });



        }, false);
        button2.addEventListener("click", function(e) {
            e.preventDefault();
            var session_id = document.getElementById('f-form-no').value;
            window.open('uploads/bkt_trf/' + session_id + '_' + li.id);
        }, false);
        if (document.getElementById('file_amount').value == '') {
            document.getElementById('file_amount').value = 0;
        }
        var sebelum = parseInt(document.getElementById('file_amount').value);
        var sesudah = sebelum + 1;
        document.getElementById('file_amount').value = sesudah;

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

//input to

function submit_file_to() {
    var ul = document.getElementById("tofileList");
    var items = ul.getElementsByTagName("li");

    var form_id = replaceAll($('#form-num-to').textbox('getValue'), "/", "-");

    for (var i = 0; i < items.length; ++i) {
        var li = ul.getElementsByTagName("li")[i].innerHTML;
        var tes = li.indexOf("<");
        var res = li.substring(0, tes);
        if (res != '') {
            document.getElementById('cek_file_to').value = 'D';
        } else {
            $.messager.alert('Warning', 'Anda tidak memilih file  .');
            document.getElementById('cek_file_to').value = '';

        }

    }
}

function getAllFileListTo(form_num) {
    var input = document.getElementById("filesToUploadTo");
    var ul = document.getElementById("tofileList");
    var tipe_form = 'TO';

    $('#tofileList>li').each(function() {
        var li_id = $(this).attr('id');
        var session_id = document.getElementById('f-form-to-no').value;
        $.ajax({
            url: 'Ulok/change_name_file_to/',
            type: 'POST',
            async: false,
            data: {
                session_id: session_id,
                file_name: li_id,
                form_num: form_num
            },
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

                    }
                });
            }
        });

    });


}
function getAllFileListUlok(form_num) {
    var input = document.getElementById("filesToUpload");
    var ul = document.getElementById("fileList");
    var tipe_form = 'ULOK';

    $('#fileList>li').each(function() {
        var li_id = $(this).attr('id');

        var session_id = document.getElementById('f-form-no').value;
        $.ajax({
            url: 'Ulok/change_name_file_to/',
            type: 'POST',
            async: false,
            data: {
                session_id: session_id,
                file_name: li_id,
                form_num: form_num
            },
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

                    }
                });
            }
        });

    });
}
function makeFileListTo() {
    var input = document.getElementById("filesToUploadTo");
    var ul = document.getElementById("tofileList");
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
        var nama_file_baru = input.files[i].name;
        li.setAttribute('id', nama_file_baru);
        var button = document.createElement("button");
        var button2 = document.createElement("button");
        button.setAttribute('type', 'button');
        button2.setAttribute('type', 'button');
        button.id = input.files[i].name;
        button.innerHTML = "Delete";
        button.style.fontSize = "x-small";
        button2.id = 'view' + input.files[i].name;
        button2.innerHTML = "View";
        button2.style.fontSize = "x-small";
        names.push(input.files[i].name);
        $("input[name=file]").val(names);
        var tipe_form = 'TO';
        var form_num = null;
        button.addEventListener("click", function(e) {
            e.preventDefault();
            var child = document.getElementById(this.id);
            var x = names.indexOf(child);
            ul.removeChild(child);
            names.splice(x, 1);
            var sebelum = parseInt(document.getElementById('to_file_amount').value);
            var sesudah = sebelum - 1;
            var session_id = document.getElementById('f-form-to-no').value;
            document.getElementById('to_file_amount').value = sesudah;
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
                    $.messager.alert('Warning', 'File berhasil dihapus.');
                    $('#filesToUploadTo').val('');

                }
            });



        }, false);
        button2.addEventListener("click", function(e) {
            e.preventDefault();

            var session_id = document.getElementById('f-form-to-no').value;
            window.open('uploads/bkt_trf/' + session_id + '_' + li.id);
        }, false);
        var sebelum = parseInt(document.getElementById('to_file_amount').value);
        var sesudah = sebelum + 1;
        document.getElementById('to_file_amount').value = sesudah;

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