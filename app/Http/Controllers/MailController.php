<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function send_notification()
    {
        Mail::to('maine.vspn@gmail.com')->send(new NotificationMail);
    }
}
