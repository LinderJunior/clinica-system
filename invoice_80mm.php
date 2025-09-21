<?php
//call the FPDF library
require('fpdf/fpdf.php');
include_once __DIR__ . '/src/services/AuthService.php';


$id=$_GET['id'];

$select=$pdo->prepare("select * from tbl_invoice JOIN tbl_cliente on tbl_invoice.nome_cliente = tbl_cliente.clienteid where invoice_id=$id");

$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

//create pdf object
$pdf = new FPDF('P','mm',array(80,200));

//add new page
$pdf->AddPage();

//set font to arial, bold, 16pt
$pdf->SetFont('Arial','B',16);
//Cell(width , height , text , border , end line , [align] )
$pdf->Cell(60,8,'',0,1,);
$pdf->Image('agro-racibo1.jpeg', 30, 1, 20, 0, 'JPEG'); // Altere o caminho e as dimensões conforme necessári


$pdf->SetFont('Arial','B',8);

$pdf->Cell(60,5,'Endereco: Av. Eduardo Mondlane, Quelimane',0,1,'');
$pdf->Cell(60,5,'E-mail:farmaciamunhife@gmail.com',0,1,'');
$pdf->Cell(60,5,'Cel:+258 84 763 8794/ +258 86 476 3879',0,1,'');
$pdf->Cell(60,5,'NUIT: 401233172',0,1,'');


$pdf->Line(7,38,72,38);


$pdf->Ln(1); // line 

//////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,4,'Funcionario :',0,0,'');


$pdf->SetFont('Courier','B',8);
$pdf->Cell(40,4,$row->customer_name,0,1,'');

//////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,4,'ID venda :',0,0,'');


$pdf->SetFont('Courier','B',8);
$pdf->Cell(40,4,$row->invoice_id,0,1,'');

//////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,4,'Cliente :',0,0,'');


$pdf->SetFont('Courier','B',8);
$pdf->Cell(40,4,$row->nome,0,1,'');

//////////////////////////////////////////////////////

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,4,'Data :',0,0,'');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(40,4,$row->order_date,0,1,'');



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$pdf->SetX(2);
$pdf->SetFont('Courier','B',8);

$pdf->Cell(36,5,'PRODUTO',1,0,'C');   //70
$pdf->Cell(11,5,'QTD',1,0,'C');
$pdf->Cell(8,5,'PRC',1,0,'C');
$pdf->Cell(8,5,'IVA',1,0,'C');
$pdf->Cell(12,5,'TOTAL',1,1,'C');



//$select=$pdo->prepare("select * from tbl_invoice_details where invoice_id=$id");

$select=$pdo->prepare("select tbl_invoice_details.product_name, tbl_invoice_details.tax, tbl_invoice_details.qty, tbl_invoice_details.price, tbl_invoice.total FROM tbl_invoice_details JOIN tbl_invoice ON tbl_invoice_details.invoice_id = tbl_invoice.invoice_id where tbl_invoice_details.invoice_id=$id");

//$select=$pdo->prepare("select * FROM tbl_invoice_details JOIN tbl_invoice ON tbl_invoice_details.invoice_id = tbl_invoice.invoice_id where tbl_invoice_details.invoice_id=$id");


$select->execute();

while($item=$select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetX(2);
  $pdf->SetFont('Helvetica','B',8);
$pdf->Cell(36,5,$item->product_name,1,0,'L');   
$pdf->Cell(11,5,$item->qty,1,0,'C');
$pdf->Cell(8,5,$item->price,1,0,'C');  
$pdf->Cell(8,5,$item->tax,1,0,'C'); 
$pdf->Cell(12, 5,$item->total,1,1,'C');

    
}




///////




$pdf->SetX(10);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(27,5,'SUBTOTAL',1,0,'C');
$pdf->Cell(20,5,$row->subtotal,1,1,'C');


$pdf->SetX(10);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(27,5,'IVA(16%)',1,0,'C');
$pdf->Cell(20,5,$row->tax,1,1,'C');

$pdf->SetX(10);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(27,5,'DESCONTO',1,0,'C');
$pdf->Cell(20,5,$row->discount,1,1,'C');


$pdf->SetX(10);
$pdf->SetFont('courier','B',10);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(27,5,'TOTAL',1,0,'C');
$pdf->Cell(20,5,$row->total,1,1,'C');


$pdf->SetX(10);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(27,5,'VALOR PAGO',1,0,'C');
$pdf->Cell(20,5,$row->paid,1,1,'C');

// $pdf->SetX(7);
// $pdf->SetFont('courier','B',8);
// $pdf->Cell(20,5,'',0,0,'L');   //190
// //$pdf->Cell(20,5,'',0,0,'C');
// $pdf->Cell(27,5,'TROCO',1,0,'C');
// $pdf->Cell(20,5,$row->due,1,1,'C');

$pdf->SetX(10);
$pdf->SetFont('courier', 'B', 8);
$pdf->Cell(20, 5, '', 0, 0, 'L');
$pdf->Cell(27, 5, $row->payment_type == 'CREDIT' ? 'AMORTIZACAO' : 'TROCO', 1, 0, 'C');
$pdf->Cell(20, 5, $row->due, 1, 1, 'C');


$pdf->SetX(10);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(27,5,'TIPO PAGAMENTO',1,0,'C');
$pdf->Cell(20,5,$row->payment_type,1,1,'C');



$pdf->Cell(20,5,'',0,1,'');

$pdf->SetX(10);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(25,5,'Nota Importante :',0,1,'');

$pdf->SetX(10);
$pdf->SetFont('Arial','',5);
$pdf->Cell(75,5,'Este recibo e utilizado apenas para confirmacao da venda do produto. ',0,2,'');

$pdf->SetX(10);
$pdf->SetFont('Arial','',5);
$pdf->Cell(75,5,'Os demais procedimentos administrativos entre em contacto. ',0,1,'');




$pdf->Output();
?>