<?php
define('FPDF_FONTPATH', '../fpdf/font/');
require('../fpdf/fpdf.php');
include '../all/connection.php';

// Ambil data dari form
$kelas = $_POST['kelas'] ?? '';
$date = $_POST['date'] ?? '';

// Periksa apakah kelas dan tanggal diisi
if (empty($kelas) || empty($date)) {
    die("Kelas dan tanggal harus dipilih.");
}

// Query untuk mengambil data absensi
$query = "SELECT history.nis AS nis, user.nama AS nama, user.kelas AS kelas, history.status AS status, history.waktu AS waktu, history.surat AS surat
          FROM history 
          JOIN user ON history.nis = user.nis 
          WHERE user.kelas = ? AND DATE(history.waktu) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $kelas, $date);
$stmt->execute();
$result = $stmt->get_result();

// Inisialisasi PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header
$pdf->Cell(0, 10, 'Data Absensi SMKN 71 Jakarta', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Kelas: ' . $kelas . ' | Tanggal: ' . $date, 0, 1, 'C');
$pdf->Ln(10);

// Header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'NIS', 1);
$pdf->Cell(50, 10, 'Nama', 1);
$pdf->Cell(30, 10, 'Kelas', 1);
$pdf->Cell(30, 10, 'Status', 1);
$pdf->Cell(50, 10, 'Waktu', 1);
$pdf->Ln();

// Data tabel
$pdf->SetFont('Arial', '', 12);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(30, 10, $row['nis'], 1);
    $pdf->Cell(50, 10, $row['nama'], 1);
    $pdf->Cell(30, 10, $row['kelas'], 1);
    $pdf->Cell(30, 10, $row['status'], 1);
    $pdf->Cell(50, 10, $row['waktu'], 1);
    $pdf->Ln();

    // If there's a 'surat' image to display
    if (!empty($row['surat']) && file_exists('../uploads/' . $row['surat'])) {
        // Path to the image
        $imagePath = '../uploads/' . $row['surat'];

        // Resize the image to fit the page (example: 40mm x 40mm)
        $pdf->Image($imagePath, $pdf->GetX(), $pdf->GetY(), 40, 40);
        $pdf->Ln(40); // Move to the next line after the image
    }
}

// Tutup koneksi
$stmt->close();
$conn->close();

// Output PDF
$pdf->Output('I', 'Data_Absensi_' . $kelas . '_' . $date . '.pdf');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Presensi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Riwayat Presensi</h2>

    <table class="table table-striped table-bordered" id="mauexport">
        <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Status</th>
            <th>Waktu</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($result) && $result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$i}</td>
                        <td>" . htmlspecialchars($row['nis']) . "</td>
                        <td>" . htmlspecialchars($row['nama']) . "</td>
                        <td>" . htmlspecialchars($row['kelas']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['waktu']) . "</td>
                      </tr>";
                $i++;
            }
        } else {
            echo '<tr><td colspan="6">No data available for the selected class and date.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#mauexport').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

</body>
</html>
