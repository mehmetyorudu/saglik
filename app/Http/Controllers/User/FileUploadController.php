<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    /**
     * Quill.js'ten gelen dosyaları (resim/PDF) yükler.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadArticleFile(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = 'articles_files/' . date('Y/m');
            $filePath = $file->storePubliclyAs($path, $fileName, 'public');

            return response()->json(['url' => Storage::url($filePath)]);
        }

        return response()->json(['message' => 'Dosya yüklenemedi.'], 400);
    }
}
