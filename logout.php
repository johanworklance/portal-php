<?php 
session_start();
$caduca= time()-95365;//si le mandamos una fecha negativa, el setcookie destruira las cookies
if(isset($_COOKIE['nombre'])){//si le damos al checkbox del formulario de login, esta mandara su valor en "value" es decir activo.
            setcookie('id',$_SESSION['idUsuario'],$caduca);
            setcookie('nombre',$_SESSION['nombre'],$caduca);
            setcookie('rol',$_SESSION['rol'],$caduca);
    
                            
}
session_unset();
session_destroy();

?>


