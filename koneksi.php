<?php
$conn = mysqli_connect("localhost", "root", "", "portofolio_riwu");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
