
     
             
              <?php 
require 'lib/errores.php';
                require 'lib/config.php'; 
                require 'lib/validarFoto.php';

                spl_autoload_register(function($clase){
                    require_once("lib/$clase.php");
                });
$db= new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$output=[];
    if(isset($_POST['eliminar']))
                {
        
              $eliminar= $_POST['eliminar'];
              
              
              
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
                        
                        
                        borrarCarpetas("fotos/$name",true);//borramos la carpeta de la foto del usuario
                        $output= ["estado"=>"ok", "msg"=>"Eliminacion completada"];
                        
                    }else{
                        $output= ["estado"=>"fallido", "msg"=>"Consulta con el administrador"];
                    }
                        $json= json_encode($output);
                        echo $json;
                    $db->liberar();}

              ?>
         