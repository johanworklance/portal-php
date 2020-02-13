$(function(){
    //login
    var boton = $('#boton'),
        form = $('#formu'),
        img= $('.cargador'),
        alerta= $('.alerta'),
        alerta_contenido= $('.alerta_wrapper');
    
    
    boton.on('click',function(){
        var datos = form.serialize();//saca los datos de un formulario y los convierte a string en un formato tipo json es decir "clave=valor"
        
        var url= 'login.php';
        
        $.ajax({
            type: 'POST',
            url: url,
            data: datos,
            dataType: 'json',
            beforeSend: function(){//este metodo se ejecutara mientras aun no se termine la solicitud asi mostraremos el gif de cargando
                img.css({display:'block'});
            },
            complete: function(){
                img.css({display:'none'});
            },
            success: function(respuesta){//respuesta es lo que llegara el login.php, es decir el echo con el array output pasado a formato json
                if(respuesta.error){//recordar que ahora respuesta es un objeto json,y error es el primer valor de ese objeto, el segundo seria tipoerror
                    alerta.css({display:'block'});
                    alerta_contenido.html(respuesta.tipoError);
                    //form.effect('shake',{times:2},100);
                }else{
                    $(location).attr('href','admin.php');
                }
            },
            error: function(e){//aqui nos enviara un objeto con muchos valores pero en el de error nos indicara si hubo algun error en el archivo php
                console.log(e);
            }
            
            
        });
        
        
        
    });
    //logout
    var $logout= $('#logout');
    
    $logout.on('click', function(){
        $.ajax({
            type: 'POST',
            url: 'logout.php',
            dataType: 'html',
            success:function(respuesta){
                $(location).attr('href','index.php');//aqui no recibimos nada en si en la respuesta, tampoco le enviamos ningun dato al logout.php tan solo usamos el ajax para que el archivo php se ejecute, borre las cookies y cierre sesion
            }
            });
                
        }
    );
    //accion eliminar
    $('[data-toggle="tooltip"]').tooltip();
    
   
    
    $(document).on('click','#accionEliminar', function(e){
        e.preventDefault();//este metodo nos ayudara a que originalmente el enlace no vaya a la pagina en su href, es decir su accion por defecto
        
        var id= $(this).parent().parent().attr('data-id');//el enlace eliminar es hijo de una td y a su vez esta hija del tr que tiene el atributo data-id
        $('.modal-content #si').attr('data-id',id);
        $('#caja-modal').modal('show');
    });
    
    var $si= $('#si');
    
    $si.on('click', function(){
        var id= $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: 'eliminar.php',
            dataType: 'html',
            data: "eliminar="+id,
            dataType: 'json',
            success:function(respuesta){
                
                if(respuesta.estado=='ok'){
                    $('#caja-modal').modal('hide');
                    $('tr[data-id='+id+']').css({
                        background: 'red',
                        color: 'white'
                    }).slideUp();
                }else{
                    alert('hubo un error');
                }
            },
            error:function(e){
                console.log(e);
            }
            });
                
        }
    );
    var $no= $('#no');
    
    $no.on('click', function(){
        $('#caja-modal').modal('hide');
      }
    );
});