<?php
    require_once('fpdf.php');

    session_start();

    if(isset($_POST["imprimir"], $_POST["factura-id"])){
        $id = $_POST["factura-id"];

    }else{
        header("Location:user_panel.php");
    }

    /*
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(40, 10, 'Factura #' . $id . ' - Comprado por: ' . $_SESSION["username"]);
    $pdf->Cell(40, 10, 'Valor total: ' . $_SESSION["factura"]["importe_total"]);
    $pdf->output();
    */

    class PDF extends FPDF{
        // Cabecera de la página
        function Header(){
            // Como ha llegado aquí, se que $_POST["factura-id"] contiene un id válido
            $id = $_POST["factura-id"];
            // Logo
            $this->Image('img/bs-icon.png', 10,6,15);
            // Tamaño y características de la fuente
            $this->SetFont('Arial','B',15);
            // Se mueve 70 a la derecha para centrarlo
            $this->Cell(70);
            // Titulo
            $this->Cell(50,10,'Latiende Sita',1,0,'C');
            // Salto de línea
            $this->Ln(20);
            // Segundo título para dar mas información
            $this->SetFont('Arial','B',11);
            $this->Cell(40, 10, 'Factura #' . $id . ' - Comprado por: ' . $_SESSION["username"]);
            $this->Ln(10);
            // Importe total de los productos comprados
            $this->Cell(40, 10, 'Importe total: ' . $_SESSION["factura"]["importe_total"] . ' euros');
            $this->Ln(10);
            $this->Cell(40, 10, 'Fecha: ' . $_SESSION["factura"]["fecha"]);
            $this->Ln(10);
            $this->Cell(45,10, '#Referencia', 1, 0, 'C', 0);
            $this->Cell(35,10, 'Nombre', 1, 0, 'C', 0);
            $this->Cell(40,10, 'Precio final', 1, 0, 'C', 0);
            $this->Cell(35,10, 'Cantidad', 1, 0, 'C', 0);
            $this->Cell(35,10, 'Total', 1, 0, 'C', 0);
            $this->Ln(10);
        }

        // Page footer
        function Footer(){
            // Posicion
            $this->SetY(-15);
            // Fuente
            $this->SetFont('Arial','I',8);
            // Numeración
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

        // Instanciaciónd de PDF
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        // Vuelvo a decodificar $factura["carro"]
        $carro = json_decode($_SESSION["factura"]["carro"], true);
        foreach($carro as $key => $producto){
            $pdf->Cell(45,10, $producto['id'], 1, 0, 'C', 0);
            $pdf->Cell(35,10, $producto['nombre'], 1, 0, 'C', 0);
            $pdf->Cell(40,10, $producto['precioFinal'] . " euro", 1, 0, 'C', 0);
            $pdf->Cell(35,10, $producto['cantidad'], 1, 0, 'C', 0);
            $total = $producto['cantidad'] * $producto['precioFinal'];
            $pdf->Cell(35,10, $total . " euro", 1, 0, 'C', 0);
            $pdf->Ln(10);
        }
        $pdf->Output();

?>