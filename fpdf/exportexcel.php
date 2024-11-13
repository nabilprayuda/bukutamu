<?php
//koneksi ke database
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dbbukutamu');
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Check connection

//Memanggil file FPDF dari file yang anda download tadi
require('fpdf.php');

$pdf = new FPDF("L", "cm", "A4");

$pdf->SetMargins(2, 1, 1);
$pdf->AliasNbPages();
$pdf->AddPage();
//Image( file name , x position , y position , width [optional] , height [optional] )
$pdf->Image('image1.png', 3.2, 0.7, 2.6, 2.6);
$pdf->SetFont('Times', 'B', 11);
$pdf->ln(1);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(25.5, 0.7, "Laporan Rekapitulasi Pengunjung", 0, 10, 'C');
$pdf->Cell(25.5, 0.7, "SMK Telekomunikasi Telesandi Bekasi", 0, 10, 'C');
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(25.5, 0.7, "____________________________________________________________________", 0, 10, 'C');
$pdf->ln(1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->ln(1);
$pdf->SetFont('Arial', 'B', 10);
//Tidak berpengaruh dengan database hanya sebagai keterangan pada tabel nantinya
$pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(2.5, 0.8, 'Tanggal', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Nama', 1, 0, 'C');
$pdf->Cell(4.5, 0.8, 'Alamat', 1, 0, 'C');
$pdf->Cell(5.9, 0.8, 'Keperluan', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Pihak Dituju', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'No.HP', 1, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$no = 1;
//Panggil tblcomplaints dari database
$tgl1 = $_POST['tanggala'];
$tgl2 = $_POST['tanggalb'];

$query = mysqli_query($con, "SELECT * FROM ttamu WHERE tanggal BETWEEN '$tgl1' and '$tgl2' order by tanggal asc");
$no = 1;

while ($lihat = mysqli_fetch_array($query)) {

    //Queri tabel yang ingin ditampilkan
    $pdf->Cell(1, 0.8, $no, 1, 0, 'C');
    $pdf->Cell(2.5, 0.8, $lihat['tanggal'], 1, 0, 'C');
    $pdf->Cell(5, 0.8, $lihat['nama'], 1, 0, 'C');
    $pdf->Cell(4.5, 0.8, $lihat['alamat'], 1, 0, 'C');
    $pdf->Cell(5.9, 0.8, $lihat['keperluan'], 1, 0, 'C');
    $pdf->Cell(4, 0.8, $lihat['pihak'], 1, 0, 'C');
    $pdf->Cell(3, 0.8, $lihat['nope'], 1, 1, 'C');
    $no++;
}
$pdf->ln(1);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40.5, 0.7, "Bekasi, " . date("d/m/Y"), 0, 10, 'C');
$pdf->Cell(40.5, 0.7, "Guru Piket", 0, 10, 'C');

$pdf->ln(1);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40.5, 0.7, "", 0, 10, 'C');
$pdf->Cell(40.5, 0.7, "Diah Ashari", 0, 10, 'C');
//Nama file ketika di print
$pdf->Output("laporan_bukutamu.pdf", "I");
