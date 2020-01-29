<?php session_start();//metodo para iniciar el uso de sesiones y acceder a la super global $_SESSION[]?>
<?php require "inc/header.inc"; ?>
<div class="container-fluid">
      
       <div class="row">
           <div class="col-md-6 col-centrar">
<?php 

if($_POST){//verificamos que se envien cosas del formulario, es decir dar al boton de submit
     require 'lib/errores.php';
    require 'lib/validarFoto.php'; 
    require 'lib/config.php'; 
    $ok=false;
    spl_autoload_register(function($clase){//usamos el autocargador de clases, dentro le dejamos una funcion que cogera cualquier instancia de clase como un valor para la estructura que dejemos dentro en este caso el "lib/Database.php"
    require_once("lib/$clase.php");//require once es para que si ya esta cargado un fichero, no lo haga de nuevo
    });
                        
    extract($_POST, EXTR_OVERWRITE);//extraemos la informacion de la variable superglobal/array en dinstintas variables que tienen el nombre del atributo name de las etiquetas imput
    if($email && $contrasena){
        $db= new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        $expReg= '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        $validarEmail= $db->validarDatos("email","usuarios",$email);

        if(preg_match($expReg,$email)){
            if($validarEmail!=0){//que sea distinto de 0, es decir, debe valer 1 asi sabremos que el email ya fue registrado previamente
                $db->preparar("SELECT idUsuario,CONCAT (nombre,' ',apellido) AS nombreCompleto,email,contrasena,imagen FROM usuarios WHERE email='$email'");
                $db->ejecutar();
                $db->prep()->bind_result($id,$dbnombreCompleto,$dbemail,$dbcontrasena,$rutaImagen);//indica que variables vincularemos a los resultados de la busquedad
                $db->resultado();//los vincula, y ahora ya esas variables tiene valores, como solo trae un resultado esta consulta, el fetch en el metodo resultado sera usado una vez,no haremos uso de un ciclo while
                if($email==$dbemail){
                    if($contrasena==$dbcontrasena){
                        
                        $_SESSION['idUsuario']= $id;//usaremos estas variables en el admin.php
                        $_SESSION['nombre']=$dbnombreCompleto;
                        $_SESSION['imagen']=$rutaImagen;
                        
                        $caduca= time()+365*24*60*60;//durara un año
                        
                        if($recordar=='activo'){//si le damos al checkbox del formulario de login, esta mandara su valor en "value" es decir activo.
                            
                            setcookie('id',$_SESSION['idUsuario'],$caduca);
                            setcookie('nombre',$_SESSION['nombre'],$caduca);
                            setcookie('imagen',$_SESSION['imagen'],$caduca);
                            
                        }
                        
                        $db->cerrar();
                        
                        header('Location: admin.php');
                    }else{
                        header("Refresh:5; url=index.php");
                        trigger_error("Esta contraseña no coincide con la del correo y ahora seras redireccionado en 5 segundos.", E_USER_ERROR);
                        
                    }
                }
                        
            }else{
                header("Refresh:5; url=index.php");
                trigger_error("Este email no existe, por favor ingresa otro o registrate y ahora seras redireccionado en 5 segundos.", E_USER_ERROR);
                
            }
            
        }else{
            header("Refresh:5; url=index.php");
            trigger_error("Por favor introduce un email válido y ahora seras redireccionado en 5 segundos.", E_USER_ERROR);
            
            
        }
    }else{
        header("Refresh:5; url=index.php");
            trigger_error("No dejes campos vacios y ahora seras redireccionado en 5 segundos.", E_USER_ERROR);
    }
                       
                        
                        
                        
                            
       
}//endif post
    ?>
            </div>
       </div>
   </div>

    <?php require "inc/footer.inc"; ?>