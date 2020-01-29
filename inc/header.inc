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

              
<?php if($archivoActual =='/portal/admin.php'):?>
<header>
   <a href="admin.php" class="logo">
      <i class="fas fa-fire"></i>
       <span>Portal</span>
   </a>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          
          <li class="nav-item">
            <a class="nav-link" href="#">Agregar <i class="fas fa-plus-square mas"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="editar.php">Editar <i class="fas fa-edit"></i></a>
          </li>
          <!--<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>-->
        </ul>
        <a class="btn btn-primary ml-auto" href="logout.php">Cerrar Sesión <i class="fas fa-sign-out-alt"></i></a>

      </div>
    </nav>
</header>
<?php endif;?>
