<?php include("inc_header.php")?>
<?php
session_start();

// Konfigurasi database
$dbServer = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName= 'belajar';
$conn = new PDO ("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
//variabel
$err = "";
$email = "";

// Fungsi login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == '' or $password == '') {
        $err .= "<li>Silahkan Masukkan email dan juga Password.</li>";
    }else{
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $q1 = $conn->query($sql);
        $r1 = $q1->fetch(PDO::FETCH_ASSOC);
        $n1 = $q1->rowCount();

        if($r1['status'] != '1' && $n1 > 0){
            $err .= "<li>Akun yang kamu miliki belum aktif, silahkan verifikasi melalui email yang telah kami kirimkan</li>";
        }

        if (empty($r1)) {
            $err .= "<li> Email <b>$email</b> tidak tersedia.</li>";
        } elseif ($r1['password'] !== md5($password)) {
            $err .= "<li>Password yang dimasukkan tidak sesuai.</li>";
        }

        if($n1 < 1){
            $err .= "<li>Akun tidak ditemukan</li>";
        }
    
        if (empty($err)) {
            $_SESSION['session_email'] = $email;
            $_SESSION['session_password'] = md5($password);

            header("location:home.php");     
            exit();
        }
    }
}

?>
<?php if($err){ echo "<div class='error'><ul class='pesan'>$err</ul></div>";}?>
<h3>Login</h3>
<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Email</td>
            <td><input type="text" name="email" class="input" value="<?php echo $email?>"/></td>
        </tr>
        <tr>
            <td class="label">Password</td>
            <td><input type="password" name="password" class="input" /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="login" value="Login" class="tbl-biru"/></td>
        </tr>
    </table>
</form>
<p>Belum punya akun ? silahkan <a href="register.php">daftar terlebih dahulu</a>.</p>
<?php include("inc_footer.php")?>