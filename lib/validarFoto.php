<?php

function validarFoto($nombre, $update=false){
   
    
    if($update){
        
        borrarCarpetas("fotos/$nombre");//la idea es que borrarCarpetas no sea borrada, asi solo borrara los archivos de un carpeta de fotos perteneciente a un usuario
        /*$dir= "fotos/$nombre";
        $gestor= opendir($dir);//creamos un gestor con el metodo opendir
        while(($archivo=readdir($gestor))!=false){//readdir mandara un recurso de archivo si consigue archivos en el directorio, de lo contrario manda false, la creacion del archivo la hacemos en el while, para que por cada iteracion cree de nuevo la variable, el metodo readdir no envia un array, si no un archivo a la vez
            if($archivo !='.' && $archivo!='..'&& $archivo!='Thumbs.db'){//validamos que no el archivo no se ninguno de esos, por ejemplo thumbs es un archivo que windows genera
                unlink("$dir/$archivo");//borra el archivo
            }
        }
        closedir($gestor);
        sleep(1);//retrasamos la ejecucion del programa 1 s, por que no se*/
    }
    
    
    
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
    
function borrarCarpetas($dir){
    $gestor= opendir($dir);
        while(($archivo=readdir($gestor))!=false){
            if($archivo !='.' && $archivo!='..'){
                if(!unlink("$dir/$archivo")){
                    borrarCarpetas("$dir/$archivo");//la cosa es, que si por ejemplo llega por primera vez a la funcion borrarCarpetas el directorio fotos, este tendra dentro carpetas con los nombres de usuario, unlink manda false cuando le mandan rutas de carpetas llenas, por eso usar recursividad en este caso, para que primero elimine los archivos de por ejemplo johan y mas abajo eliminemos la carpeta
                }
                
            }
        }
        closedir($gestor);
        rmdir($dir);//con el rmdir, eliminamos la carpeta que dejo vacia la funcion recursiva
        sleep(1);
}

?>