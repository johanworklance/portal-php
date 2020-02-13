<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>enviar email</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>
<body>
   <div class="container-fluid">
      <div class="row">
         <div class="col-4 offset-4 mt-3">
            <?php//no pude enviar nada, no funciona desde localhost, y gilbet no explico
             $validar="";
             if($_POST){
                 extract($_POST);
                 
                 $para= "hoanconversa@gmail.com";
                 /*$cabeceras= "MIME-Version: 1.0\n";
                 $cabeceras.= "Content-Type: text/html; charset=utf8 \n";*/
                 $cabeceras= "From: desde la web <$para>\n";
                 /*$cabeceras.= "Reply-To: otro@otro.com\n";
                 $cabeceras.= "Return-Path: correo@correo.com\n";
                 $cabeceras.= "Cc: \n";
                 $cabeceras.= "Bcc: \n";*/
                 
                 $msg= "
                        Nombre: $nombre \n
                        Asunto: $asunto \n
                        Mensaje: $mensaje \n
                        Email: $email \n
                        Fecha: ".date('d/m/Y')." \n
                        Hora: ".date('h:i:s a')." \n
                        IP: ".$_SERVER['REMOTE_ADDR']." \n
                        
                        Mensaje: \n
                        $mensaje
                 
                 ";
                 
                 $validar= mail($para,$asunto,$msg, $cabeceras);//correo, asunto, el cuerpo del mensaje, y las cabeceras unos metadatos
                  if($validar):
                     echo "el email se envio correctamente";
                     else:
                     echo "hubo un error, por favor intente mas tarde";
                 endif;
             }
             ?>
             
             <form method="post" role="form">
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email"  placeholder="email">
                    
                  </div>
                  <div class="form-group">
                    <label for="nombre">nombre</label>
                    <input type="text" class="form-control" name='nombre' id='nombre' placeholder="nombre">
                  </div>
                  <div class="form-group">
                    <label for="nombre">asunto</label>
                    <input type="text" class="form-control" name='asunto' id='asunto' placeholder="asunto">
                  </div>
                  <div class="form-group">
                    <label for="nombre">mensaje</label>
                    <textarea type="text" class="form-control" name='mensaje'rows="3" id='mensaje' placeholder="asunto">
                  </textarea>
                 </div>
                  
                  <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
            
         </div>
          
      </div>
       
   </div>
    
<script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>