<?php
header("Access-Control-Allow-Origin: *"); // Permitir CORS
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type"); // Cabeceras permitidas

// Configuración de la base de datos
$host = 'localhost'; // Cambia esto si tu baste de datos está en otro servidor
$dbname = 'ecounlz'; // Cambia esto por el nombre de tu base de datos
$username = 'root'; // Cambia esto por tu usuario de base de datos
$password = ''; // Cambia esto por tu contraseña de base de datos

try {
    // Crear conexión
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar el modo de error de PDO para que lance excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL
    $sql = "SELECT * FROM horarios"; // Cambia esto por tu consulta SQL
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    // Manejo de errores
    echo json_encode(['error' => $e->getMessage()]);
}

// Cerrar la conexión
$conn = null;
?>