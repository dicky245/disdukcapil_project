<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    /**
     * Display a listing of the queue.
     */
    public function index()
    {
        $queueData = [
            'total' => 24,
            'serving' => 5,
            'waiting' => 19
        ];

        return view('pages.antrian-online', compact('queueData'));
    }

    /**
     * Store a newly created queue.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'service' => 'required|in:ktp,kk,akta,lainnya',
            'queueDate' => 'required|date|after_or_equal:today',
            'queueTime' => 'required|string',
            'queueName' => 'required|string|max:255',
            'queuePhone' => 'required|string|max:15',
        ]);

        // Generate nomor antrian
        $ticketNumber = 'A-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

        // Simpan logic ke database disini
        // ...

        // Simpan ticket data ke session untuk ditampilkan
        $ticketData = [
            'number' => $ticketNumber,
            'service' => $request->service,
            'date' => $request->queueDate,
            'time' => $request->queueTime,
            'name' => $request->queueName,
            'phone' => $request->queuePhone
        ];

        return redirect()->route('antrian-online')
            ->with('ticket', $ticketData);
    }

    /**
     * Search queue by phone number or ticket number.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'search' => 'required|string|max:255',
        ]);

        // Logic pencarian antrian
        // ...

        return response()->json([
            'status' => 'success',
            'data' => []
        ]);
    }

    /**
     * Display the specified queue.
     */
    public function detail($nomor_antrian)
    {
        // Logic detail antrian
        // ...

        return response()->json([
            'status' => 'success',
            'data' => []
        ]);
    }
}
