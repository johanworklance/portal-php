<?php

class Database{
    public $db;//la variable para la conexion
    protected $resultado;//sera la variable con query que usaremos para hacer validaciones rapidas
    protected $prep;//la consulta
    protected $consulta;
    public function __construct($dbhost, $dbuser, $db_pass, $db_name){
        $this->db= new mysqli($dbhost, $dbuser, $db_pass, $db_name);
        if($this->db->connect_errno){//si ocurre un error este atributo de la clase "conexion con msql" sera true
            echo "error<br>";
            trigger_error("Fallo la conexion con Mysql, tipo de error -> ({$this->db->connect_error})", E_USER_ERROR);//mandamos el error con el manejador e imprimimos tambien el error con el metodo connect_error
        }
        $this->db->set_charset('utf8');//establecemos el tipo de charset, justo despues de hace la variable con el tipo de obejto mysqli
    }
    public function preparar($consulta){//CON ESTE METODO ENVIAREMOS LAS CONSULTAS QUE DESEEMOS DESDE CUALQUIER PARTE DEL PROGRAMA
        $this->consulta= $consulta;
        $this->prep= $this->db->prepare($this->consulta);//la funcion prepare bueno prepara una consulta, es decir la lee para saber si en verdad es una consulta sql, y hara que el atributo prep de esta clase reciba un objeto por valor, asi ganando metodos, devolvera false si algo sale mal
        if(!$this->prep){
            trigger_error("Error al preparar la consulta", E_USER_ERROR);
        }else{
            return true;
        }
        
    }
    public function ejecutar(){
        $this->prep->execute();//ejecutamos la sentencia sql, es regla del lenguaje
    }
    public function prep(){
        return $this->prep;//para usarlo, como es protected, no podriamos usarlo fuera de la clase o sus hijos, ademas de que con el prep accederemos a la funcion bind_result
    }
    public function resultado(){
        return $this->prep->fetch();//aqui con el metodo obtendremos el primer resultado de la consulta que consiga, si son varias usaremos un while
    }
    public function cambiarDatabase($db){
        $this->db->select_db($db);
    }
    public function liberar(){
        $this->prep->free_result();//libera espacio en la memoria de la consulta, pero no se bien para que es
    }
    
    public function validarDatos($columna, $tabla, $condicion){//este metodo lo usaremos para verificar que las busquedas a la base de datos sean correctas, es decir, si mostramos 3 registros, entonces validar datos mostrara el numero 3
        $this->resultado= $this->db->query("SELECT $columna FROM $tabla WHERE $columna = '$condicion'");//la condicion la ponemos entre comillas, por que en el sql, esta se espera como un string para comparar, entonces es recomendado usar las comillas dobles para la query entera, y asi usar las simples
        $chequear= $this->resultado->num_rows;
        return $chequear; //si con el metodo anterior me refiero al uso del prepare,bind_result(se les llaman prepared statement) mostramos en pantalla 3 resultados de alguna condicion, con este metodo devolveremos ese mismo numero de busquedas, usando el direct query
    }
    public function cerrar(){
        $this->prep->close();
        $this->db->close();
    }
    
}
?>
