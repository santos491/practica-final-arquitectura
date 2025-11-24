<?php

header('Content-Type: application/json');
include_once '../../config/db_config.php';
include_once 'Subject.php'; 

$db_perfiles = getPdoConnection('hrm_empleados_perfiles');
$action = $_GET['action'] ?? '';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if ($action === 'alta') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['nombre']) || empty($data['puesto']) || empty($data['email'])) {
                http_response_code(400); echo json_encode(['error' => 'Datos de alta incompletos.']); exit;
            }
            altaEmpleadoSubject($data);
        }
        break;
        
    case 'GET':
        if ($action === 'listado') {
            $stmt = $db_perfiles->query("SELECT id_empleado, nombre, puesto, fecha_ingreso, id_jefe, email FROM empleados ORDER BY id_empleado ASC");
            $listado = $stmt->fetchAll();
            echo json_encode($listado);
            exit;
        }

        if ($action === 'email' && isset($_GET['id_empleado'])) {
            $stmt = $db_perfiles->prepare("SELECT email FROM empleados WHERE id_empleado = ?");
            $stmt->execute([$_GET['id_empleado']]);
            $email = $stmt->fetchColumn();
            
            if ($email) {
                echo json_encode(['email' => $email]);
            } else {
                http_response_code(404); echo json_encode(['error' => 'Empleado no encontrado.']);
            }
        }
        break;

    default:
        http_response_code(405); echo json_encode(['error' => 'Método no permitido.']);
}