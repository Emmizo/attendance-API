<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\startedEvent;
use Mail;
use App\Mail\startedAt;

class startedListener
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
    public function handle(startedEvent $event): void
    {
        $info = $event->info;
        $mail = $info['email'];
        $mails = array($mail);
        
        // mail
        $subject = "Attandent";
        
        Mail::to($mails)->send(new startedAt($subject, $info));
        //
    }
}