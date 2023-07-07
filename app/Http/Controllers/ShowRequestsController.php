<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShowRequest;
use App\Http\Controllers\EmailController;

class ShowRequestsController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validate
        $validatedData = $request->validate(
            [
                'company_name' => 'required|max:255',
                'email' => 'required|email:dns',
                'date' => 'required|date|after:' . now()->format('Y-m-d'),
                'whatsapp' => 'required|min:2|max:20',
                'eventname' => 'nullable|max:255',
                'location' => 'required|max:255',
                'g-recaptcha-response' => 'required|captcha'
            ],
            [
                'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
                'g-recaptcha-response.captcha' => 'The reCAPTCHA verification failed. Please try again.',
                'date.after' => 'The date must be a valid date and should be a future date.',
            ]
        );

        // Create and save
        ShowRequest::create($validatedData);

        // Send email
        $showRequestData = $validatedData;
        unset($showRequestData['g-recaptcha-response']); // Remove the reCAPTCHA response from the data
        $emailController = new EmailController();
        $emailController->sendShowRequestEmail($showRequestData);

        return redirect('/events')->with('success', 'Request for a show has been sent');
    }

    public function index(Request $request)
    {
        $status = $request->input('status');

        $showRequests = ShowRequest::query();

        if ($status === NULL) {
            $showRequests->where('status', 0);
        } elseif ($status === 'awaiting-approval') {
            $showRequests->where('status', 0);
        } elseif ($status === 'approved') {
            $showRequests->where('status', 1);
        } elseif ($status === 'rejected') {
            $showRequests->where('status', 2);
        }

        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        $showRequests = $showRequests->paginate($perPage)
            ->appends(['status' => $status]);
        return view('dashboard.show-requests.index', [
            'title' => 'Show Requests',
            'showRequests' => $showRequests,
            'status' => $status,
            'startIndex' => $startIndex,
        ]);
    }


    public function approve(ShowRequest $showRequest)
    {

        if ($showRequest->status === 0) {

            // Update the status field to 1 for "Approved" in the database
            $notes = request('notes');
            $showRequest->update([
                'status' => 1,
                'notes' => $notes
            ]);

            $approvalData = [
                'company_name' => $showRequest->company_name,
                'email' => $showRequest->email,
                'date' => $showRequest->date,
                'eventname' => $showRequest->eventname,
                'location' => $showRequest->location,
                'whatsapp' => $showRequest->whatsapp,
                'status' => $showRequest->status,
                'notes' => $showRequest->notes,
                'subject' => $showRequest->status === 1 ? 'Request Approved' : 'Request Rejected',
                'body' => $showRequest->status === 1 ? 'Thank you for your show request submission. We are pleased to inform you that your request has been approved. We appreciate your interest in our band and look forward to performing at your event. Our team will reach out to you soon to discuss further details and arrangements. Should you have any questions, feel free to contact us.' : 'Thank you for your show request submission. We regret to inform you that after careful consideration, we are unable to proceed with your request at this time. We appreciate your interest in our band and understand that this news may be disappointing. We encourage you to continue exploring other opportunities and wish you the best in your future endeavors.',
                'bottom_text' => $showRequest->status === 1 ? 'If you have any additional questions or require further assistance, please don\'t hesitate to contact us. We look forward to working together and delivering an outstanding performance for your audience.' : 'If you have any further questions or would like more information, please don\'t hesitate to reach out to us. We appreciate your understanding.',
            ];

            $emailController = new EmailController();
            $emailController->sendRequestApprovalEmail($approvalData);

            return redirect()->back()->with('success', 'Show request has been approved successfully.');
        } else {
            return redirect()->back();
        }
    }

    public function reject(ShowRequest $showRequest)
    {

        if ($showRequest->status === 0) {

            // Update the status field to 2 for "Rejected" in the database
            $notes = request('notes');
            $showRequest->update([
                'status' => 2,
                'notes' => $notes
            ]);

            $approvalData = [
                'company_name' => $showRequest->company_name,
                'email' => $showRequest->email,
                'date' => $showRequest->date,
                'eventname' => $showRequest->eventname,
                'location' => $showRequest->location,
                'whatsapp' => $showRequest->whatsapp,
                'status' => $showRequest->status,
                'notes' => $showRequest->notes,
                'subject' => $showRequest->status === 1 ? 'Request Approved' : 'Request Rejected',
                'body' => $showRequest->status === 1 ? 'Thank you for your show request submission. We are pleased to inform you that your request has been approved. We appreciate your interest in our band and look forward to performing at your event. Our team will reach out to you soon to discuss further details and arrangements. Should you have any questions, feel free to contact us.' : 'Thank you for your show request submission. We regret to inform you that after careful consideration, we are unable to proceed with your request at this time. We appreciate your interest in our band and understand that this news may be disappointing. We encourage you to continue exploring other opportunities and wish you the best in your future endeavors.',
                'bottom_text' => $showRequest->status === 1 ? 'If you have any additional questions or require further assistance, please don\'t hesitate to contact us. We look forward to working together and delivering an outstanding performance for your audience.' : 'If you have any further questions or would like more information, please don\'t hesitate to reach out to us. We appreciate your understanding.'
            ];

            $emailController = new EmailController();
            $emailController->sendRequestApprovalEmail($approvalData);

            return redirect()->back()->with('success', 'Show request has been rejected successfully.');
        } else {
            return redirect()->back();
        }
    }
}
