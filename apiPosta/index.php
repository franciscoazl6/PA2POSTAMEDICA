<?php
// Permitir cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir métodos HTTP específicos
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Permitir ciertos encabezados HTTP
header("Access-Control-Allow-Headers: Content-Type");

// Permitir cookies
header("Access-Control-Allow-Credentials: true");

// Configurar el tiempo de vida de la solicitud preflight (en segundos)
header("Access-Control-Max-Age: 3600");

// Establecer el tipo de contenido para la respuesta
header("Content-Type: application/json");
if(isset($_POST)){
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $especialidad = $data["especialidad"];
    $fecha = $data["fecha"];;
    try {
    $pdo = new PDO("mysql:host=$servername;dbname=posta_medica", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO tb_citas (Especialidad, FechaCita)
    VALUES ('$especialidad', '$fecha')";
    // use exec() because no results are returned
    $query = $pdo->prepare($sql);
    if($query->execute()){
        $data = array(
            "success"=>true,
        );
    }else{
        $data = array(
            "success"=>false,
        );
    }
    echo json_encode($data);
    } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    }
}else{
    echo "errorrr";
}
