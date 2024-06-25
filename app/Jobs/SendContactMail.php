<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use\Illuminate\Support\Facades\Mail;
use\App\Mail\ContactMail;

class SendContactMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    public $request;

    public function __construct($request)
    {
        $this->request=$request;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if(app()->isLocal()){
            Mail::to('kyoutanba.yakipon@gmail.com')->send(new ContactMail($this->request));//emailの列を自動的に探してくれる
        }else{
            Mail::to('info@tanba-nouhan.com')->send(new ContactMail($this->request));//emailの列を自動的に探してくれる
        }
        //kyoutanba.yakipon@gmail.com
        //info@tanba-nouhan.com
    }
}
