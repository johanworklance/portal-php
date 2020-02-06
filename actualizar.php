<?php require 'lib/errores.php';
require 'lib/config.php'; 
require 'lib/validarFoto.php';
spl_autoload_register(function($clase){
    require_once("lib/$clase.php");
});

    if($_POST['id']){
        
            extract($_POST, EXTR_OVERWRITE);
        $db= new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                $db->preparar("UPDATE usuarios SET email = ?, contrasena = ?,  telefono = ?,  direccion = ?,  edad = ?,  ciudad = ?,   departamento = ?,  codigoPostal = ? WHERE idUsuario = ?");
              
                    $db->prep()->bind_param('ssisissii',$email,$contrasena,$telefono,$direccion, $edad, $ciudad, $departamento,$codigoPostal, $id);
        if(!empty($_FILES['foto']['name'])){//verificamos que se mando algun archivo por el formulario, en este caso la imagen
            
            if(validarFoto($enombre,true)){
                
                    $db->ejecutar();
                    
                    $db->liberar();
                header("Refresh:5; url=editar.php");
                 require "inc/header.inc"; 

                    echo "     
                       <div class='container-fluid'>
                          <div class='row'>

                              <div class='col-md-4 caja text-center col-centrar'>
                                  <h4>Actualizacion completada, seras redirrecionado en 5 s.</h4>
                              </div>

                          </div>

                       </div>";
     require "inc/footer.inc"; 
                
            }else{
                echo "error";
            }
        }else{
            $db->ejecutar();
                    
                    $db->liberar();
                header("Refresh:5; url=editar.php");
                 require "inc/header.inc"; 

                    echo "     
                       <div class='container-fluid'>
                          <div class='row'>

                              <div class='col-md-4 caja text-center col-centrar'>
                                  <h4>Actualizacion completada, seras redirrecionado en 5 s.</h4>
                              </div>

                          </div>

                       </div>";
     require "inc/footer.inc"; 
                
        }
            
        }