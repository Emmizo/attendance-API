<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\endedEvent;
use Mail;
use App\Mail\endedAt;

class endedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(endedEvent $event): void
    {
        $info = $event->info;
        $mail = $info['email'];
        $mails = array($mail);
        
        // mail
        $subject = "Attandent";
        
        Mail::to($mails)->send(new endedAt($subject, $info));
        //
    }
}