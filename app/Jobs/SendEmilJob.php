<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class SendEmilJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sendMail;
    public $otp;

    /**
     * Create a new job instance.
     */
    public function __construct($sendMail,$otp)
    {
        $this->sendMail = $sendMail;
        $this->otp = $otp;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      $email =  new OtpMail($this->otp);
      Mail::to($this->sendMail)->send($email);


    }
}
