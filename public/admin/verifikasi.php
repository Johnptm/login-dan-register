<?php include("inc_header.php")?>
<?php 
$err     = "";
$sukses  = "";

if(!isset($_GET['email']) or !isset($_GET['kode'])){
    $err    = "Data yang diperlukan untuk verifikasi tidak tersedia.";
}else{
    $email  = $_GET['email'];
    $kode   = $_GET['kode'];

    $sql   = "SELECT * from user where email = '$email'";
    $q1 = $conn->query($sql);
    $r1 = $q1->fetch(PDO::FETCH_ASSOC);
    if($r1['status'] == $kode){
        $sql1   = "UPDATE user set status = '1' where email = '$email'";
        $q1 = $conn->query($sql1);
        $sukses = "Akun telah aktif. Silakan login di halaman login.";
    }else{
        $err = "Kode tidak valid";
    }
}
?>
<h3>Halaman Verifikasi</h3>
<?php if($err) { echo "<div class='error'>$err</div>";}?>
<?php if($sukses) { echo "<div class='sukses'>$sukses</div>";}?>
<?php include("inc_footer.php")?>