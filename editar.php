<?php 
session_start();//con el metodo aqui podremos acceder a las variables SESSION que vienen del login.php
require 'lib/errores.php';
require 'lib/config.php'; 
    
spl_autoload_register(function($clase){
    require_once("lib/$clase.php");
});

if(!$_SESSION['idUsuario'] && !$_SESSION['nombre']){
       header("Location: index.php");
       exit;
} 
$db= new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$fecha=getdate();
$diaN= date('d');
$anio=date('Y');
$diaS=['domingo','lunes',',martes','miercoles','jueves','viernes','sabado'];
$meses=['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
$dia2=$diaS[$fecha['wday']];
$mes=$meses[$fecha['mon']-1];

$db->preparar("SELECT CONCAT (nombre,' ',apellido) AS nombreCompleto,imagen FROM usuarios WHERE idUsuario= ? ");
$db->prep()->bind_param('i',$_SESSION['idUsuario']);
$db->ejecutar();
$db->prep()->bind_result($unombre,$uimagen);
$db->resultado();
$db->liberar();//creo que se uso para liberar espacio para la siguiente consulta la de la linea de abajo, si no bota error







?>
<?php require "inc/header.inc"; ?>
<div class="izq">
    <div class="perfil">
        
              <img class="img-fluid img-thumbnail rounded-circle" src='<?php echo "$uimagen"?>' alt="">
    </div>
    <div class="nombre text-center">
        <h4><?php echo ucwords($unombre);?></h4>
    </div>
</div>
<div class="der">
    <div class="cabecera">
        <h1 class="titulo">
            Administración <small>Hola bienvenido a la administracion del portal</small>
        </h1> 
        <div class="fecha float-right">
            <img src="img/calendar-fill.svg" alt="">
            <span><?php echo "$mes $diaN, $anio - $dia2"?></span>
        </div>
        
    </div>
    <div class="container-fluid">
     <?php if(isset($_GET['editar'])):?>
      <div class="row">
          <div class="col-12">
               <?php
                    $e_id= $_GET['editar'];
              
                    $db->preparar("SELECT nombre,apellido,email,telefono,direccion,edad,ciudad, departamento,codigoPostal FROM usuarios WHERE idUsuario= ? ");
              
                    $db->prep()->bind_param('i',$_GET['editar']);
                    $db->ejecutar();
                    $db->prep()->bind_result($enombre,$eapellido,$eemail,$etelefono,$edireccion, $eedad, $eciudad, $edepartamento,$ecodigoPostal);
                    $db->resultado();
                    $db->liberar();
               ?>
            
              <form action="" method="post" role="form" enctype="multipart/form-data"><!--enctype para que pueda recibir imagenes-->
                 <h2 class="text-center">Actualizar</h2>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="nombre" name="nombre" placeholder="<?php echo $enombre;?>">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="apellido" name="apellido" placeholder="<?php echo $eapellido;?>">
                  </div>
                  <div class="form-group row">
                    
                      <input type="text" class="form-control col-md-7 col-centrar" id="usuario" name="email" placeholder="<?php echo $eemail;?>">
                    
                  </div>
                  <div class="form-group row">
                    
                      <input type="password" class="form-control col-md-7 col-centrar" id="contrasena" name="contrasena" placeholder="Contraseña">
                    
                  </div>
                  <div class="form-group row">
                    
                      <input type="password" class="form-control col-md-7 col-centrar" id="confirContrasena" name="confirContrasena" placeholder="Confirma la contraseña">
                    
                  </div>
                  
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="telefono" name="telefono" placeholder="<?php echo $etelefono;?>">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="direccion" name="direccion" placeholder="<?php echo $edireccion;?>">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="edad" name="edad" placeholder="<?php echo $eedad;?>">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="ciudad" name="ciudad" placeholder="<?php echo $eciudad;?>">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="departamento" name="departamento" placeholder="<?php echo $edepartamento;?>">
                  </div>
                  <div class="form-group row">
                      <input type="text" class="form-control col-md-7 col-centrar" id="codigoPostal" name="codigoPostal" placeholder="<?php echo $ecodigoPostal;?>">
                  </div>
                  <div class="form-group row">
                     <label for="foto" class="col-md-12 text-center">Foto de perfil</label>
                      <input type="file" class="form-control col-md-7 col-centrar" name="foto">
                  </div>
                  
                  <div class="form-group row">
                      <div class="col-centrar">
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                        <button type="reset" class="btn btn-secondary">Limpiar</button>
                      </div>
                   </div>
                   

                </form>
          </div>
      </div>
      <?php else:?>
       <div class="row">
           <div class="col-md-12">
               <div class="caja">
                   <div class="caja-cabecera">
                      <h3><i class="fas fa-users"></i> Edita o elimina algún usuario</h3>
                   </div>
                   <hr>
                   <div class="caja-cuerpo">
                      <table class="table d-table-cell">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Nombre</th>
                              <th>Email</th>
                              <th>Cedula</th>
                              <th>Telefono</th>
                              <th>Direccion</th>
                              <th>Edad</th>
                              <th>Ciudad</th>
                              <th>Departamento</th>
                              <th>Codigo Postal</th>
                              <th>Fecha</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                           <?php 
                              $db->preparar("SELECT idUsuario,CONCAT (nombre,' ',apellido) AS nombreCompleto,email,cedula,telefono,direccion,edad,ciudad,departamento,codigoPostal,fecha FROM usuarios ORDER BY fecha");
                                $db->ejecutar();
                                $db->prep()->bind_result($dbid,$dbnombreCompleto,$dbemail,$dbcedula,$dbtelefono,$dbdireccion,$dbedad,$dbciudad,$dbdepartamento,$dbcodigoPostal,$dbfecha);
                              
                                $conteo=0;
                                while($db->resultado()){
                                    $conteo++;
                                    echo "<tr>
                                          <td>$conteo</td>
                                          <td>$dbnombreCompleto</td>
                                          <td>$dbemail</td>
                                          <td>$dbcedula</td>
                                          <td>$dbtelefono</td>
                                          <td>$dbdireccion</td>
                                          <td>$dbedad</td>
                                          <td>$dbciudad</td>
                                            <td>$dbdepartamento</td>
                                            <td>$dbcodigoPostal</td>
                                            <td>".date("d/m/Y",$dbfecha)."</td>
                                            <td><a class='btn btn-success' href='editar.php?editar=$dbid'><i class='fas fa-edit'></i></a></td>
                                            <td><a class='btn btn-danger' href='editar.php?eliminar=$dbid'><i class='fas fa-trash-alt'></i></a></td>
                                            
                                        </tr>";
    
                                }
                              $db->liberar();//solo liberar despues de haber usado las variables que asignamos con los datos de la BD
                            ?>
                            
                          </tbody>
                        </table>
                       
                   </div>
               </div>
           </div>
       </div>
       <?php endif;?>
   </div>
</div>

   
    <?php require "inc/footer.inc"; ?>