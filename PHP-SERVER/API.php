<?php
    //http://stackoverflow.com/questions/18382740/cors-not-working-php
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
 
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
 
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
 
        exit(0);
    }
 
    $postdata = file_get_contents("php://input");
    if (isset($postdata)) {
        $request = json_decode($postdata);
        $opcion = $request->opcion;
        include('conexion.php'); // USUARIO Y CONTRSEÑA
        $db = new PDO('mysql:host=localhost;dbname=IonicDatabase', $usuario, $contraseña); // DATOS DE CONEXION (localhost,dbname,user,password)
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        switch ($opcion) {
            case 'SeleccionUsuarios':
                $estado = true;
                $consulta = "SELECT * FROM IonicDatabase.usuarios WHERE 1";
                $consulta->execute(array()); 
                $estado = $estado && $consulta;
                $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                if ($estado){
                    echo json_encode(array('estado'=>$estado,'datos'=>$datos));
                } else {
                    echo json_encode(array('estado'=>$estado,'mensaje'=>'Hubo un problema,pruebe nuevamente.'));
                }
            break;
        }   
    }
    echo json_encode(array('estado'=>$estado,'datos'=>'Estoy dentro de la API'));

?>