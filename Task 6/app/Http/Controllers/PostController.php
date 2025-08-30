<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();
    
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
    
        $posts = $query->latest()->paginate(6);
    
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:16684',
        ]);

        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();

        $originalPath = public_path('uploads/original/' . $filename);
        $thumbnailPath = public_path('uploads/thumbnails/' . $filename);

        $image->move(public_path('uploads/original'), $filename);

        $this->createThumbnailWithWatermark($originalPath, $thumbnailPath);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = Auth::id();
        $post->image = $filename;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Пост успешно создан.');
    }

    private function createThumbnailWithWatermark($originalPath, $thumbnailPath)
    {
        ini_set('memory_limit', '256M');

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
    


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $originalPath = public_path('uploads/original/' . $post->image);
        $thumbnailPath = public_path('uploads/thumbnails/' . $post->image);

        if (file_exists($originalPath)) {
            unlink($originalPath);
        }
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Пост успешно удалён.');
    }

}
