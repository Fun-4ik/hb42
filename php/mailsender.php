<?

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function send_mail_code(array $mail_setup, string $to, string $code){

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = $mail_setup['SMTPDebug'];                      
        $mail->isSMTP();                                            
        $mail->Host = $mail_setup['Host'];                     
        $mail->SMTPAuth = $mail_setup['SMTPAuth'];                                   
        $mail->Username = $mail_setup['Username'];                    
        $mail->Password = $mail_setup['Password'];                            
        $mail->SMTPSecure = $mail_setup['SMTPSecure'];            
        $mail->Port = $mail_setup['Port'];                   
        $mail->CharSet = $mail_setup['CharSet'];

        //Recipients
        $mail->setFrom('danil.protasov.95@gmail.com', 'ХозБлог42');
        $mail->addAddress($to);

        $mail->Subject = 'Регистрации на сайте ХозБлог42';
        $mail->Body = 'Код для регистрации: ' . $code;

        $mail->send();
        echo 'Письмо доставлено';
    } catch (Exception $e) {
        echo "Письмо не доставлено. Ошибка отправщика: {$mail->ErrorInfo}";
    }

}

function send_mail_urlcode(array $mail_setup, string $to, string $code){

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];

    $base_url = $protocol . $host;

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = $mail_setup['SMTPDebug'];                      
        $mail->isSMTP();                                            
        $mail->Host = $mail_setup['Host'];                     
        $mail->SMTPAuth = $mail_setup['SMTPAuth'];                                   
        $mail->Username = $mail_setup['Username'];                    
        $mail->Password = $mail_setup['Password'];                            
        $mail->SMTPSecure = $mail_setup['SMTPSecure'];            
        $mail->Port = $mail_setup['Port'];                   
        $mail->CharSet = $mail_setup['CharSet'];

        //Recipients
        $mail->setFrom('danil.protasov.95@gmail.com', 'ХозБлог42');
        $mail->addAddress($to);

        $mail->Subject = 'Регистрации на сайте ХозБлог42';
        $mail->Body = 'Ваша заявка одобрена. Ваша ссылка для регистрации: ' . $base_url . "/registration/verify.php?email=" . urlencode($to) . "&code=" . urlencode($code);

        $mail->send();
        echo 'Письмо доставлено';
    } catch (Exception $e) {
        echo "Письмо не доставлено. Ошибка отправщика: {$mail->ErrorInfo}";
    }

}



?>