<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Message;
use Illuminate\Http\Request;
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

    public function index(Request $request)
    {
        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        $searchQuery = $request->input('search');

        $month = $request->input('month');
        $year = $request->input('year');

        $yearonly = $request->input('yearonly');

        $message = Message::latest();


        if (!empty($searchQuery)) {
            $message->where(function ($query) use ($searchQuery) {
                $query->where('subject', 'like', "%$searchQuery%")
                    ->orWhere('name', 'like', "%$searchQuery%")
                    ->orWhere('email', 'like', "%$searchQuery%")
                    ->orWhere('whatsapp', 'like', "%$searchQuery%")
                    ->orWhere('message_content', 'like', "%$searchQuery%");
            });
        }

        if ($month && $year) {
            $dateString = $year . '-' . $month . '-01'; // Construct a date string with year, month, and day
            $message->whereMonth('created_at', Carbon::parse($dateString)->month)
                ->whereYear('created_at', $year);
        }
        if ($yearonly) {
            $message->whereYear('created_at', $yearonly);
        }

        $message = $message->paginate($perPage)->appends([
            'search' => $searchQuery,
            'month' => $month,
            'year' => $year,
            'yearonly' => $yearonly,
        ]);

        return view('dashboard.messages.index', [
            'title' => 'Messages',
            'message' => $message,
            'startIndex' => $startIndex,
            'searchQuery' => $searchQuery,
            'month' => $month,
            'selectedYear' => $year,
            'selectedYearOnly' => $yearonly,
        ]);
    }

    public function show(Message $message)
    {

        return view('dashboard.messages.show', [
            'title' => 'Message Details',
            'message' => $message,

        ]);
    }

    public function destroy(Message $message)
    {
        //
        Message::destroy($message->id);
        return redirect('/admin/dashboard/messages')->with('success', 'Message has been deleted!');
    }
}
