<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPasswordOtp extends Mailable
{
    use Queueable, SerializesModels;
    public $otp;
    public function __construct($otp)
    {
        $this->otp = $otp;
    }
    public function build()
    {
        return $this->subject('Mã OTP đổi mật khẩu')->view('emails.password_otp');
    }
}
