<?php


header('Content-Type: application/json');
include_once '../../config/db_config.php';
include_once 'Invoker.php'; 

$db_aus = getPdoConnection('hrm_ausencias_vacaciones');
$action = $_GET['action'] ?? '';
$id_empleado = $_GET['id_empleado'] ?? null;
$id_solicitud = $_GET['id_solicitud'] ?? null;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if ($action === 'solicitar') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['id_empleado']) || empty($data['fecha_inicio']) || empty($data['dias_solicitados'])) {
                http_response_code(400); echo json_encode(['error' => 'Datos incompletos.']); exit;
            }

            $stmt = $db_aus->prepare("SELECT dias_disponibles FROM saldos_vacaciones WHERE id_empleado = ?");
            $stmt->execute([$data['id_empleado']]);
            $saldo = $stmt->fetchColumn();

            if ($saldo === false || (float)$saldo < (float)$data['dias_solicitados']) {
                http_response_code(400); echo json_encode(['error' => 'Saldo insuficiente. Días disponibles: ' . $saldo]); exit;
            }

            $stmt = $db_aus->prepare("INSERT INTO solicitudes (id_empleado, fecha_inicio, fecha_fin, dias_solicitados, tipo_solicitud, estado) VALUES (?, ?, ?, ?, 'Vacaciones', 'Pendiente')");
            $stmt->execute([
                $data['id_empleado'],
                $data['fecha_inicio'],
                $data['fecha_fin'] ?? $data['fecha_inicio'],
                $data['dias_solicitados']
            ]);
            
            http_response_code(201); echo json_encode(['message' => 'Solicitud enviada.', 'id' => $db_aus->lastInsertId()]);
        }
        break;
        
    case 'GET':
        if ($action === 'listado') {
            $stmt = $db_aus->query("SELECT * FROM solicitudes ORDER BY fecha_inicio DESC");
            $listado = $stmt->fetchAll();
            echo json_encode($listado);
            exit;
        }
        
        if ($action === 'saldo' && $id_empleado) {
            $stmt = $db_aus->prepare("SELECT dias_disponibles, fecha_actualizacion FROM saldos_vacaciones WHERE id_empleado = ?");
            $stmt->execute([$id_empleado]);
            $saldo = $stmt->fetch();
            
            if ($saldo !== false) {
                echo json_encode(['dias_disponibles' => (float)$saldo['dias_disponibles'], 'ultima_actualizacion' => $saldo['fecha_actualizacion']]);
            } else {
                http_response_code(404); echo json_encode(['error' => 'Saldo no encontrado.']);
            }
        }
        
        if ($action === 'estatus' && $id_empleado) {
            $stmt = $db_aus->prepare("SELECT id_solicitud, fecha_inicio, fecha_fin, dias_solicitados, estado, id_aprobador FROM solicitudes WHERE id_empleado = ? ORDER BY fecha_inicio DESC");
            $stmt->execute([$id_empleado]);
            $solicitudes = $stmt->fetchAll();
            echo json_encode($solicitudes);
        }

        if ($action === 'pendientes') {
            $stmt = $db_aus->query("SELECT id_solicitud, id_empleado, fecha_inicio, fecha_fin, dias_solicitados, estado FROM solicitudes WHERE estado = 'Pendiente'");
            $pendientes = $stmt->fetchAll();
            echo json_encode($pendientes);
        }
        break;

    case 'PUT':
      
        if (($action === 'aprobar' || $action === 'rechazar') && $id_solicitud) {
            $id_aprobador = $_GET['id_aprobador'] ?? 103; 
            $motivo = null;
            if ($action === 'rechazar') {
                $motivo = json_decode(file_get_contents('php://input'), true)['motivo_rechazo'] ?? 'Rechazo del jefe.';
            }
            procesarSolicitudCommand($action, (int)$id_solicitud, (int)$id_aprobador, $motivo);
        }
        break;

    default:
        http_response_code(405); echo json_encode(['error' => 'Método no permitido.']);
}