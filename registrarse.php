<?php require "inc/header.inc"; ?>
 <div class="container-fluid">
      
       <div class="row">
           <div class="col-md-6 col-centrar">
  <?php
               $ok=false;
               require_once "lib/config.php";//lo ponemos aqui, por que sera en registrarse donde crearemos una de la instancias a database
               require 'lib/errores.php';
                require 'lib/validarFoto.php'; 
               spl_autoload_register(function($clase){//usamos el autocargador de clases, dentro le dejamos una funcion que cogera cualquier instancia de clase como un valor para la estructura que dejemos dentro en este caso el "lib/Database.php"
                   require_once("lib/$clase.php");//require once es para que si ya esta cargado un fichero, no lo haga de nuevo
               });

                    if($_POST){//verificamos que se envien cosas del formulario, es decir dar al boton de submit
                          
                        
                        extract($_POST, EXTR_OVERWRITE);//extraemos la informacion de la variable superglobal/array en dinstintas variables que tienen el nombre del atributo name de las etiquetas imput
                        
                        if(!file_exists("fotos")){//verificamos que exista la carpeta, si no existe manda false la negamos, y entramos al bloque de codigo
                            mkdir("fotos",0777);//la creamos
                        }
                        $nombre= strtolower($nombre);
                        
                        
                            
                         
                        if($nombre && $email && $contrasena && $confirContrasena){
                            $db= new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                            $expReg= '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';//que empieze como minimo con algun caracter que esta el primer corchete, el segundo puede haber un punto y el corchete de adentro o no estar, despues el aroba @, tras el cualquie cosa dentro del rango del tercer corchete, despues cualquier cosa y finalmente un punto y como minomo 2 letras
                            if(preg_match($expReg,$email)){
                                if(strlen($contrasena)>=6){
                                    if($contrasena==$confirContrasena){
                                    
                                        $validarEmail= $db->validarDatos("email","usuarios",$email);
                                        
                                        if($validarEmail==0){
                                            $validarCedula= $db->validarDatos("cedula","usuarios",$cedula);
                                            
                                            if($validarCedula==0){
                                                if(validarFoto($nombre)){
                            //echo"<img src='$rutaSubida' class='img-fluid' alt=''>";aqui mostramos la imagen que se guardo en la carpeta fotos con el nombre profile.jpg
                                                    $fechaRegistro=time();//devuelve la fecha en formato unix,es decir los segundos transcurridos desde 1970
                                              if($db->preparar("INSERT INTO usuarios VALUES (NULL, '$nombre', '$apellido', '$email', '$contrasena', '$cedula', '$telefono', '$direccion', '$edad', '$ciudad', '$departamento', '$codigoPostal','$rutaSubida','$fechaRegistro')")){
                                                  $db->ejecutar();
                                                  trigger_error("Te has registrado perfectamente.", E_USER_NOTICE);
                                                  $ok=true;
                                                  $db->cerrar();
                                              }  
                                        }
                                    }else{
                                             trigger_error("Esta cédula ya esta registrada, verifique datos.", E_USER_ERROR);   
                                            }
                                            
                                            
                                            
                                            
                                        }else{
                                            trigger_error("Ese email ya esta registrado, prueba con otro.", E_USER_ERROR);
                                        }
                                    }else{
                                        trigger_error("Las contraseñas no coinciden.", E_USER_ERROR);   
                                    }
                                }else{
                                    trigger_error("La contraseña debe ser de al menos 6 caracteres.", E_USER_ERROR);
                                }
                                
                            }else{
                                trigger_error("Por favor introduce un email válido.", E_USER_ERROR);
                            }
                        }else{
                            trigger_error("De este formulario minimo se necesita llenar: nombre, correo, la contraseña y su confirmacion, y subir una imagen.", E_USER_ERROR);
                        }
                    }
              
               ?>
               </div>
       </div>
   </div>
               
   <div class="container-fluid">
      <div class="row">
          <div class="col-md-12 text-center mt-3">
              <h2>Portal Web</h2>
          </div>
      </div>
       <div class="row">
           <div class="col-md-6 col-centrar caja">
              
            
               <?php if($ok):?><!--aqui si logramos registar perfectamente al usuario entonces la variable ok sera true y en vez de mostrar el formulario mostraremos este mensaje-->
               <h2>Saludos <?php echo $nombre; ?>!</h2>
               <img class="img-fluid" src="<?php echo $rutaSubida; ?>" alt="">
               <p>Te has registrado perfectamente, por favor click al boton de abajo para ir a la pagina de inicio, y asi logear en el sistema.</p>
               <a class="btn btn-primary" href="index.php">Inicio</a>
               <?php else:?>
               <form action="" method="post" role="form" enctype="multipart/form-data"><!--enctype para que pueda recibir imagenes-->
                 <h2 class="text-center">Registrate</h2>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="nombre" name="nombre" placeholder="Nombre">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="apellido" name="apellido" placeholder="Apellido">
                  </div>
                  <div class="form-group row">
                    
                      <input type="text" class="form-control col-md-7 col-centrar" id="usuario" name="email" placeholder="Correo Electrónico">
                    
                  </div>
                  <div class="form-group row">
                    
                      <input type="password" class="form-control col-md-7 col-centrar" id="contrasena" name="contrasena" placeholder="Contraseña">
                    
                  </div>
                  <div class="form-group row">
                    
                      <input type="password" class="form-control col-md-7 col-centrar" id="confirContrasena" name="confirContrasena" placeholder="Confirma la contraseña">
                    
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="cedula" name="cedula" placeholder="Cedula">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="telefono" name="telefono" placeholder="Telefono">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="direccion" name="direccion" placeholder="Direccion">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="edad" name="edad" placeholder="Edad">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="ciudad" name="ciudad" placeholder="Ciudad">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="departamento" name="departamento" placeholder="Departamento">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="codigoPostal" name="codigoPostal" placeholder="Codigo Postal">
                  </div>
                  <div class="form-group row">
                     <label for="foto" class="col-md-12 text-center">Foto de perfil</label>
                      <input type="file" class="form-control col-md-7 col-centrar" name="foto">
                  </div>
                  
                  <div class="form-group row">
                      <div class="col-centrar">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-secondary">Limpiar</button>
                      </div>
                   </div>
                   <a href="index.php" class="d-block text-center">Volver al Login, si ya tienes una cuenta</a>

                </form>
                <?php endif;?>
           </div>
       </div>
   </div>
    <?php require "inc/footer.inc"; ?>