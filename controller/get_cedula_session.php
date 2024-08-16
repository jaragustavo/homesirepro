<?php
session_start();

header('Content-Type: application/json');

// Verifica si la cédula está establecida en la sesión
if (isset($_SESSION['cedula'])) {
    echo json_encode(['cedula' => $_SESSION['cedula']]);
} else {
    echo json_encode(['error' => 'Cédula no encontrada en la sesión']);
}
?>