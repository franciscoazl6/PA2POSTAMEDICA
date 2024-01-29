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
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData, true);
    $servername = "localhost";
    $username = "root";
    $password = "";
    try {
    $conn = new PDO("mysql:host=$servername;dbname=posta_medica", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, Especialidad, FechaCita FROM tb_citas ORDER BY FechaCita DESC LIMIT 10");
    $stmt->execute();
    $rpta = $stmt->fetchAll(PDO::FETCH_CLASS);
    $response = array(
        "success"=>true,
        "data"=>$rpta,
    );
    
    echo json_encode($response);
    } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    }
