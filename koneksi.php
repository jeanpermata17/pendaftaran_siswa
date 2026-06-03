<?php
$conn = mysqli_connect("localhost", "root", "", "pendaftaran_siswa");
 if (!$conn) {
    die("koneksi gagal: " . mysqli_connect_error());
 }
 ?>