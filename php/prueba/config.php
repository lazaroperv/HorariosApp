<?php
header("Access-Control-Allow-Origin: *"); // Permitir CORS
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type"); // Cabeceras permitidas

$host = 'sql208.infinityfree.com'; 
$dbname = 'if0_37574852_XXX';
$username = 'if0_37574852';
$password = '7tfY4nsLgy7eyQo';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        // Obtener horarios
        if (isset($_GET['id'])) {
            $sql = "SELECT * FROM horarios WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $_GET['id']);
        } else {
            $sql = "SELECT * FROM horarios";
            $stmt = $conn->prepare($sql);
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);

    } elseif ($method === 'POST') {
        // Insertar un nuevo horario
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['dia'], $data['hora_inicio'], $data['profesor'], $data['hora_fin'], $data['materia'])) {
            $sql = "INSERT INTO horarios (dia, hora_inicio, profesor, hora_fin, materia) VALUES (:dia, :hora_inicio, :profesor, :hora_fin, :materia)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':dia', $data['dia']);
            $stmt->bindParam(':hora_inicio', $data['hora_inicio']);
            $stmt->bindParam(':profesor', $data['profesor']);
            $stmt->bindParam(':hora_fin', $data['hora_fin']);
            $stmt->bindParam(':materia', $data['materia']);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Datos insertados correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al insertar los datos.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Faltan datos necesarios.']);
        }

    } elseif ($method === 'PUT') {
        // Actualizar un horario
        parse_str(file_get_contents("php://input"), $data);
        if (isset($data['id'], $data['dia'], $data['hora_inicio'], $data['profesor'], $data['hora_fin'], $data['materia'])) {
            $sql = "UPDATE horarios SET dia = :dia, hora_inicio = :hora_inicio, profesor = :profesor, hora_fin = :hora_fin, materia = :materia WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':dia', $data['dia']);
            $stmt->bindParam(':hora_inicio', $data['hora_inicio']);
            $stmt->bindParam(':profesor', $data['profesor']);
            $stmt->bindParam(':hora_fin', $data['hora_fin']);
            $stmt->bindParam(':materia', $data['materia']);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Horario actualizado con éxito.']);
            } else {
                echo json_encode(['message' => 'No se pudo actualizar el horario.']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos necesarios para actualizar.']);
        }

    } elseif ($method === 'DELETE') {
        // Eliminar un horario
        parse_str(file_get_contents("php://input"), $data);
        if (isset($data['id'])) {
            $sql = "DELETE FROM horarios WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $data['id']);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Horario eliminado con éxito.']);
            } else {
                echo json_encode(['message' => 'No se pudo eliminar el horario.']);
            }
        } else {
            echo json_encode(['message' => 'Falta el ID para eliminar el horario.']);
        }

    } else {
        echo json_encode(['message' => 'Método no permitido.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    $conn = null; // Cerrar la conexión
}
?>
