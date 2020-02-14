<?php 
session_start();//con el metodo aqui podremos acceder a las variables SESSION que vienen del login.php
require 'lib/errores.php';
require 'lib/config.php'; 
    
spl_autoload_register(function($clase){
    require_once("lib/$clase.php");
});

if(!$_SESSION['idUsuario'] && !$_SESSION['nombre'] && !$_SESSION['rol']){
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

$db->preparar("SELECT CONCAT (nombre,' ',apellido) AS nombreCompleto,imagen,email,cedula,telefono,direccion,edad,ciudad,departamento,codigoPostal,fecha FROM usuarios WHERE idUsuario= ? ");
$db->prep()->bind_param('i',$_SESSION['idUsuario']);
$db->ejecutar();
$db->prep()->bind_result($unombre,$uimagen,$uemail,$ucedula,$utelefono,$udireccion,$uedad,$uciudad,$udepartamento,$ucodigoPostal,$ufecha);
$db->resultado();
$db->liberar();//creo que se uso para liberar espacio para la siguiente consulta la de la linea de abajo, si no bota error
$db->preparar("SELECT COUNT(idUsuario) FROM usuarios ");
$db->ejecutar();
$db->prep()->bind_result($contadorUsuarios);
$db->resultado();
$db->liberar();

$db->preparar("SELECT CONCAT (nombre,' ',apellido) AS nombreCompleto,email,cedula,telefono,direccion,edad,ciudad,departamento,codigoPostal,fecha,rol FROM usuarios ORDER BY fecha DESC LIMIT 10");
$db->ejecutar();
$db->prep()->bind_result($dbnombreCompleto,$dbemail,$dbcedula,$dbtelefono,$dbdireccion,$dbedad,$dbciudad,$dbdepartamento,$dbcodigoPostal,$dbfecha,$dbrol);



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
   <?php if($_SESSION['rol']=='administrador'):?>
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
      <div class="row">
         
          <div class="col-md-3 col-centrar">
             <div class="panel">
                 <div class="icono bg-rojo">
                     <i class="fas fa-users"></i>
                 </div>
                 <div class="valor">
                     <h1 class="cantidad"><?php echo $contadorUsuarios;?></h1>
                     <p>Usuarios</p>
                 </div>
             </div>
          </div>
          <!--<div class="col-md-3">
             <div class="panel">
                 <div class="icono bg-azul">
                     <i class="fas fa-users"></i>
                 </div>
                 <div class="valor">
                     <h1 class="cantidad">152</h1>
                     <p>Usuarios</p>
                 </div>
             </div>
          </div>
          <div class="col-md-3">
             <div class="panel">
                 <div class="icono bg-verde">
                     <i class="fas fa-users"></i>
                 </div>
                 <div class="valor">
                     <h1 class="cantidad">152</h1>
                     <p>Usuarios</p>
                 </div>
             </div>
          </div>
          <div class="col-md-3">
             <div class="panel">
                 <div class="icono bg-amarillo">
                     <i class="fas fa-users"></i>
                 </div>
                 <div class="valor">
                     <h1 class="cantidad">152</h1>
                     <p>Usuarios</p>
                 </div>
             </div>
          </div>-->
          
      </div>
       <div class="row">
           <div class="col-md-12">
               <div class="caja">
                   <div class="caja-cabecera">
                       <span>Ultimos usuarios registrados</span>
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
                              
                            </tr>
                          </thead>
                          <tbody>
                           <?php 
                                $conteo=0;
                                while($db->resultado()){
                                  if($dbrol=='administrador'){
                                    continue;
                                  }
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
                                        </tr>";
    
                                }
                              $db->liberar();//libero aqui por que solo apenas habiamos usado el fetch en el ciclo while que esta en el metodo resultado
                            ?>
                            
                          </tbody>
                        </table>
                       
                   </div>
               </div>
           </div>
       </div>
   </div>
   <?php else:?>
           <div class="cabecera">
        <h1 class="titulo">
            Hola bienvenido al portal
        </h1> 
        <div class="fecha float-right">
            <img src="img/calendar-fill.svg" alt="">
            <span><?php echo "$mes $diaN, $anio - $dia2"?></span>
        </div>
        
    </div>
    <div class="container-fluid">
      
       <div class="row">
           <div class="col-md-12">
               <div class="caja">
                   <div class="caja-cabecera">
                       <h1>Tus datos</h1>
                   </div>
                   <hr>
                   <div class="caja-cuerpo">
                      <table class="table d-table-cell">
                          <thead>
                            <tr>
                              
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
                              
                            </tr>
                          </thead>
                          <tbody>
                           <?php 
                                
                                    echo "<tr>
                                          
                                          <td>$unombre</td>
                                          <td>$uemail</td>
                                          <td>$ucedula</td>
                                          <td>$utelefono</td>
                                          <td>$udireccion</td>
                                          <td>$uedad</td>
                                          <td>$uciudad</td>
                                            <td>$udepartamento</td>
                                            <td>$ucodigoPostal</td>
                                            <td>".date("d/m/Y",$ufecha)."</td>
                                        </tr>";
    
                                
                            ?>
                            
                          </tbody>
                        </table>
                       
                   </div>
               </div>
           </div>
       </div>
   </div>
   <?php endif;?>
</div>

   
    <?php require "inc/footer.inc"; ?>