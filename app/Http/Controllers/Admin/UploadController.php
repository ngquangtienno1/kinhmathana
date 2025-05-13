<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UploadFile;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Giới hạn 10MB
            'object_type' => 'required|string|max:50',
            'object_id' => 'required|integer'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $fileType = $file->getClientMimeType();

        // Lưu file vào thư mục storage/app/public/uploads
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Tạo bản ghi trong database
        $uploadFile = UploadFile::create([
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_path' => $filePath,
            'object_type' => $request->object_type,
            'object_id' => $request->object_id
        ]);

        return response()->json([
            'success' => true,
            'file' => $uploadFile,
            'url' => asset('storage/' . $filePath)
        ]);
    }

    public function delete(UploadFile $file)
    {
        // Xóa file khỏi storage
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Xóa bản ghi khỏi database
        $file->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
