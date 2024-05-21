<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

class MailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function send_notification()
    {
    	Mail::to('maine.vspn@gmail.com')->send(new NotificationMail());
    }
}
