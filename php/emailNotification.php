<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function sendTruckNotification($email, $carrier, $truckNumber, $protocolFile) {
    $mail = new PHPMailer(true);
    try {
        $mail->setFrom('admin@example.com', 'Warehouse Admin');
        $mail->addAddress($email);
        $mail->Subject = 'Truck Arrival Notification';
        $mail->Body = "Dear Driver,\n\nYour truck ($carrier - $truckNumber) has been registered for unloading.\n\nBest Regards,\nWarehouse Team";
        $mail->addAttachment($protocolFile);
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
