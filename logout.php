<?php 
session_start();
$caduca= time()-95365;//si le mandamos una fecha negativa, el setcookie destruira las cookies
if(isset($_COOKIE['nombre'])){//si le damos al checkbox del formulario de login, esta mandara su valor en "value" es decir activo.
            setcookie('id',$_SESSION['idUsuario'],$caduca);
            setcookie('nombre',$_SESSION['nombre'],$caduca);
            setcookie('imagen',$_SESSION['imagen'],$caduca);
    
                            
}
session_unset();
session_destroy();
header("Refresh:5; url=index.php");
?>


<?php require "inc/header.inc"; ?>


   <div class="container-fluid">
      <div class="row">
         
          <div class="col-md-4 caja text-center col-centrar">
              <h4>Has cerrado sesión y serás redireccionado en 5 segundos, a la página de inicio.</h4>
          </div>
          
      </div>
       
   </div>
    <?php require "inc/footer.inc"; ?>