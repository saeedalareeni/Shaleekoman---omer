<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index(Request $request)
    {
        // Check if export is requested
        if ($request->has('export') && $request->export == 'excel') {
            return $this->exportToExcel();
        }
        
        $query = Post::query();
        
        // Basic search
        if ($request->filled('query')) {
            $search = $request->input('query');
            $query->where(function($q) use ($search) {
                $q->where('body_en', 'LIKE', "%{$search}%")
                  ->orWhere('body_ar', 'LIKE', "%{$search}%")
                  ->orWhere('title_en', 'LIKE', "%{$search}%")
                  ->orWhere('title_ar', 'LIKE', "%{$search}%");
            });
        }
        
        // Advanced search
        if ($request->filled('title')) {
            $title = $request->input('title');
            $query->where(function($q) use ($title) {
                $q->where('title_en', 'LIKE', "%{$title}%")
                  ->orWhere('title_ar', 'LIKE', "%{$title}%");
            });
        }
        
        if ($request->filled('content')) {
            $content = $request->input('content');
            $query->where(function($q) use ($content) {
                $q->where('body_en', 'LIKE', "%{$content}%")
                  ->orWhere('body_ar', 'LIKE', "%{$content}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }
        
        $posts = $query->orderBy('id', 'desc')->paginate(10);
        return view('backend.pages.posts.index-enhanced', compact('posts'));
    }
    
    private function exportToExcel()
    {
        $posts = Post::all();
        $filename = 'posts_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $columns = ['ID', 'Title AR', 'Title EN', 'Status', 'Created At'];
        
        $callback = function() use ($posts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($posts as $post) {
                fputcsv($file, [
                    $post->id,
                    $post->title_ar,
                    $post->title_en,
                    $post->status == 1 ? 'Published' : 'Draft',
                    $post->created_at->format('Y-m-d')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }




    public function create()
    {
        return view('backend.pages.posts.add');
    }



    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',

            'body_ar' => 'required|string',
            'body_en' => 'required|string',

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($image = $request->file('image')){
            $path = 'images/Posts/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }

        if ($image = $request->file('image2')){
            $path = 'images/Posts/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image2'] = $path.$filename;
        }

        $data['slug'] = SlugService::createSlug(Post::class, 'slug', $request->title_ar);
        $data['title_ar'] = $request->title_ar;
        $data['title_en'] = $request->title_ar;

        $data['body_ar'] = $request->body_ar;
        $data['body_en'] = $request->body_en;

        $data['meta_keywords_ar'] = $request->meta_keywords_ar;
        $data['meta_keywords_en'] = $request->meta_keywords_en;

        $data['meta_description_ar'] = $request->meta_description_ar;
        $data['meta_description_en'] = $request->meta_description_en;
        $data['video'] = $request->video;
        $data['status'] = $request->status;
        $data['featured'] = $request->featured;

        Post::create($data);

        toast('تم الإضافة بنجاح','success');
        return redirect()->route('posts.index');
    }



    public function show($id)
    {
        $post = Post::find($id);
        return view('backend.pages.posts.show', compact('post'));
    }


    public function edit($id)
    {
        $post = Post::find($id);
        return view('backend.pages.posts.edit', compact('post'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',

            'body_ar' => 'required|string',
            'body_en' => 'required|string',

        ]);

        $page = Post::find($id);

        if ($image = $request->file('image')){
            $path = 'images/Posts/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image'] = $path.$filename;
        }

        if ($image = $request->file('image2')){
            $path = 'images/Posts/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['image2'] = $path.$filename;
        }

        $data['slug'] = SlugService::createSlug(Post::class, 'slug', $request->title_ar);
        $data['title_ar'] = $request->title_ar;
        $data['title_en'] = $request->title_ar;

        $data['body_ar'] = $request->body_ar;
        $data['body_en'] = $request->body_en;

        $data['meta_keywords_ar'] = $request->meta_keywords_ar;
        $data['meta_keywords_en'] = $request->meta_keywords_en;

        $data['meta_description_ar'] = $request->meta_description_ar;
        $data['meta_description_en'] = $request->meta_description_en;
        $data['video'] = $request->video;
        $data['status'] = $request->status;
        $data['featured'] = $request->featured;
        $page->update($data);

        toast('تم التعديل بنجاح','success');
        return redirect()->route('posts.index');
    }



    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'تم حذف المقال بنجاح');
    }
    
    public function toggleStatus($id)
    {
        $post = Post::findOrFail($id);
        $post->status = $post->status == 1 ? 0 : 1;
        $post->save();
        
        $message = $post->status == 1 ? 'تم نشر المقال بنجاح' : 'تم إخفاء المقال بنجاح';
        return redirect()->back()->with('success', $message);
    }

}
