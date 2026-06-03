<?php
  include '../koneksi.php';
  $id = $_GET['id'];

  mysqli_query($conn, "DELETE FROM tabel_user WHERE id='$id'");

  header("location:data_user.php");
?>