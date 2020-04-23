

$(document).ready(function() {


	$("#change-password").click(function(event) {
        event.preventDefault();
        $("#modal-change-password").window('open');
    });

    $("#help").click(function(event) {
        event.preventDefault();
        var session_role = document.getElementById('session_role').value;
   
        if(session_role==2){
            //franchise cabang
    
            window.open('uploads/juklak/Juklak - Franchise Cabang.pdf');
            window.open('uploads/juklak/Alur.pdf');
        }else if(session_role==3){
            //franchise ho

            window.open('uploads/juklak/Juklak - Franchise HO.pdf');
            window.open('uploads/juklak/Alur.pdf');
        }else if(session_role==4){
            //RFM
            window.open('uploads/juklak/Juklak - RFM.pdf');
            window.open('uploads/juklak/Alur.pdf');
        }else if(session_role==5){
            //franchise mgr cabang
            window.open('uploads/juklak/Juklak - Franchise Cbg Manager.pdf');
            window.open('uploads/juklak/Alur.pdf');
        }else{

            $.messager.alert('Warning', 'Fasilitas tidak tersedia.');
        }
    });

   

     $('#tree_navigator').tree({
        //onDblClick: function(node){
        onClick: function(node){
            if($(this).tree('isLeaf',node.target)){
                    
                    $('#content').panel({
                        href:node.attributes.url,
                        onBeforeLoad:function(){
          
                           // $('#loading').show();
                        },
                        onLoad:function(){
           
                            //$('#loading').hide();
                        }
                    });
               
            }else{
                
            }
        }
    });

    /*$("#save-password").click(function(event) {
    	event.preventDefault();
    	var cur_pass = $("#curr-password").textbox('getValue');
    	var new_pass = $("#new-password").textbox('getValue');
    	var re_pass = $("#re-password").textbox('getValue');

    	$.ajax({
    		url: 'Auth/update_newpass/',
    		type: 'POST',
    		data: {
    			curr_password: cur_pass,
    			new_password: new_pass,
    			re_password: re_pass
    		},
    		success: function(msg) {
    			
    		}
    	});
    });*/
});