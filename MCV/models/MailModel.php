<?php
// File: MCV/models/MailModel.php

// 1. Nhúng file theo đúng thứ tự (Exception -> SMTP -> PHPMailer)
require_once __DIR__ . '/../core/PHPMailer/Exception.php';
require_once __DIR__ . '/../core/PHPMailer/SMTP.php';
require_once __DIR__ . '/../core/PHPMailer/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailModel
{
    public function sendOpt($email, $otp)
    {
        $mail = new PHPMailer(true);

        try {
            // Cấu hình Server
            $mail->isSMTP();                                      
            $mail->Host       = 'smtp.gmail.com';                 
            $mail->SMTPAuth   = true;                             
            $mail->Username   = 'lelinhuyen28@@gmail.com'; // <--- Thay Email của bạn
            $mail->Password   = 'rvth jadr wbte yfcj';       // <--- Thay Mật khẩu ứng dụng
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      
            $mail->Port       = 465;

            // Người gửi & Nhận
            $mail->setFrom('email_cua_ban@gmail.com', 'He Thong Trac Nghiem');
            $mail->addAddress($email);

            // Nội dung
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Mã OTP xác thực: ' . $otp;
            $mail->Body    = "<b>Mã OTP của bạn là: $otp</b>. Mã này hết hạn sau 5 phút.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Ghi log lỗi vào file php_error_log của xampp để kiểm tra nếu cần
            error_log("Mail Error: " . $mail->ErrorInfo);
            return false;
        }
    }
}