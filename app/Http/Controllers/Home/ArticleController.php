<?php

namespace App\Http\Controllers\Home;

use App\Models\ArticleModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articleIndex()
    {
        $articles = ArticleModel::paginate(15);
        return view('home/article.article',[
            'articles' => $articles,
            'type' => 'article'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articles()
    {
        $articles = ArticleModel::paginate(15);
        return view('home/article.article',[
            'articles' => $articles,
            'product_id' => '',
            'product' => '',
            'type' => 'all'
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articleCreate($id)
    {
        $product = ProductsModel::where('id' , $id)->first();
        $product_number = $product->number;
        return view('home/article.articleCreate',[
        'product_number' => $product_number,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function articleStore(Request $request)
    {
        $product_number = $request->input('product_number');
        $product = ProductsModel::where('number' , $product_number)->first();
        $id = $product->id;
        $article = new ArticleModel();
        $article->product_number = $request->input('product_number') ? $request->input('product_number') : '';
        $article->article_type = $request->input('article_type') ? $request->input('article_type') : '';
        $article->title = $request->input('title') ? $request->input('title') : '';
        $article->author = $request->input('author') ? $request->input('author') : '';
        $article->content = $request->input('content') ? $request->input('content') : '';
        $article->article_time = $request->input('article_time') ? $request->input('article_time') : '';
        $articles = $article->save();
        if($articles == true){
            return redirect()->action('Home\ArticleController@articleIndex', ['product_id' => $id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function articleEdit($id)
    {
        $article = ArticleModel::where('id' , $id)->first();
        return view('home/article.articleEdit',[
            'article' => $article,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function articleUpdate(Request $request)
    {
        $id = (int)$request->input('article_id');
        $article = ArticleModel::find($id);
        $product_number = $request->input('product_number');
        $product_id = ProductsModel::where('number' , $product_number)->first();
        if($article->update($request->all())){
            return redirect()->action('Home\ArticleController@articleIndex', ['product_id' => $product_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
