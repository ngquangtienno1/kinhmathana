<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage as Contact;
use Illuminate\Support\Facades\Cache;





class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('client.contact.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        //
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ip = $request->ip();
        $key = 'contact_form_' . $ip;
        $maxAttempts = 3;
        $decayMinutes = 5;

        $attempts = Cache::get($key, 0);
        if ($attempts >= $maxAttempts) {
            return back()->withErrors(['Bạn gửi liên hệ quá nhiều lần, vui lòng thử lại sau!']);
        }
        Cache::put($key, $attempts + 1, now()->addMinutes($decayMinutes));

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required'    => 'Vui lòng nhập tên của bạn.',
            'email.required'   => 'Vui lòng nhập email.',
            'email.email'      => 'Email không đúng định dạng.',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();
        $validated['status']     = 'mới';
        $validated['is_spam']    = 0;
        // 1. Lưu DB
        $contact = Contact::create($validated);

        return back()->with('success', 'Gửi liên hệ thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
