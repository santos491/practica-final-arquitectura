<?php

include_once '../../config/db_config.php';

if (!function_exists('notificarPorCorreo')) {
    function notificarPorCorreo(int $id_empleado, string $estado, string $motivo = null) {
        // Ajuste de ruta para el MS-Perfiles
        $url_email = "../ms-perfiles/api_perfiles.php?action=email&id_empleado=$id_empleado";
        $response = @file_get_contents($url_email);
        $data = $response ? json_decode($response, true) : null;
        $email = $data['email'] ?? 'desconocido@empresa.com';

        error_log("NOTIFICACIÓN ASÍNCRONA A ($email): Tu solicitud ha sido $estado. Motivo: $motivo"); 
        return true;
    }
}


function rechazarCommand(PDO $db, array $solicitud, int $id_aprobador, string $motivo) {

    $stmt = $db->prepare("UPDATE solicitudes SET estado = 'Rechazada', motivo_rechazo = ?, id_aprobador = ? WHERE id_solicitud = ?");
    $stmt->execute([$motivo, $id_aprobador, $solicitud['id_solicitud']]);
    

    notificarPorCorreo($solicitud['id_empleado'], 'Rechazada', $motivo);
    
    return ['message' => 'Solicitud rechazada y aprobador registrado.'];
}