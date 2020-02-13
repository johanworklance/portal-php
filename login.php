<?php session_start();//metodo para iniciar el uso de sesiones y acceder a la super global $_SESSION[]

if($_POST){//verificamos que se envien cosas del formulario, es decir dar al boton de submit
     
    $output= [];
    
    require 'lib/errores.php';
    require 'lib/config.php'; 
    
    spl_autoload_register(function($clase){//usamos el autocargador de clases, dentro le dejamos una funcion que cogera cualquier instancia de clase como un valor para la estructura que dejemos dentro en este caso el "lib/Database.php"
    require_once("lib/$clase.php");//require once es para que si ya esta cargado un fichero, no lo haga de nuevo
    });
                        
    extract($_POST, EXTR_OVERWRITE);//extraemos la informacion de la variable superglobal/array en dinstintas variables que tienen el nombre del atributo name de las etiquetas imput
    
    
    if(empty($email) && empty($contrasena)){
        $output= ["error"=>true,"tipoError"=>"No dejes campos vacios."];
    }
    
    
    
    if($email && $contrasena){
        $db= new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        $expReg= '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        $validarEmail= $db->validarDatos("email","usuarios",$email);

        if(preg_match($expReg,$email)){
            if($validarEmail!=0){//que sea distinto de 0, es decir, debe valer 1 asi sabremos que el email ya fue registrado previamente
                $db->preparar("SELECT idUsuario,CONCAT (nombre,' ',apellido) AS nombreCompleto,email,contrasena,rol FROM usuarios WHERE email='$email'");
                $db->ejecutar();
                $db->prep()->bind_result($id,$dbnombreCompleto,$dbemail,$dbcontrasena,$dbrol);//indica que variables vincularemos a los resultados de la busquedad
                $db->resultado();//los vincula, y ahora ya esas variables tiene valores, como solo trae un resultado esta consulta, el fetch en el metodo resultado sera usado una vez,no haremos uso de un ciclo while
                if($email==$dbemail){
                    if(strlen($contrasena)>72){
                        $output= ["error"=>true,"tipoError"=>"La contraseña es muy larga, por favor intente nuevamente."];//para evitar hackeos phpass recomienda hacer esta validacion ya que los hash superan ese numero de caracteres
                        
                    }
                    
                    $hasher= new PasswordHash(8, FALSE);//estos son los parametros que pide la clase del phpass
                    
                
                    if($hasher->CheckPassword($contrasena,$dbcontrasena)){
                        
                        $_SESSION['idUsuario']= $id;//usaremos estas variables en el admin.php
                        $_SESSION['nombre']=$dbnombreCompleto;
                        $_SESSION['rol']=$dbrol;
                        
                        $caduca= time()+365*24*60*60;//durara un año
                        
                        if(isset($recordar)){//si le damos al checkbox del formulario de login, esta mandara su valor en "value" es decir activo.(originalmente, yo tenia pueso si $recordar=='activo', pero la funcion serialize del jquery, no toma en cuenta un checkbox que no este seleccionado, ya que solo envia un valor en este caso 'activo' si se lo chekea, es decir el ajax del jquery no envia al checbox recordar)
                            
                            setcookie('id',$_SESSION['idUsuario'],$caduca);
                            setcookie('nombre',$_SESSION['nombre'],$caduca);
                            setcookie('rol',$_SESSION['rol'],$caduca);
                            
                        }
                        
                        $db->cerrar();
                        
                       
                    }else{
                        $output= ["error"=>true,"tipoError"=>"Esta contraseña no coincide con la del correo, por favor intente nuevamente."];
                        
                    }
                }
                        
            }else{
                $output= ["error"=>true,"tipoError"=>"Este email no existe, por favor ingresa otro o registrate, por favor intente nuevamente."];
                
            }
            
        }else{
            $output= ["error"=>true,"tipoError"=>"Introduce un email válido, por favor intente nuevamente."];
        }
    }
    $json= json_encode($output);//enviaremos el array output con el error especifico deacuerdo a las validaciones en formato json
    echo $json;//asi enviamos el json desde php, es como si fuera el return de una funcion
                               
}
    ?>
    