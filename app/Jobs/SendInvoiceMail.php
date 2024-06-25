<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use\Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

class SendInvoiceMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $earning;
    public $user;

    public function __construct($earning,$user)
    {
        $this->earning=$earning;
        $this->user=$user;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send(new InvoiceMail($this->earning,$this->user));//emailの列を自動的に探してくれる
    }
}
