<?php

function validarFoto($nombre){
    global $dirSubida;
    global $rutaSubida;
    global $error;
    $dirSubida= "fotos/$nombre/";
    

    $foto= $_FILES['foto'];//los fatos file de un formulario, llegan a la super global FILES
    $nombreFoto= $foto["name"];
    $nombreTmp= $foto["tmp_name"];
    $rutaSubida= "{$dirSubida}profile.jpg";//asi cambiar los nombres de fotos 
    $extArchivo= preg_replace("/image\//","",$foto["type"]);//el type del archivo file del formulario tiena esto image/jpeg, con el preg_replace le eliminamos el image/ (Para escapar valores se utiliza la barra invertida \ es decir para el "/"lo precedemos un con "\")
        
    if($extArchivo=='jpeg' || $extArchivo=='png'){
        if(!file_exists($dirSubida)){//devolvera false si no la encuentra, la negamos y hacemos que entre al bloque de codigo
        mkdir($dirSubida,0777);//igual aqui creamos la carpeta de foto para cada usuario
    }
        if(move_uploaded_file($nombreTmp,$rutaSubida)){//Mueve un archivo subido a una nueva ubicación
            //echo"<img src='$rutaSubida' class='img-fluid' alt=''>";//aqui mostramos la imagen que se guardo en la carpeta fotos con el nombre profile.jpg
            return true;
        }else{
            trigger_error("No se pudo mover el archivo.", E_USER_ERROR);
        }
    }else{
        trigger_error("No es un archivo de imagen válido, o no subiste una imagen.", E_USER_ERROR);
    }
    
}
    


?>