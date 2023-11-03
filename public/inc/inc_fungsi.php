<?php

function url_dasar() {
    $url_dasar  = "http://localhost/belajar/public/admin";
    return $url_dasar;
}


// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// function kirim_email($email_penerima, $nama_penerima,$judul_email,$isi_email){
    
//     $email_pengirim     = "batcoljohn@gmail.com";
//     $nama_pengirim      = "noreply";

//     //Load Composer's autoloader
//     require getcwd().'/vendor/autoload.php';

//     //Instantiation and passing `true` enables exceptions
//     $mail = new PHPMailer(true);

//     try {
//         //Server settings
//         $mail->SMTPDebug = 0;                      //Enable verbose debug output
//         $mail->isSMTP();                                            //Send using SMTP
//         $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
//         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//         $mail->Username   = $email_pengirim;                     //SMTP username
//         $mail->Password   = 'gojek123';                               //SMTP password
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
//         $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//         //Recipients
//         $mail->setFrom($email_pengirim, $nama_pengirim);
//         $mail->addAddress($email_penerima,$nama_penerima);     //Add a recipient
       

        

//         //Content
//         $mail->isHTML(true);                                  //Set email format to HTML
//         $mail->Subject = $judul_email;
//         $mail->Body    = $isi_email;
        

//         $mail->send();
//         return "sukses";
//     } catch (Exception $e) {
//         return "gagal: {$mail->ErrorInfo}";
//     }
// }