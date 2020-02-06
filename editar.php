<?php 
session_start();//con el metodo aqui podremos acceder a las variables SESSION que vienen del login.php
require 'lib/errores.php';
require 'lib/config.php'; 
require 'lib/validarFoto.php';
    
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
              
                    $db->preparar("SELECT nombre,email,telefono,direccion,edad,ciudad, departamento,codigoPostal FROM usuarios WHERE idUsuario= ? ");
              
                    $db->prep()->bind_param('i',$_GET['editar']);
                    $db->ejecutar();
                    $db->prep()->bind_result($enombre,$eemail,$etelefono,$edireccion, $eedad, $eciudad, $edepartamento,$ecodigoPostal);
                    $db->resultado();
                    $db->liberar();
               ?>
            
              <form action="actualizar.php" method="post" role="form" enctype="multipart/form-data"><!--enctype para que pueda recibir imagenes-->
                 <h2 class="text-center">Actualizar</h2>
                 
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
                      <input type="hidden" class="form-control col-md-7 col-centrar" id="id" name="id" value="<?php echo $e_id;?>">
                  </div>
                  <div class="form-group row">
                      <input type="hidden" class="form-control col-md-7 col-centrar" name="enombre" value="<?php echo $enombre;?>">
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
      <?php elseif(isset($_GET['confirEliminar']))://originalmente solo ponia que si habia valor confiEliminar en el metodo get, pero me mandaba erroe de undefined index, asi que use el isset?>
      <div class="row">
          <div class="col-5 col-centrar">
          <div class="caja text-center">
              <h2>¿Seguro desear eliminar a este usuario?</h2>
              <a class="btn btn-danger" href='<?php echo "editar.php?eliminar={$_GET['confirEliminar']}";?>'>Si</a>
              <a class="btn btn-info" href='editar.php'>No</a>
          </div> 
          </div>
      </div>
      <?php elseif(isset($_GET['eliminar']))://originalmente solo ponia que si habia valor confiEliminar en el metodo get, pero me mandaba erroe de undefined index, asi que use el isset?>
      <div class="row">
          <div class="col-5 col-centrar">
          <div class="caja text-center">
             
              <?php 
              $eliminar= $_GET['eliminar'];
              
              
              
                    $db->preparar("SELECT nombre FROM usuarios WHERE idUsuario= ? ");
              
                    $db->prep()->bind_param('i',$eliminar);
                    $db->ejecutar();
                    $db->prep()->bind_result($name);
                    $db->resultado();
                    $db->liberar();
              
              
              
              $db->preparar("DELETE FROM usuarios WHERE idUsuario= ? ");
              
                    $db->prep()->bind_param('i',$eliminar);
                    $db->ejecutar();
              
                    if($db->filaAfectada()>0){
                        header("Refresh:5; url=editar.php");
                        echo "<h4>Eliminacion completada completada, seras redirrecionado en 5 s, {$db->filaAfectada()} registro afectado. </h4>";
                        borrarCarpetas("fotos/$name",true);//borramos la carpeta de la foto del usuario
                    }
                    $db->liberar();
              ?>
          </div> 
          </div>
      </div>
      <?php else:?>
       <div class="row">
           <div class="col-md-12">
               <div class="caja">
                   <div class="caja-cabecera">
                     <div class="row" style="align-items:center;padding:0px 10px;">
                      <h3><i class="fas fa-users"></i> Edita o elimina algún usuario</h3>
                      
                          <form class="form-inline col-4 ml-auto" id="busqueda" method="get" style="justify-content: flex-end;">
                            <input name="busqueda" class="form-control mr-sm-2" type="search" placeholder="Parametro..." aria-label="Search">
                            <button class="btn btn-primary my-2 my-sm-0" type="submit">Buscar</button>
                          </form>
                        </div>
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
                              if(isset($_GET['busqueda'])){//el input de tipo submit, envia datos por el metodo get, si enviamos algo haremos la consulta con los datos pasados por el campo de la busquedad, de lo contrario, usaremos la consulta general del else
                                  if(empty($_GET['busqueda'])){
                                      trigger_error("No puedes dejar vacio el campo de busqueda.",E_USER_ERROR);
                                      exit;
                                  }
                                  $consulta="SELECT idUsuario,CONCAT (nombre,' ',apellido) AS nombreCompleto,email,cedula,telefono,direccion,edad,ciudad,departamento,codigoPostal,fecha FROM usuarios WHERE nombre LIKE";
                                  
                                  $busqueda= explode(" ",$_GET['busqueda']);
                                 
                                  
                                  for($i=0; $i< count($busqueda);$i++){//recorremos el array que creamos con el metodo explode con los datos que sacamos del metodo get busquedad, ejemplo "johan carla", entonces preguntamos primer que el campo no este vacio, luego si estamos en el indice 0 es decir johan para que de una vez la consulta sume "LIKE 'johan'", iteramos ahora i vale 1 entonces estamos en carla asi quedaria la consulta como "LIKE 'johan' OR nombre LIKE 'carla'
                                      if($busqueda[$i]!=''){
                                          if($i!=0){
                                              $consulta.=" OR nombre LIKE";
                                          }
                                          $consulta.=" '%{$busqueda[$i]}%'";
                                      }
                                  }
                                  
                                  $consulBusqueda= "SELECT COUNT(idUsuario) FROM usuarios WHERE nombre LIKE";
                                  for($i=0; $i< count($busqueda);$i++){
                                      if($busqueda[$i]!=''){
                                          if($i!=0){
                                              $consulBusqueda.=" OR nombre LIKE";
                                          }
                                          $consulBusqueda.=" '%{$busqueda[$i]}%'";
                                      }
                                  }
                                  $db->preparar($consulBusqueda);
                                        $db->ejecutar();
                                        $db->prep()->bind_result($contador);
                                          $db->resultado();
                                          $db->liberar();
                                        $datosPorPagina=2;

                                          $paginas=ceil($contador/$datosPorPagina);//redondea haci arriba
                                          $pagina= (isset($_GET['pagina'])) ? (int)$_GET['pagina']:1;//if ternario usamos el ? para indicar lo que sucedera si es true y el : para cuando es false, el (int) fuerza a la variable a ser un interger, si no mandara nada el metodo get devolvemos 1

                                          $iniciar= ($pagina-1)*$datosPorPagina;
                                  $consulta.=" ORDER BY fecha LIMIT $iniciar,$datosPorPagina";

                                  
                            }else{
                                      $db->preparar("SELECT COUNT(idUsuario) FROM usuarios ");
                                        $db->ejecutar();
                                        $db->prep()->bind_result($contador);
                                          $db->resultado();
                                          $db->liberar();
                                          $datosPorPagina=2;

                                          $paginas=ceil($contador/$datosPorPagina);//redondea haci arriba
                                          $pagina= (isset($_GET['pagina'])) ? (int)$_GET['pagina']:1;//if ternario usamos el ? para indicar lo que sucedera si es true y el : para cuando es false, el (int) fuerza a la variable a ser un interger, si no mandara nada el metodo get devolvemos 1

                                          $iniciar= ($pagina-1)*$datosPorPagina;

                                          $consulta="SELECT idUsuario,CONCAT (nombre,' ',apellido) AS nombreCompleto,email,cedula,telefono,direccion,edad,ciudad,departamento,codigoPostal,fecha FROM usuarios ORDER BY fecha LIMIT $iniciar,$datosPorPagina";
                                  }
                              
                              
                              
                              
                              
                              
                              $db->preparar($consulta);
                                $db->ejecutar();
                                $db->prep()->bind_result($dbid,$dbnombreCompleto,$dbemail,$dbcedula,$dbtelefono,$dbdireccion,$dbedad,$dbciudad,$dbdepartamento,$dbcodigoPostal,$dbfecha);
                              
                              
                              if(isset($_GET['busqueda'])){
                                  if($contador>1){
                                      echo "<h3>$contador resultados encontrados</h3>";
                                  }else{
                                      echo "<h3>$contador resultado encontrado</h3>";
                                  }
                              }
                              
                                $conteo=$iniciar;
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
                                            <td style='padding:0!important;' class='text-center'><a class='btn btn-success acciones' href='editar.php?editar=$dbid'><i class='fas fa-edit'></i></a>
                                            <a class='btn btn-danger acciones' href='editar.php?confirEliminar=$dbid'><i class='fas fa-trash-alt'></i></a></td>
                                            
                                            
                                        </tr>";//cpn el editar.php?editar = a algo enviamos datos por el metodo get
    
                                }
                              $db->liberar();//solo liberar despues de haber usado las variables que asignamos con los datos de la BD
                            ?>
                            
                          </tbody>
                        </table>
                       <?php
                       $anterior=($pagina-1);
                       $siguiente=($pagina+1);
                       if(isset($_GET['busqueda'])){
                           $pagAnterior= "?pagina=$anterior&busqueda={$_GET['busqueda']}";//recordar que por el metodo get se pueden enviar parametros para jugar con ellos, aqui mantendremos los valores de la busqueda
                           $pagSiguiente= "?pagina=$siguiente&busqueda={$_GET['busqueda']}";
                       }else{
                           $pagAnterior= "?pagina=$anterior";
                           $pagSiguiente= "?pagina=$siguiente";
                       }
                       ?>
                       <nav>
                          <ul class="pagination">
                           <?php if(!($pagina<=1)):?>
                            <li class="page-item"><a class="page-link" href='<?php echo $pagAnterior?>'>Anterior</a></li>
                            <?php endif;?>
                            <?php 
                              if(isset($_GET['busqueda'])){
                                  if($paginas >1){
                                  for($x=1;$x<=$paginas;$x++){
                                      echo ($x==$pagina) ? "<li class='page-item active'><a class='page-link' href='?pagina=$x&busqueda={$_GET['busqueda']}'>$x</a></li>" : "<li class='page-item'><a class='page-link' href='?pagina=$x&busqueda={$_GET['busqueda']}'>$x</a></li>";
                                  }
                                  
                              }
                              }else{
                                  if($paginas >1){
                                  for($x=1;$x<=$paginas;$x++){// recordar que paginas es el numero de ella que se necesitaran para mostrar los datos extraidos de la base de datos siendo que paginas resulta de la division de contador(el numero de registros id de los usuarios )entre datosporpagina(en nuestro caso 3) si llegaran por ejemplo 6 usuaios entre 3 serian 2 paginass
                                      echo ($x==$pagina) ? "<li class='page-item active'><a class='page-link' href='?pagina=$x'>$x</a></li>" : "<li class='page-item'><a class='page-link' href='?pagina=$x'>$x</a></li>";
                                  }
                                  
                              }
                              }
                              
                            
                                ?>
                            <?php if(!($pagina==$paginas)):;?>
                            <li class="page-item"><a class="page-link" href='<?php echo $pagSiguiente?>'>Siguiente</a></li>
                            <?php endif;?>
                            
                          </ul>
                        </nav>
                   </div>
               </div>
           </div>
       </div>
       <?php endif;?>
   </div>
</div>

   
    <?php require "inc/footer.inc"; ?>