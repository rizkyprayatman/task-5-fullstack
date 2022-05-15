<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Controllers\BaseController;

class ArticleController extends BaseController
{
    public function index() 
    {
        // $article = Article::all();
        $articleList = Article::paginate(5);

        $response = [
            'List Article' => $articleList
        ];
        // return response()->json($articleList, 200);
        return $this->responseOk($response);
    }

    public function get($id) 
    {
        $article = Article::find($id);
        
        $response = [
            'List Article' => $article
        ];

        if (is_null($article) ){
            return $this->responseError('Data Tidak Ada', 404);
        }else {
            return $this->responseOk($response);
        }
        
    }

    public function post(Request $request)
    {
        $article = new Article;
        $article->title = $request->title;
        $article->content = $request->content;
        $article->image = $request->image;
        $article->user_id = $request->user_id;
        $article->category_id = $request->category_id;
        $success = $article->save();

        $response = [
            'List Article' => $article
        ];

        if(!$success)
        {
            return $this->responseError('Error - Tidak Berhasil Menyimpan ', 500);
        }else 
        {
            return $this->responseOk($response);
        }
    }

    public function update(Request $request){
        $article = Article::find($request->id);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->image = $request->image;
        $article->user_id = $request->user_id;
        $article->category_id = $request->category_id;

        $success = $article->save();

        $response = [
            'List Article' => $article
        ];

        if(!$success)
        {
            return $this->responseError('Error - Tidak berhasil mengedit ', 500);
        }else 
        {
            return $this->responseOk($response);
        }
    }

    public function destroy($id) {
        $article = Article::find($id);

        if (is_null($article))
        {
            return $this->responseError('Data tidak ada', 404);
        }
        
        $success = $article->delete();

        if (!$success){
            return $this->responseError('Error - Tidak dapat menghapus', 500);
        }else {
            return response()->json("Delete Success", 201);
        }
    }
}
