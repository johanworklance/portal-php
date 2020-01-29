<?php 
session_start();
if((isset($_SESSION['idUsuario']) && isset($_SESSION['nombre'])) || isset($_COOKIE['nombre'])){//como aun no hemos logeado no existe la sesion creada en el login, asi que con los isset verificamos si ya se definieron las variables de la super global SESSION
    if(isset($_COOKIE['nombre'])){
        $_SESSION['idUsuario']= $_COOKIE['id'];
        $_SESSION['nombre']= $_COOKIE['nombre'];
        $_SESSION['imagen']= $_COOKIE['imagen'];
    }
       header("Location: admin.php");
   } 
require "inc/header.inc"; ?>
   <div class="container-fluid">
      <div class="row">
          <div class="col-md-12 text-center mt-5">
              <h2>Portal Web</h2>
          </div>
      </div>
       <div class="row">
           <div class="col-md-6 col-centrar caja">
               <form action="login.php" method="post" role="form">
                 <h2 class="text-center">Login</h2>
                 
                  <div class="form-group row">
                    
                      <input type="text" class="form-control col-md-7 col-centrar" id="email" name="email" placeholder="Su correo...">
                    
                  </div>
                  <div class="form-group row">
                    
                      <input type="password" class="form-control col-md-7 col-centrar" id="contrasena" name="contrasena" placeholder="Su contraseña">
                    
                  </div>
                  <div class="form-group row">
                      <div class="col-md-7 col-centrar">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                        <button type="reset" class="btn btn-secondary">Limpiar</button>
                        <a href="registrarse.php" class="col-md-1">Registrarse</a><!--buscar despues como hacer que se vaya a la izquierda en bs4 que los pull no me funcionan-->
                        <br>
                        <br>
                        <label for="">
                            <input name="recordar" type="checkbox" value="activo"> Mantener sesión iniciada
                        </label>
                      </div>
                   </div>

                </form>
           </div>
       </div>
   </div>
    <?php require "inc/footer.inc"; ?>