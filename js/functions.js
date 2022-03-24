$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();
    });

    


//desde aqui llillo video 51 min 18,19

    /*$('.btn_new_cliente').click(function(e){ 
        e.preventDefault();
        $('#nit_cliente').removeAttr('disabled');
        $('#tel_cliente').removeAttr('disabled');
        $('#dir_cliente').removeAttr('disabled');

        $('#div_registro_cliente').slideDown();
    });*/


    //buscar cliente
    $('#nom_cliente').keyup(function(e){ 
        e.preventDefault();
        
        var cl=$(this).val();
        var action='searchCliente';
        $.ajax({ 
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cl},
            success: function(response){
                if(response==0){
                    $('#idcliente').val('');
                    $('#nit_cliente').val(''); 
                    $('#tel_cliente').val(''); 
                    $('#dir_cliente').val('');  
                }else
                {
                    var data=$.parseJSON(response);
                    $('#idcliente').val(data.idcliente);
                    $('#nit_cliente').val(data.nit); 
                    $('#tel_cliente').val(data.telefono); 
                    $('#dir_cliente').val(data.direccion); 

                    $('#nit_cliente').attr('disabled', 'disabled'); 
                    $('#tel_cliente').attr('disabled', 'disabled');
                    $('#dir_cliente').attr('disabled', 'disabled');
                }
             },
             error: function(error){
                
             },
        });
    });



});//fin del ready

function sendDataProduct(){ 
    alert("enviar datos");
}
function coloseModal(){ 
    $('.modal').fadeOut();
}


