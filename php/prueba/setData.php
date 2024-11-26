<?php
header("Access-Control-Allow-Origin: *"); // Permitir CORS
header("Access-Control-Allow-Methods: POST"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type"); // Cabeceras permitidas

// Configuración de la base de datos
$host = 'localhost'; // Cambia esto si tu base de datos está en otro servidor
$dbname = 'ecounlz'; // Cambia esto por el nombre de tu base de datos
$username = 'ecounlz'; // Cambia esto por tu usuario de base de datos
$password = ''; // Cambia esto por tu contraseña de base de datos

try {
    // Crear conexión
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar el modo de error de PDO para que lance excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos enviados desde React Native
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar que se recibieron los datos necesarios
    if (isset($data['dia'], $data['hora_inicio'], $data['profesor'], $data['hora_fin'], $data['materia'])) {
        // Preparar la consulta SQL
        $sql = "INSERT INTO horarios (dia, hora_inicio, profesor, hora_fin, materia) VALUES (:dia, :hora_inicio, :profesor, :hora_fin, :materia)";
        $stmt = $conn->prepare($sql);

        // Bind de los parámetros
        $stmt->bindParam(':dia', $data['dia']);
        $stmt->bindParam(':hora_inicio', $data['hora_inicio']);
        $stmt->bindParam(':profesor', $data['profesor']);
        $stmt->bindParam(':hora_fin', $data['hora_fin']);
        $stmt->bindParam(':materia', $data['materia']);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Datos insertados correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al insertar los datos.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Faltan datos necesarios.']);
    }
} catch (PDOException $e) {
    // Manejo de errores
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

// Cerrar la conexión
$conn = null;
?><