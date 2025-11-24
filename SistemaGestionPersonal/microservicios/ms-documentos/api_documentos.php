<?php


header('Content-Type: application/json');
include_once '../../config/db_config.php'; 

$db_doc = getPdoConnection('hrm_documentos_nomina');
$action = $_GET['action'] ?? '';
$id_empleado = $_GET['id_empleado'] ?? null;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if ($action === 'cargar_documento' && $id_empleado) {
            $data = json_decode(file_get_contents('php://input'), true);

            $stmt = $db_doc->prepare("INSERT INTO expediente_digital (id_empleado, nombre_documento, fecha_registro) VALUES (?, ?, NOW())");
            $stmt->execute([
                $id_empleado,
                $data['nombre_documento'] ?? 'Documento sin nombre'
            ]);
            
            http_response_code(201); 
            echo json_encode(['message' => 'Documento registrado en el expediente.', 'id_empleado' => $id_empleado]);
        }
        break;
        
    case 'GET':
        if ($action === 'incidencias_diarias' && isset($_GET['fecha'])) {
            $fecha = $_GET['fecha'];
            $stmt = $db_doc->prepare("SELECT id_empleado, tipo_incidencia, descripcion FROM incidencias_nomina WHERE fecha = ?");
            $stmt->execute([$fecha]);
            $incidencias = $stmt->fetchAll();
            
            if (!empty($incidencias)) {
                echo json_encode($incidencias);
            } else {
                echo json_encode([
                    ['id_empleado' => 104, 'tipo_incidencia' => 'Permiso', 'descripcion' => 'Diana tiene permiso de 10-12 hoy.'],
                    ['id_empleado' => 106, 'tipo_incidencia' => 'Retardo', 'descripcion' => 'Marco llegó 15 minutos tarde.'],
                ]);
            }
            exit;
        }

        if ($action === 'reporte_ausentismo' && isset($_GET['id_departamento'])) {
            $id_depto = $_GET['id_departamento'];
            echo json_encode([
                'id_departamento' => $id_depto,
                'resumen_ausencias' => [
                    'mes' => $_GET['mes'] ?? date('Y-m'),
                    'total_dias_ausencia' => 12.5,
                    'empleados_afectados' => 5,
                    'alerta' => 'Alto ausentismo este mes.'
                ]
            ]);
            exit;
        }

        break;

    default:
        http_response_code(405); echo json_encode(['error' => 'Método no permitido.']);
}