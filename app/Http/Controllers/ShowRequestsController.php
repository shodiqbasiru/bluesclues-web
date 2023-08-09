<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ShowRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\EmailController;
use PDF;

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
        $month = $request->input('month');
        $year = $request->input('year');
        $yearonly = $request->input('yearonly');

        $showRequests = ShowRequest::query();

        if ($status === NULL) {
            $showRequests->orderByDesc('created_at');
        } elseif ($status === 'awaiting-approval') {
            $showRequests->where('status', 0)
                ->orderByDesc('created_at');
        } elseif ($status === 'accepted') {
            $showRequests->where('status', 1)
                ->orderByDesc('created_at');
        } elseif ($status === 'rejected') {
            $showRequests->where('status', 2)
                ->orderByDesc('created_at');
        } elseif ($status === 'cancelled') {
            $showRequests->where('status', 3)
                ->orderByDesc('created_at');
        }

        // Retrieve the search query
        $searchQuery = $request->input('search');

        // Apply the search filter if a search query is provided
        if (!empty($searchQuery)) {
            $showRequests->where(function ($query) use ($searchQuery) {
                $query->where('company_name', 'like', "%$searchQuery%")
                    ->orWhere('eventname', 'like', "%$searchQuery%")
                    ->orWhere('location', 'like', "%$searchQuery%");
            });
        }

        if ($month && $year) {
            $dateString = $year . '-' . $month . '-01'; // Construct a date string with year, month, and day
            $showRequests->whereMonth('date', Carbon::parse($dateString)->month)
                ->whereYear('date', $year);
        }
        if ($yearonly) {
            $showRequests->whereYear('date', $yearonly);
        }

        // Pagination settings
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        // Paginate the results
        $showRequests = $showRequests->paginate($perPage)->appends([
            'status' => $status,
            'search' => $searchQuery,
            'month' => $month,
            'year' => $year,
            'yearonly' => $yearonly,
        ]);

        return view('dashboard.show-requests.index', [
            'title' => 'Show Requests',
            'showRequests' => $showRequests,
            'status' => $status,
            'startIndex' => $startIndex,
            'searchQuery' => $searchQuery,
            'month' => $month,
            'selectedYear' => $year,
            'selectedYearOnly' => $yearonly,
        ]);
    }

    public function show(ShowRequest $showRequest)
    {
        return view('dashboard.show-requests.show', [
            'title' => 'Show Request Details',
            'showRequest' => $showRequest,

        ]);
    }

    public function addToEvent(ShowRequest $showRequest)
    {
        //
        $formattedDate = Carbon::parse($showRequest->date)->format('Y-m-d');

        if ($showRequest->status === 0) {
            return back()->withErrors(['error' => 'Please approve the request before adding to event']);
        }
        return view('dashboard.show-requests.addToEvent', [
            'title' => 'Events',
            'showRequest' => $showRequest,
            'formattedDate' => $formattedDate,
        ]);
    }






    public function approve(ShowRequest $showRequest)
    {

        if ($showRequest->status === 0) {

            // Update the status field to 1 for "Accepted" in the database
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
                'subject' => $showRequest->status === 1 ? 'Request Accepted' : 'Request Rejected',
                'body' => $showRequest->status === 1 ? 'Thank you for your show request submission. We are pleased to inform you that your request has been accepted. We appreciate your interest in our band and look forward to performing at your event. Our team will reach out to you soon to discuss further details and arrangements. Should you have any questions, feel free to contact us.' : 'Thank you for your show request submission. We regret to inform you that after careful consideration, we are unable to proceed with your request at this time. We appreciate your interest in our band and understand that this news may be disappointing. We encourage you to continue exploring other opportunities and wish you the best in your future endeavors.',
                'bottom_text' => $showRequest->status === 1 ? 'If you have any additional questions or require further assistance, please don\'t hesitate to contact us. We look forward to working together and delivering an outstanding performance for your audience.' : 'If you have any further questions or would like more information, please don\'t hesitate to reach out to us. We appreciate your understanding.',
            ];

            $emailController = new EmailController();
            $emailController->sendRequestApprovalEmail($approvalData);

            return redirect()->back()->with('success', 'Show request has been accepted successfully.');
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
                'subject' => $showRequest->status === 1 ? 'Request Accepted' : 'Request Rejected',
                'body' => $showRequest->status === 1 ? 'Thank you for your show request submission. We are pleased to inform you that your request has been accepted. We appreciate your interest in our band and look forward to performing at your event. Our team will reach out to you soon to discuss further details and arrangements. Should you have any questions, feel free to contact us.' : 'Thank you for your show request submission. We regret to inform you that after careful consideration, we are unable to proceed with your request at this time. We appreciate your interest in our band and understand that this news may be disappointing. We encourage you to continue exploring other opportunities and wish you the best in your future endeavors.',
                'bottom_text' => $showRequest->status === 1 ? 'If you have any additional questions or require further assistance, please don\'t hesitate to contact us. We look forward to working together and delivering an outstanding performance for your audience.' : 'If you have any further questions or would like more information, please don\'t hesitate to reach out to us. We appreciate your understanding.'
            ];

            $emailController = new EmailController();
            $emailController->sendRequestApprovalEmail($approvalData);

            return redirect()->back()->with('success', 'Show request has been rejected successfully.');
        } else {
            return redirect()->back();
        }
    }

    public function cancel(ShowRequest $showRequest)
    {

        if ($showRequest->status === 1) {

            // Update the status field to 3 for "Cancelled" in the database
            $showRequest->update([
                'status' => 3,
            ]);
            return redirect()->back()->with('success', 'Show request has been cancelled successfully.');
        } else {
            return redirect()->back();
        }
    }


    public function export(Request $request)
    {
        $status = $request->input('status');
        $month = $request->input('month');
        $year = $request->input('year');
        $yearonly = $request->input('yearonly');

        $showRequests = ShowRequest::query();
        $filename = 'show-requests-report';

        if ($status === NULL) {
            $showRequests->where('status', 0)
                ->orderByDesc('created_at');
        } elseif ($status === 'awaiting-approval') {
            $showRequests->where('status', 0)
                ->orderByDesc('created_at');
        } elseif ($status === 'accepted') {
            $showRequests->where('status', 1)
                ->orderByDesc('created_at');
        } elseif ($status === 'rejected') {
            $showRequests->where('status', 2)
                ->orderByDesc('created_at');
        }
        if (!empty($status)) {
            $filename .= '-status-' . $status;
        }


        if ($month && $year) {
            $dateString = $year . '-' . $month . '-01'; // Construct a date string with year, month, and day
            $showRequests->whereMonth('date', Carbon::parse($dateString)->month)
                ->whereYear('date', $year);
            $filename .= '-date-' . date('F', mktime(0, 0, 0, $month, 1)) . '-' . $year;
        }
        if ($yearonly) {
            $showRequests->whereYear('date', $yearonly);
            $filename .= '-date-' . $yearonly;
        }

        $showRequests = $showRequests->get();

        $pdf = PDF::loadview('dashboard.show-requests.report', [
            'showRequests' => $showRequests,
            'status' => $status,
            'month' => $month,
            'selectedYear' => $year,
            'selectedYearOnly' => $yearonly,
        ]);

        $filename = preg_replace('/[^a-zA-Z0-9\-]/', '_', $filename);

        return $pdf->download($filename . '.pdf');
    }
}
