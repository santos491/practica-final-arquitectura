<?php
// microservicios/ms-perfiles/Observers/SaldoObserver.php
include_once '../../config/db_config.php'; // Ajuste de ruta

/**
 * Observer: Crea el saldo inicial en la BD del MS-Ausencias.
 */
function crearSaldoObserver(int $id_empleado): void {
    try {
        $db_aus = getPdoConnection('hrm_ausencias_vacaciones');
        // El nuevo empleado inicia con 10 días disponibles.
        $stmt_saldo = $db_aus->prepare("INSERT INTO saldos_vacaciones (id_empleado, dias_disponibles, acumulado_periodo) VALUES (?, 10.0, 0.0)");
        $stmt_saldo->execute([$id_empleado]);
    } catch (Exception $e) {
        // Loguear error, pero no detener el proceso principal de alta de empleado.
        error_log("OBSERVER ERROR: No se pudo crear el saldo de vacaciones para el empleado $id_empleado: " . $e->getMessage());
    }
}