<?php

include_once 'Commands/AprobarCommand.php';
include_once 'Commands/RechazarCommand.php';
include_once '../../config/db_config.php'; 

function procesarSolicitudCommand(string $comando, int $id_solicitud, int $id_aprobador, string $motivo_rechazo = null) {
    $db_aus = getPdoConnection('hrm_ausencias_vacaciones');

    $db_aus->beginTransaction();
    try {
        $stmt = $db_aus->prepare("SELECT id_empleado, dias_solicitados, id_solicitud FROM solicitudes WHERE id_solicitud = ? AND estado = 'Pendiente'");
        $stmt->execute([$id_solicitud]);
        $solicitud = $stmt->fetch();
        
        if (!$solicitud) {
            throw new Exception("Solicitud no encontrada o ya procesada.");
        }

        $resultado = [];
        if ($comando === 'aprobar') {
            $resultado = aprobarCommand($db_aus, $solicitud, $id_aprobador);
        } elseif ($comando === 'rechazar') {
            $resultado = rechazarCommand($db_aus, $solicitud, $id_aprobador, $motivo_rechazo);
        } else {
            throw new Exception("Comando no válido.");
        }

        $db_aus->commit();
        http_response_code(200); 
        echo json_encode($resultado);

    } catch (Exception $e) {
        $db_aus->rollBack();
        http_response_code(500); 
        echo json_encode(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
    }
}