<?php
//aqui creamos nuestro propio gesto de errores, asi saldran advertencias a los usuarios deacuerdo a los trigger error que hagamos
function miGestorErrores($errno,$errstr,$errfile,$errline){
    if (!(error_reporting() & $errno)) {
        // Este código de error no está incluido en error_reporting
        return;//ni papa esto esta en el manual php
    }
    
    switch ($errno){
        case E_USER_ERROR:
            echo "
            <div class='alerta alerta-error'>
                <div class='alerta-icon'>
                    <img src='img/alert-triangle.svg' style='width:100%' alt=''>
                </div>
                <div > 
                    Error:  $errstr 
                </div>
            </div>
            
            ";
            exit(1);
            break;
            
           
            
            case E_USER_WARNING:
            echo "
            <div class='alerta alerta-warning'>
                <div class='alerta-icon'>
                    <img src='img/alert-triangle.svg' style='width:100%' alt=''> 
                </div>

                <div > 
                    Error: [$errno] $errstr, este problema se presentó en la línea $errline, en el archivo $errfile 
                </div>
        

            </div>
                ";
            exit();
            break;
            
            case E_USER_NOTICE:
            echo "
            <div class='alerta alerta-info'>
                <div class='alerta-icon'>
                    <img src='img/alert-triangle.svg' style='width:100%' alt=''>
                </div>

                <div > 
                    $errstr 
                </div>
        

            </div>
            ";
            break;
            
            default:
            echo "Tipo de error desconocido: [$errno] $errstr<br />\n";
            break;
    }
    /* No ejecutar el gestor de errores interno de PHP */
    return true;
}

set_error_handler('miGestorErrores');//con esta funcion establecemos nuestro propio manejador de errores
