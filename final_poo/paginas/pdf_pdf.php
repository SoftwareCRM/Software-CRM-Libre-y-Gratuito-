<?php session_start();

    require_once('/xampp/htdocs/final_poo/plantillas/bd.php');
    require_once('/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php');
    require_once('/xampp/htdocs/final_poo/insertar/insertar_pdf.php');
    require_once("/xampp/htdocs/final_poo/insertar/insertar_producto.php");

    require('../fpdf/fpdf.php');



    date_default_timezone_set('America/Caracas');
    class PDF extends FPDF 
    {

    function Header() 
    {   

        $id_fac = $_GET['id_fac']; //Identificar de la factura
        $tit = $_GET['tit']; //Titulo de la factura
        $ide_pdf = $_GET['ide_pdf']; //Identificar del RIF de la empresa
        $dir_pdf = $_GET['dir_pdf']; //Direccion de la empresa
        $num_pdf = $_GET['num_pdf']; //Número de telefono de la empresa
        $nom_cliente = $_GET['nom_cliente']; //Nombre del cliente
        $fecha = $_GET['fecha']; //Fecha a la hora de la realización de la compra
        $nom_usu = $_GET['nom_usu']; //Fecha a la hora de la realización de la compra



        // SENIAT
        $this->SetFont('Arial','B',5);   
        $this->setY(2);
        $this->Cell(0, 0, utf8_decode('SENIAT'),0,true,'C');
        $this->Ln(3);

        // NOMBRE DE LA EMPRESA
        $this->SetFont('times', 'B', 10);
        $this->MultiCell(62,4,utf8_decode($tit),0,'C');
        $this->Ln(2);

        $this->SetFont('Times','B',7);   
        $this->Cell(0, 3, utf8_decode('RIF: J-'.$ide_pdf),0,true,'C');
        $this->SetFont('Times','',7);   
        $this->MultiCell(62,3, utf8_decode($dir_pdf),0,'C');
        $this->Cell(0,3, utf8_decode($num_pdf),0,true,'C');
        $this->MultiCell(62,3, utf8_decode('CLIENTE: '.$nom_cliente),0,'L');
        $this->MultiCell(62,3, utf8_decode('OPERADOR: '.$nom_usu),0,'L');

        $this->SetFont('Times','B',7);   
        $this->Cell(0,6, utf8_decode('FACTURA '),0,true,'C');

        $this->SetFont('Times','',7);   
        $this->Cell(0,3, utf8_decode('FACTURA N°: '),0,true,'L');
        $this->Cell(0,-3, utf8_decode($id_fac),0,true,'R');

        $this->Cell(0,10, utf8_decode('FECHA DE COMPRA: '),0,true,'L');
        $this->Cell(0,-10, utf8_decode($fecha),0,true,'R');
        $this->Cell(0,18, utf8_decode("- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -"),0,true,'C');
    }

    function Footer(){
        $pie_pdf = $_GET['pie_pdf']; //Pie de página de la factura

        $this->SetFont('times', 'B', 7);
        $this->SetY(-10);
        $this->MultiCell(70,2,utf8_decode($pie_pdf),0,'C');            
        }
    }




    //$objProducto = new Productos();
    //$iva_ = $objProducto->IVAProductos(); 

    $pdf = new PDF('P','mm',array(80,150));
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->SetTopMargin(15);
    $pdf->SetLeftMargin(5);
    $pdf->SetRightMargin(5);

    $id_compra = $_GET['id_com'];
    $id_com = $_GET['id_com']; //Identificar de las compras realizadas
    $fecha = $_GET['fecha']; //Fecha a la hora de la realización de la compra
    $monto = $_GET['monto']; //Total o monto total de las compras hechas
    $id_prod = $_GET['id_prod']; //Identificador de los productos
    $id_usu = $_GET['id_usu'];
    $iva_ = $_GET['iva'];


    $objLista = new PDF_insertar; // POO
    $ListaCompras = $objLista->ProductosLista(); 

    $pdf->setY(45);$pdf->Ln(1);
    // En esta parte estan los encabezados
        $pdf->SetFont('times','B',8);
        $pdf->Cell(0,0, "\n",0,true,'L');
        //$pdf->Cell(20, 7, utf8_decode('Código'),1,0,'C',0);
        $pdf->Cell(0, 0, utf8_decode('PRODUCTO'),0,true,'L');
        $pdf->Cell(0, 0, utf8_decode('A COMPRAR'),0,true,'C');
        //$pdf->Cell(25, 7, utf8_decode('Precio'),1,0,'C',0);
        $pdf->Cell(0, 0, utf8_decode('TOTAL'),0,true,'R');

        $pdf->Ln(3);
    

    $pdf->SetFont('Times','',8);   
    //Aqui inicia el for con todos los productos

    $exento = 0; // VALOR DE LOS PRODUCTOS SIN IVA
    $iva = 0; // VALOR DE LOS PRODUCTOS CON IVA
    $iva_total = 0;
    $total = 0; // TOTAL DE LOS PRODUCTOS DEL PRECIO
    $suma_cuenta = 0;

    foreach ($ListaCompras as $e){ 

        if ($e['iva_prod'] == $iva_){
            //$e['nom_prod']." (E) ";
            $pdf->MultiCell(25, 4, utf8_decode($e['nom_prod']." (G) "),0,'L'); // CON IVA
            $iva = $iva+=$e['cantidad_vender_carr']*$e['pre_prod'];
        } else {
            $pdf->MultiCell(25, 4, utf8_decode($e['nom_prod']." (E) "),0,'L'); // SIN IVA
            $exento = $exento+=$e['cantidad_vender_carr']*$e['(Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod'];
        }
    
        $pdf->Cell(0, -4, utf8_decode($e['cantidad_vender_carr']." X ".number_format($e['pre_prod'],2, ".", "")),0,0,'C',0);
        $pdf->Cell(0, -4, '$'.utf8_decode(number_format($e['cantidad_vender_carr']*$e['pre_prod'],2,".","")),0,1,'R',0);

        $iva_total = ($iva * $iva_)/100;
        $total = $iva_total + $exento + $iva;
        $suma_cuenta = $iva + $exento;
        $pdf->Ln(5);


    } 

    //// Apartir de aqui esta la tabla con los subtotales y totales
    

    $pdf->Ln(1);

            $pdf->SetFont('times','',7);
            $pdf->Cell(0,3, utf8_decode('- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -'),0,true,'C');
            //EXENTO DE LOS PRODUCTOS DEL IVA
            $pdf->Cell(1,5,'EXENTO: ',0,0,'L',0);
            $pdf->Cell(0,5,'$'.number_format($exento,2,".",""),0,1,'C',0);
            //PORCENTAJE DE LOS PRODUCTOS QUE SI TIENEN IVA
            $pdf->Cell(2, 4, 'IVA: '.$iva_."%",0,0,'L',0);
            $pdf->Cell(0, 4, '$'.number_format($iva,2,".","")." X ".$iva_."%",0,0,'C',0);
            $pdf->Cell(0, 4, '$'.number_format($iva_total,2,".",""),0,1,'R',0);
            $pdf->SetFont('times','',7);
            $pdf->Cell(0,3, utf8_decode('- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -'),0,true,'C');
            //EXENTO DE LOS PRODUCTOS DEL IVA
            $pdf->Cell(1,5,'SUBTOTAL: ',0,0,'L',0);
            $pdf->Cell(0, 5, '$'.number_format($iva_total,2,".",""),0,0,'C',0);
            $pdf->Cell(0,5,'$'.number_format($suma_cuenta,2,".",""),0,1,'R',0);
            //PORCENTAJE DE LOS PRODUCTOS QUE SI TIENEN IVA

            //TOTAL DE LA VENTA
            $pdf->SetFont('times','B',7);
            $pdf->Cell(0,3, utf8_decode('- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -'),0,true,'C');
            $pdf->Cell(0,5,'TOTAL',0,true,'L');

            if (number_format($monto,2,".","") == number_format($total,2,".","")){
                $pdf->SetFont('times','B',8);
                $pdf->Cell(0,-5,'$'.number_format($total,2,".",""),0,true,'R');
            } else {
                $pdf->Cell(0,30,('El IVA ha sido cambiado anteriormente, '),0,true,'C');
                $pdf->Cell(0,-25,('por ello los datos mostrados no son los correspondientes.'),0,true,'C');
                $pdf->SetFont('times','B',8);
                $pdf->Cell(0,-15,'$'.number_format($total,2,".",""),0,true,'R');    
            }




     /*       $pdf->Cell(0, 0, utf8_decode('PRODUCTO'),0,true,'L');
            $pdf->Cell(0, 0, utf8_decode('A COMPRAR'),0,true,'C');
            //$pdf->Cell(25, 7, utf8_decode('Precio'),1,0,'C',0);
            $pdf->Cell(0, 0, utf8_decode('TOTAL'),0,true,'R');*/

    
    $pdf->Output();
?>