<?php include("inc_header.php")?>
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_SESSION['session_email']) != ''){ //sudah dalam keadaan login
    header("location:halaman.php");
    exit();
}

function url_dasar() {
    $url_dasar  = "http://localhost/belajar/public/admin";
    return $url_dasar;
}

function kirim_email($email_penerima,$nama_penerima,$judul_email,$isi_email){

    $email_pengirim     = "batcoljohn@gmail.com";
    $nama_pengirim      = "noreply";

    //Load Composer's autoloader
    require_once __DIR__ . '/vendor/autoload.php';

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $email_pengirim;                     //SMTP username
        $mail->Password   = 'pquv dxla pnwx xafp';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom($email_pengirim,$nama_pengirim);
        $mail->addAddress($email_penerima,$nama_penerima);     //Add a recipient
       

        

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $judul_email;
        $mail->Body    = $isi_email;
        

        $mail->send();
        return "sukses";
    } catch (Exception $e) {
        return "gagal: {$mail->ErrorInfo}";
    }
}

$dbServer = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName= 'belajar';
$conn = new PDO ("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
?>

<h3>Pendaftaran</h3>
<?php
$email = "";
$nama_depan = "";
$nama_belakang = "";
$err = "";
$sukses = "";

if (isset($_POST['simpan'])) {
    $email                  = $_POST['email'];
    $nama_depan             = $_POST['nama_depan'];
    $nama_belakang          = $_POST['nama_belakang'];
    $password               = $_POST['password'];
    $konfirmasi_password    = $_POST['konfirmasi_password'];

    if($email == '' or $nama_depan == '' or $nama_belakang == '' or $konfirmasi_password == '' or $password == ''){
        $err .= "<li> Silahkan masukkan semua isian</li>";
    }

    if($email != ''){
        $sql   = "SELECT email from user where email = '$email'";
        $q1 = $conn->query($sql);
        $n1 = $q1->rowCount();
        if($n1 > 0){
            $err .= "<li>Email yang kamu masukkan sudah terdaftar.</li>";
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $err .= "<li>Email yang kamu masukkan tidak valid.</li>";
        }
    }

    if ($password != $konfirmasi_password){
        $err .= "<li>Password dan Konfirmasi Password tidak sesuai.</li>";
    }
    if(strlen($password) < 6){
        $err .= "<li>Panjang karakter yang diizinkan untuk password paling tidak 6 karakter.</li>";
    }


    if(empty($err)){
        $status             = md5(rand(0,1000));
        $judul_email        = "Halaman Konfirmasi Pendaftaran";
        $isi_email          = "Akun yang kamu miliki dengan email <b>$email</b> telah siap digunakan.<br/>";
        $isi_email          .= "Sebelumnya silakan melakukan aktivasi email di link di bawah ini:<br/>";
        $isi_email          .= url_dasar()."/verifikasi.php?email=$email&kode=$status";

        kirim_email($email,$nama_depan,$judul_email,$isi_email);

        $sql        = "INSERT INTO user (email, nama_depan, nama_belakang, password, status) VALUES ('$email', '$nama_depan', '$nama_belakang', '" . md5($password) . "', '$status')";
        $q1         = $conn->query($sql);
        if($q1){
            $sukses = "Proses Berhasil. Silakan cek email kamu untuk verifikasi.";
        }
    }
}
?>

<?php if($err) {echo "<div class='error'><ul>$err</ul></div>";} ?>
<?php if($sukses) {echo "<div class='sukses'>$sukses</div>";} ?>

<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Email</td>
            <td>
                <input type="text" name="email" class="input" value="<?php echo $email?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Nama Depan</td>
            <td>
                <input type="text" name="nama_depan" class="input" value="<?php echo $nama_depan?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Nama Belakang</td>
            <td>
                <input type="text" name="nama_belakang" class="input" value="<?php echo $nama_belakang?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Password</td>
            <td>
                <input type="password" name="password" class="input" />
            </td>
        </tr>
        <tr>
            <td class="label">Konfirmasi Password</td>
            <td>
                <input type="password" name="konfirmasi_password" class="input" />
                <br/>
                Sudah punya akun? Silakan <a href='login.php'>login</a>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="simpan" value="simpan" class="tbl-biru"/>
            </td>
        </tr>
    </table>
</form>
<?php include("inc_footer.php")?>