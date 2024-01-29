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
if(isset($data["usuario"]) && isset($data["clave"]))
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $usuario = $data["usuario"];
    $clave = $data["clave"];
    try {
    $conn = new PDO("mysql:host=$servername;dbname=posta_medica", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, Usuario, Clave FROM tb_usuarios WHERE Usuario='$usuario'");
    $stmt->execute();
    $rpta = $stmt->fetch();
    if(isset($rpta["Clave"]))
    {
        if($rpta["Clave"]==$clave){
            $response = array(
                "success"=>true,
                "message"=>"USUARIO LOGEADO"
            );
        }else{
            $response = array(
                "success"=>false,
                "message"=>"USUARIO INCORRECTO",
            );
        }
    }else{
        $response = array(
            "success"=>false,
            "message"=>"USUARIO INCORRECTO",
        );
    }
    
    echo json_encode($response);
    } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    }
}else{
    $response = array(
        "success"=>false,
        "message"=>"USUARIO INCORRECTO",
    );
    echo json_encode($response);
}
