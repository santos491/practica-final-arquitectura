<?php

include_once '../../config/db_config.php';


function notificarPorCorreo(int $id_empleado, string $estado, string $motivo = null) {
    $url_email = "../ms-perfiles/api_perfiles.php?action=email&id_empleado=$id_empleado";
    $response = @file_get_contents($url_email);
    $data = $response ? json_decode($response, true) : null;
    $email = $data['email'] ?? 'desconocido@empresa.com';

    error_log("NOTIFICACIÓN ASÍNCRONA A ($email): Tu solicitud ha sido $estado. Motivo: $motivo"); 
    return true;
}

function aprobarCommand(PDO $db, array $solicitud, int $id_aprobador) {

    $stmt = $db->prepare("UPDATE saldos_vacaciones SET dias_disponibles = dias_disponibles - ? WHERE id_empleado = ? AND dias_disponibles >= ?");
    $stmt->execute([$solicitud['dias_solicitados'], $solicitud['id_empleado'], $solicitud['dias_solicitados']]);
    if ($stmt->rowCount() === 0) {
        throw new Exception("Saldo insuficiente o empleado no existe.");
    }
    
    $stmt = $db->prepare("UPDATE solicitudes SET estado = 'Aprobada', fecha_aprobacion = NOW(), id_aprobador = ? WHERE id_solicitud = ?");
    $stmt->execute([$id_aprobador, $solicitud['id_solicitud']]);
    

    notificarPorCorreo($solicitud['id_empleado'], 'Aprobada');
    
    return ['message' => 'Solicitud aprobada, días descontados y aprobador registrado.'];
}