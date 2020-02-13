<?php $archivoActual=$_SERVER['SCRIPT_NAME'];?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>
<body class="<?php if($archivoActual=='/portal/index.php'){echo 'bg';}?>">

              
<?php if($archivoActual =='/portal/admin.php' || $archivoActual =='/portal/editar.php'):?>
<header>
   <a href="admin.php" class="logo">
      <i class="fas fa-fire"></i>
       <span>Portal</span>
   </a>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <?php if($archivoActual != '/portal/editar.php'){
                     if($_SESSION['rol']=='administrador'){
                         echo '<li class="nav-item">
                                    <a class="nav-link" href="editar.php">Editar <i class="fas fa-edit"></i></a>
                                  </li>';
                     }
                    }
              ?>
         
        </ul>
        <a id="logout" class="btn btn-primary ml-auto" href="#">Cerrar Sesión <i class="fas fa-sign-out-alt"></i></a>

      </div>
    </nav>
</header>
<?php endif;?>
