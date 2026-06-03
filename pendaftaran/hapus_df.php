<?php
  include '../koneksi.php';
  $id = $_GET['id'];

  mysqli_query($conn, "DELETE FROM tabel_pendaftar WHERE id='$id'");

  header("location:data_df.php");
?>