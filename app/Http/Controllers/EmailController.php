<?php

namespace App\Http\Controllers;

use App\Mail\RequestApprovalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestNotificationToAdmin;
use App\Mail\MessageNotificationToAdmin;

class EmailController extends Controller
{
    public function sendShowRequestEmail($showRequestData)
    {
        $recipient = env('MAIL_ADMIN');
        Mail::to($recipient)->send(new RequestNotificationToAdmin($showRequestData));
    }

    public function sendRequestApprovalEmail($approvalData)
    {
        Mail::to($approvalData['email'])->send(new RequestApprovalNotification($approvalData));
    }
    
    public function sendMessageToAdmin($messageData)
    {
        $recipient = env('MAIL_ADMIN');
        Mail::to($recipient)->send(new MessageNotificationToAdmin ($messageData));
    }
}
