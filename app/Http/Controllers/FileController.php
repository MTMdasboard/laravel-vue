<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;


class FileController extends Controller
{
    public function index(Request $request)
    {

        $validated = $request->validate([
            "search" => ["nullable", "string", "min:3", "max:255"],
            "limit" => ["nullable", "integer", "min:1", "max:100"],
            "page" => ["nullable", "integer", "min:1"],
        ]);

        $search = $validated['search'] ?? null;
        $limit = $validated['limit'] ?? 25;

        $query = UploadedFile::query();

        if ($search) {
            $query->where('filename', 'like', '%' . $search . '%');
            $query->orWhere('original_filename', 'like', '%' . $search . '%');
        }

        $page = $query
            ->latest('updated_at')
            ->paginate($limit, ['id', 'filename', 'original_filename', 'extension', 'size', 'thumb_100x100_path', 'is_image']);

        foreach ($page as $file) {
            $file->size_in_mb = round($file->size / 1048576, 2);
            if ($file->is_image && $file->thumb_100x100_path) {
                $file->thumb_100x100_path = Storage::url($file->thumb_100x100_path);
            }
        }

        $count = UploadedFile::count();

        return Inertia::render('Files/Index', compact(['page', 'count']));
    }

    public function create()
    {
        return Inertia::render('Files/Create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate(UploadedFile::getRules());
        
        $file = $request->file('file');
        $filename = $validate['filename'] ?? null;
        $original_filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mime_type = $file->getMimeType();
        $size = $file->getSize();

        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);

        $filePath = $file->store('public');
        $thumb_100x100_path = null;

        if ($isImage) {

            $image = Image::make(storage_path('app/' . $filePath));

            if ($image->width() >= 100 && $image->height() >= 100) {
                $image->fit(100, 100);
                $filenameWithoutExtension = pathinfo($filePath, PATHINFO_FILENAME);
                $thumb_100x100_path = 'public/thumb/100x100/' . $filenameWithoutExtension . '.' . $extension;
                Storage::put($thumb_100x100_path, (string) $image->encode());
            } else {
                $thumb_100x100_path = $filePath;
            }
        }

        UploadedFile::create([
            'filename' => $filename,
            'original_filename' => $original_filename,
            'extension' => $extension,
            'mime_type' => $mime_type,
            'size' => $size,
            'file_path' => $filePath,
            'is_image' => $isImage,
            'thumb_100x100_path' => $thumb_100x100_path,
        ]);

        return redirect()->route('files');
    }

    public function multiple(Request $request)
    {
        $request->validate([
            'filelist.*' => ['required', 'file', 'max:8388608']
        ]);

        $filelist = $request->file('filelist');

        foreach ($filelist as $file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $mime_type = $file->getMimeType();
            $size = $file->getSize();

            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);

            $filePath = $file->store('public');
            $thumb_100x100_path = null;

            if ($isImage) {
                $image = Image::make(storage_path('app/' . $filePath));

                if ($image->width() >= 100 && $image->height() >= 100) {
                    $image->fit(100, 100);
                    $filenameWithoutExtension = pathinfo($filePath, PATHINFO_FILENAME);
                    $thumb_100x100_path = 'public/thumb/100x100/' . $filenameWithoutExtension . '.' . $extension;
                    Storage::put($thumb_100x100_path, (string) $image->encode());
                } else {
                    $thumb_100x100_path = $filePath;
                }
            }

            UploadedFile::create([
                'filename' => null,
                'original_filename' => $filename,
                'extension' => $extension,
                'mime_type' => $mime_type,
                'size' => $size,
                'file_path' => $filePath,
                'is_image' => $isImage,
                'thumb_100x100_path' => $thumb_100x100_path,
            ]);
        }

        return redirect()->route('files');
    }


    public function edit($fileId)
    {

        $file = UploadedFile::query()->findOrFail($fileId, ['id', 'filename', 'original_filename', 'mime_type', 'file_path', 'is_image']);

        $filePath = storage_path('app/' . $file->file_path);
        $fileContents = file_get_contents($filePath);

        return Inertia::render('Files/Edit', [
            'file' => [
                'id' => $file->id,
                'filename' => $file->filename,
                'original_filename' => $file->original_filename,
                'mime_type' => $file->mime_type,
                'file' => base64_encode($fileContents),
                'is_image' => $file->is_image,
            ],
        ]);

    }

    public function update(Request $request, $fileId)
    {
        $file = UploadedFile::findOrFail($fileId);

        $validate = $request->validate(UploadedFile::getRules());

        $newFile = $request->file('file');
        $extension = $newFile->getClientOriginalExtension();
        $mime_type = $newFile->getMimeType();
        $size = $newFile->getSize();

        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);

        $filePath = $newFile->store('public');
        $thumb_100x100_path = null;

        if ($isImage) {
            $image = Image::make(storage_path('app/' . $filePath));

            if ($image->width() >= 100 && $image->height() >= 100) {
                $image->fit(100, 100);
                $filenameWithoutExtension = pathinfo($filePath, PATHINFO_FILENAME);
                $thumb_100x100_path = 'public/thumb/100x100/' . $filenameWithoutExtension . '.' . $extension;
                Storage::put($thumb_100x100_path, (string) $image->encode());
            } else {
                $thumb_100x100_path = $filePath;
            }
        }

        Storage::delete($file->file_path);
        $file->thumb_100x100_path && Storage::delete($file->thumb_100x100_path);

        $file->update([
            'filename' => $validate['filename'] ?? null,
            'original_filename' => $newFile->getClientOriginalName(),
            'extension' => $extension,
            'mime_type' => $mime_type,
            'size' => $size,
            'file_path' => $filePath,
            'is_image' => $isImage,
            'thumb_100x100_path' => $thumb_100x100_path,
        ]);

        return redirect()->route('files');
    }

    public function destroy($fileId)
    {
        $file = UploadedFile::query()->findOrFail($fileId);

        Storage::delete($file->file_path);

        $file->thumb_100x100_path && Storage::delete($file->thumb_100x100_path);

        $file->delete();

        return redirect()->route('files');
    }

    public function download($fileId)
    {
        $file = UploadedFile::query()->findOrFail($fileId);

        $name = $file->filename ? $file->filename . '.' . $file->extension : $file->original_filename;

        return Storage::download($file->file_path, $name);
    }
}
