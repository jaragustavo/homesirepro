<?php
$color = "";
$avance= 0;
switch ($row["estado_actual"]) {
    case "PENDIENTE ASIGNACION":
        $avance = 0;
        break;
    case "CON OBSERVACIONES":
        $avance = 0;
        break;
    case "PENDIENTE ENVIO":
        $avance = 0;
        break;
    case "ASIGNADO":
        $avance = 10;
        $color = "-danger";
        break;
    case "OBS. CORREGIDAS":
        $avance = 15;
        $color = "-danger";
        break;
    case "CON CITA AGENDADA":
        $avance = 30;
        $color = "-warning";
        break;
    case "PENDIENTE DE PAGO":
        $avance = 40;
        $color = "-warning";
        break;
    case "PENDIENTE DE FIRMA":
        $avance = 60;
        $color = "-warning";
        break;
    case "EN VERIFICACION FINAL":
        $avance = 80;
        $color = "";
        break;
    case "PARA ENTREGA":
        $avance = 90;
        $color = "-success";
        break;
    case "DOCUMENTO ENTREGADO":
        $avance = 100;
        $color = "-success";
        break;
}
?>