<?php
session_start();
include '../all/connection.php';
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
      // Tambahkan kondisi WHERE role != 'admin' untuk mengecualikan data dengan role admin
      $banyak_admin = $conn->query("SELECT nis, nama, kelas, status, waktu FROM user WHERE role != 'admin' ORDER BY nis ASC");
      
      $i = 1;
      while($data = mysqli_fetch_array($banyak_admin)){
        $nis = $data['nis'];
        $nama = $data['nama'];
        $kelas = $data['kelas'];
        $status = $data['status'];
        $waktu = $data['waktu'];
      ?>
      <tr>
        <td><?=$i++;?></td>
        <td><?php echo $nis; ?></td>
        <td><?php echo $nama; ?></td>
        <td><?php echo $kelas; ?></td>
        <td><?php echo $status; ?></td>
        <td><?php echo $waktu; ?></td>
      </tr>
      <?php } ?>
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
