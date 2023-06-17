<?php

namespace App\Http\Controllers;

use App\Mail\RequestApprovalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestNotificationToAdmin;

class EmailController extends Controller
{
    public function sendShowRequestEmail($showRequestData)
    {
        Mail::to('tbkb.batangkapas@gmail.com')->send(new RequestNotificationToAdmin($showRequestData));
    }

    public function sendRequestApprovalEmail($approvalData)
    {
        Mail::to($approvalData['email'])->send(new RequestApprovalNotification($approvalData));
    }
    
}
