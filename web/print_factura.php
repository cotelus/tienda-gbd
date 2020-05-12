<?php
    require_once('fpdf.php');

    session_start();

    if(isset($_POST["imprimir"], $_POST["factura-id"])){
        $id = $_POST["factura-id"];
    }else{
        header("Location:user_panel.php");
    }

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(40, 10, 'Factura #' . $id . ' - Comprado por: ' . $_SESSION["username"]);
    $pdf->output();

?>