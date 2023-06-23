<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Controllers\EmailController;

class MessagesController extends Controller
{
    //
    public function form()
    {
        //
        return view('contact-us', [
            'title' => 'Contact Us',
        ]);
    }
    public function store(Request $request)
    {
        // Validate
        $validatedData = $request->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|email:dns',
                'subject' => 'required|max:50',
                'whatsapp' => 'required|min:2|max:20',
                'message_content' => 'required|max:512',
                'g-recaptcha-response' => 'required|captcha'
            ],
            [
                'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
                'g-recaptcha-response.captcha' => 'The reCAPTCHA verification failed. Please try again.',
                'date.after' => 'The date must be a valid date and should be a future date.',
            ]
        );

        // Create and save
        Message::create($validatedData);

        // Send email
        $messageData = $validatedData;
        unset($messageData['g-recaptcha-response']); // Remove the reCAPTCHA response from the data
        $emailController = new EmailController();
        $emailController->sendMessageToAdmin($messageData);

        return redirect('/contact-us')->with('success', 'Message sent!');
    }

    public function index()
    {

        $message = Message::latest()->paginate(10);
        return view('dashboard.messages.index', [
            'title' => 'Show Requests',
            'message' => $message,
        ]);
    }
    public function show(Message $message)
    {
        //
        return view('dashboard.messages.show', [
            'title' => 'Message Details',
            'message' => $message
        ]);
    }

    public function destroy(Message $message)
    {
        //
        Message::destroy($message->id);
        return redirect('/admin/dashboard/messages')->with('success', 'Message has been deleted!');
    }


}
