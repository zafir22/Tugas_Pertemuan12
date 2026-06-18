<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (isset($_POST['daftar'])) {

    $nama = htmlspecialchars($_POST['nama']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (empty($nama) || empty($email)) {
        echo "Data tidak boleh kosong";
        exit;
    }



$mail = new PHPMailer(true);

try {

    $mail->SMTPDebug = 2;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'zafirmahendra1@gmail.com';
    $mail->Password = 'fnpj buau atmh huym';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('zafirmahendra1@gmail.com', 'panitia pendaftaran');
    $mail->addAddress($email, $nama);

    $mail->isHTML(true);
    $mail->Subject = 'Konfirmasi Pendaftaran sukses';

    $mail->Body    = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                <div style='background: #007bff; padding: 20px; color: white; text-align: center; border-radius: 5px 5px 0 0;'>
                    <h2>Halo, $nama!</h2>
                </div>
                <div style='padding: 20px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 5px 5px;'>
                    <p>Terima kasih telah melakukan pendaftaran di platform kami.</p>
                    <p>Pendaftaran Anda telah kami terima dan saat ini sedang dalam proses verifikasi oleh tim kami.</p>
                    <br>
                    <p>Salam hangat,<br><strong>Tim Panitia</strong></p>
                </div>
            </div>
        ";

    $mail->AltBody = "Halo $nama, terima kasih telah mendaftar. Pendaftaran Anda sukses dikonfirmasi.";

        // Kirim Email
        $mail->send();
        echo "<script>
                alert('Pendaftaran berhasil! Email konfirmasi telah dikirim ke $email');
                window.location.href = 'index.php';
              </script>";

} catch (Exception $e) {
        echo "Gagal mengirim email. Error: {$mail->ErrorInfo}";
    }
} else {
    // Jika diakses langsung tanpa POST
    header("Location: index.php");
    exit;
}
?>