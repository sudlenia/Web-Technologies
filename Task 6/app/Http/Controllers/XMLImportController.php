<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class XMLImportController extends Controller
{
    public function showForm()
    {
        return view('import.xml');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xml|max:10240',
        ]);

        $xml = simplexml_load_file($request->file('file'));

        foreach ($xml->post as $item) {
            $imageUrl = (string) $item->image;
            $imageContent = file_get_contents($imageUrl);

            $imageName = time() . '_' . basename($imageUrl);
            $originalPath = public_path('uploads/original/' . $imageName);
            $thumbnailPath = public_path('uploads/thumbnails/' . $imageName);

            file_put_contents($originalPath, $imageContent);

            $this->createThumbnailWithWatermark($originalPath, $thumbnailPath);

            Post::create([
                'title' => (string) $item->title,
                'description' => (string) $item->description,
                'image' => $imageName,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('import.xml.form')->with('success', 'Данные успешно импортированы');
    }

    private function createThumbnailWithWatermark($originalPath, $thumbnailPath)
    {
        $image = imagecreatefromstring(file_get_contents($originalPath));
    
        $width = imagesx($image);
        $height = imagesy($image);
    
        $newWidth = 300;
        $newHeight = intval($height * ($newWidth / $width));
    
        $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
    
        imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
        $watermark = imagecreatefrompng(public_path('watermark.png'));
        $wmWidth = imagesx($watermark);
        $wmHeight = imagesy($watermark);
    
        $x = $newWidth - $wmWidth - 10;
        $y = ($newHeight - $wmHeight) / 2;
    
        imagecopy($thumbnail, $watermark, $x, $y, 0, 0, $wmWidth, $wmHeight);
    
        imagejpeg($thumbnail, $thumbnailPath, 90);
    
        imagedestroy($image);
        imagedestroy($thumbnail);
        imagedestroy($watermark);
    }
    
}
