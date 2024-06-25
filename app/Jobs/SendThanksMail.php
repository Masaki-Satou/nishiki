<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use\Illuminate\Support\Facades\Mail;
use\App\Mail\ThanksMail;
use\App\Mail\OrderedMail;

class SendThanksMail implements ShouldQueue
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
        //userの中のemailカラムを自動的に探してくれる
        Mail::to($this->user)->send(new ThanksMail($this->earning,$this->user));//emailの列を自動的に探してくれる
        
        if(app()->isLocal()){
            Mail::to('kyoutanba.yakipon@gmail.com')->send(new OrderedMail($this->earning,$this->user));//emailの列を自動的に探してくれる
        }else{
            Mail::to('info@tanba-nouhan.com')->send(new OrderedMail($this->earning,$this->user));//emailの列を自動的に探してくれる
        }
        //kyoutanba.yakipon@gmail.com
         //info@tanba-nouhan.com
        
    }
}
