<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use App\Models\UploadFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = WebsiteSetting::with('logo')->first();
        return view('admin.settings.index', compact('settings'));
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
        //
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'website_name' => 'required|string|max:125',
            'contact_email' => 'required|email|max:125',
            'hotline' => 'required|string|max:20',
            'address' => 'required|string',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'default_shipping_fee' => 'required|numeric|min:0',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|string|max:10',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|string|max:10',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'ai_api_key' => 'nullable|string|max:255',
            'ai_api_endpoint' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $settings = WebsiteSetting::first();
        if (!$settings) {
            $settings = new WebsiteSetting();
        }

        // Xử lý upload logo nếu có
        if ($request->hasFile('logo')) {
            // Xóa logo cũ nếu có
            if ($settings->logo_id) {
                $oldLogo = UploadFile::find($settings->logo_id);
                if ($oldLogo) {
                    if (Storage::disk('public')->exists($oldLogo->file_path)) {
                        Storage::disk('public')->delete($oldLogo->file_path);
                    }
                    $oldLogo->delete();
                }
            }

            // Upload logo mới
            $file = $request->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $fileType = $file->getClientMimeType();

            // Lưu file vào thư mục storage/app/public/uploads
            $filePath = $file->storeAs('uploads/logo', $fileName, 'public');

            // Tạo bản ghi trong database
            $uploadFile = UploadFile::create([
                'file_name' => $fileName,
                'file_type' => $fileType,
                'file_path' => $filePath,
                'object_type' => 'App\Models\WebsiteSetting',
                'object_id' => $settings->id ?: 1
            ]);

            $settings->logo_id = $uploadFile->id;
        }

        $settings->fill($request->except('logo'));
        $settings->save(); // ✅ Cache sẽ tự được xóa trong model

        return redirect()->back()->with('success', 'Cập nhật cài đặt thành công');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
