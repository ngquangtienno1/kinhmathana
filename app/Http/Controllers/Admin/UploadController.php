<?php

namespace App\Http\Controllers\Admin;

use App\Models\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Giới hạn 10MB
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Lưu file vào thư mục storage/app/public/uploads
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            if (!$filePath) {
                throw new \Exception('Không thể lưu file');
            }

            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $filePath)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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
