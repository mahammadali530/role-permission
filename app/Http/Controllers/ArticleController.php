<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view articles', only:['index']),
            new Middleware('permission:edit articles', only:['edit']),
            new Middleware('permission:create articles', only:['create']),
            new Middleware('permission:delete articles', only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(25);
        return view ('articles.list',[
            'articles' => $articles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view ('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),[
        'title' => 'required|min:5',
         'author' => 'required|min:5'
       ]);
        
       if ($validator->passes()) {
        $article = new Article();
        $article->title = $request->title;
        $article->text = $request->text;
        $article->author = $request->author;
        $article->save();
        return redirect()->route('articles.index')->with('success', 'Article Add successfuly.');
   

       }else{
        return redirect()->route('articles.create')->withInput()->withErrors($validator);
       }
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
    public function articelsedit( $id)
    {
        $articles = Article::find($id);

            if (!$articles) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            return response()->json(['data' => $articles], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function Aupdate(Request $request, $id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            if ($article->save()) {
                return response()->json(['success' => true, 'message' => 'Student updated successfully']);
            }
        }
        return redirect()->route('articles.index')->with('success', 'permissions Update successfuly!');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletea($id)
    {
        $isdeleted = Article::destroy(($id));
        if ($isdeleted) {
            session()->flash('success', 'articles delete successfulye');
            return redirect('articles');
        } else {
            return 'no deleted record';
        }
    }
}
