<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\User;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;



class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
    }

    /**
     * @OA\Get(
     *      path="/article",
     *      operationId="getArticleList",
     *      tags={"Article"},
     *      summary="Get list of articles",
     *      description="Returns list of all articles and its details",
     *      @OA\Response(
     *          response=200,
     *          description="Success"
     *       ),
     *       @OA\Response(response=400, description="Unsuccess"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns all articles
     */
    public function index(Request $request)
    {
        //
        return Article::where('title', 'LIKE', '%' . $request->search . '%')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/article",
     *      operationId="storeArticle",
     *      tags={"Article"},
     *      summary="Creates a new article",
     *      description="Creates a new article",
     *      @OA\Response(
     *          response=200,
     *          description="Success! Article created."
     *       ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Article's title",
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="Article's description",
     *                     property="description",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="Article's image",
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *                 required={"title", "description", "image"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=422, description="Erro de validação"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Creates a new article
     */
    public function store(ArticleStoreRequest $request)
    {
        //
        $data = $request->only(['title', 'description']);

        //handling feito em ArticleStoreRequest
        /*$validator = Validator::make($data, [
            'title' => 'required|unique:articles',
            'description' => 'required',
            'image' => 'required'
        ]);

        if($validator->fails()){
            return response(
                [
                    'status' => 1,
                    'data' => $validator->errors()->all(),
                    'msg' => 'error'
                ]
            );
        }*/

        //random user - pois não se sabe os ids dos users, logo quando se tiver uma interface gráfica isto deixa de fazer sentido
        $data['user_id'] = Auth::user()->id;

        //guardar a imagem e o seu path
        //$path = $request->file('image')->store('Article_Images');
        //$data['image'] = $path;

        $article =Article::create($data);

        return response(
            [
                'status' => 200,
                'data' => $article,
                'msg' => 'Success! Article created.'
            ]
        );
    }

    /**
     * @OA\Get(
     *      path="/article/{id}",
     *      operationId="showArticle",
     *      tags={"Article"},
     *      summary="Returns an article giving its id",
     *      description="Returns an article giving its id",
     *      @OA\Response(
     *          response=200,
     *          description="Operação com sucesso"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Article id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Response(response=400, description="Operação sem sucesso"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Shows a specific article
     */

    public function show(Article $article)
    {
        //
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/article/{id}",
     *      operationId="updateArticle",
     *      tags={"Article"},
     *      summary="Updates an article",
     *      description="Updates an article",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Article id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Article's title",
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="Article's description",
     *                     property="description",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="Article's image",
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *                 @OA\Property(
     *                     description="Article's user",
     *                     property="user_id",
     *                     type="integer",
     *                 ),
     *                 required={"title", "description", "image", "user_id"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Updates an article
     */
    public function update(ArticleUpdateRequest $request, Article $article)
    {
        //
        //FORMA FEITA EM AULA
        $data = $request->only(['title', 'description', 'image', 'user_id']);

        //handlign feito em ArticleUpdateRequest
        /*        $validator = Validator::make($data, [
            'title' => 'required|unique:articles',
            'description' => 'required',
            'image' => 'required',
            'user_id' => 'required'
        ]
        );

        if($validator->fails()){
            return response(
                [
                    'status' => 1,
                    'data' => $validator->errors()->all(),
                    'msg' => 'error'
                ],
                400
            );
        }*/

        $article->title = $data['title'];
        $article->description = $data['description'];
        $article->image = $data['image'];
        $article->user_id = $data['user_id'];
        $article->save();

        return response(
            [
                'status' => 200,
                'data' => $article,
                'msg' => 'Operação com sucesso'
            ]
        );
    }

    /**
     * @OA\Delete(
     *      path="/article/{id}",
     *      operationId="deleteArticle",
     *      tags={"Article"},
     *      summary="Deletes an article giving its id",
     *      description="Deletes an article giving its id",
     *      @OA\Response(
     *          response=200,
     *          description="Operação com sucesso"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Article id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Response(response=400, description="Operação sem sucesso"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     * Deletes an article
     */
    public function destroy(Article $article)
    {
        //
        $article->delete();

        return "artigo apagado";
    }

    /**
     * @OA\Get(
     *      path="/userarticle",
     *      operationId="getUsersandArticlesList",
     *      tags={"User"},
     *      summary="Get list of articles with users info",
     *      description="Returns list of all articles, its details and its user info",
     *      @OA\Response(
     *          response=200,
     *          description="Success"
     *       ),
     *       @OA\Response(response=400, description="Unsuccess"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of all articles, its details and its user info
     */
    public function getArticleAndUser(){
        //tentativa que não estava a dar
        //$articles = Article::with('user_id')->get();

        //alternativa
        return DB::table('articles')
            ->join('users', 'articles.user_id', '=', 'users.id')
            ->select('articles.id', 'articles.title', 'articles.description', 'articles.image', 'articles.user_id', 'users.name', 'users.email')
            ->get();
    }
}
