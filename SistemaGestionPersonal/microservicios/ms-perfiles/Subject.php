<?php

include_once 'Observers/SaldoObserver.php'; 
include_once '../../config/db_config.php'; 

function altaEmpleadoSubject(array $data) {
    global $db_perfiles; 

    $id_departamento = $data['id_departamento'] ?? 3;

    $db_perfiles->beginTransaction();
    try {

        $stmt = $db_perfiles->prepare("INSERT INTO empleados (nombre, puesto, fecha_ingreso, id_jefe, id_departamento, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['nombre'],
            $data['puesto'],
            $data['fecha_ingreso'] ?? date('Y-m-d'),
            $data['id_jefe'] ?? NULL,
            $id_departamento,
            $data['email']
        ]);
        
        $id_nuevo = $db_perfiles->lastInsertId();
        $db_perfiles->commit();


        crearSaldoObserver($id_nuevo); 

        http_response_code(201); 
        echo json_encode(['message' => 'Empleado y saldo inicial creados exitosamente.', 'id_empleado' => $id_nuevo]);
        
    } catch (Exception $e) {
        $db_perfiles->rollBack();
        http_response_code(500); 
        echo json_encode(['error' => 'Error al dar de alta: ' . $e->getMessage()]);
    }
}