<?php

namespace App\Listeners;

use App\Events\QuoteCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  QuoteCreated  $event
     * @return void
     */
    public function handle(QuoteCreated $event)
    {
        $author = $event->author_name;
        $email = $event->author_email;

        Mail::send('email.user_notification',['name' =>$author],function ($message) use ($email,$author){
            $message->from('admin@mytestcourse.com' , 'Admin');
            $message->to($email , $author);
            $message->subject('Thank You For Your Quote!');
        });
    }
}
