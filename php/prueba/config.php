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
$conn=null;
?>
<?php
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
?>
<?php
$data = json_decode(file_get_contents("php://input"));

$id = isset($_GET['id']) ? $_GET['id'] : die();
$dia = $data->dia;
$hora_inicio = $data->hora_inicio;
$hora_fin = $data->hora_fin;
$materia = $data->materia;
$profesor = $data->profesor;

$sql = "UPDATE horarios SET dia = ?, hora_inicio = ?, hora_fin = ?, materia = ?, profesor = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $dia, $hora_inicio, $hora_fin, $materia, $profesor, $id);

if ($stmt->execute()) {
    echo json_encode(array("message" => "Horario actualizado con éxito."));
} else {
    echo json_encode(array("message" => "No se pudo actualizar el horario."));
}

$stmt->close();
$conn=null;
?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : die();
$sql = "DELETE FROM horarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(array("message" => "Horario eliminado con éxito."));
} else {
    echo json_encode(array("message" => "No se pudo eliminar el horario."));
}

$stmt->close();
$conn=null;
?>