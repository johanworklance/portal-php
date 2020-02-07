<?php
    require 'lib/PasswordHash.php';
//GENERANDO EL HASH DE LA ENCRIPTACION DE LA CONTRASEÑA
    $contra='micontra123';
    $hasher= new PasswordHash(8, FALSE);
    $hash= $hasher->HashPassword($contra);
echo $hash;
if($hasher->CheckPassword($contra,$hash)){
    echo "<br>clave correcta";
    
}else{
    echo "clave incorrecta";
}
?>