<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use App\UserType;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Auth;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class UserController extends Controller
{

    public function __contruct(){
        $this->middleware('auth:api');
    }

    public function getAuthUser(){
        return Auth::user();
    }

    /**
     * @OA\Get(
     *      path="/user",
     *      operationId="getUsersList",
     *      tags={"User"},
     *      summary="Get list of users",
     *      description="Returns list of all users and its details",
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
     * Returns all users
     */
    public function index()
    {
        //
        return User::all();
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
     *      path="/user",
     *      operationId="storeUser",
     *      tags={"User"},
     *      summary="Creates a new user",
     *      description="Creates a new user",
     *      @OA\Response(
     *          response=200,
     *          description="Success! User created."
     *       ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="User's name",
     *                     property="name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="User's email",
     *                     property="email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="User's password",
     *                     property="password",
     *                     type="string",
     *                 ),
     *                 required={"name", "email", "password"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=422, description="Erro de validação"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Creates a new user
     */
    public function store(UserStoreRequest $request)
    {
        //
        $data = $request->only(['name','email','password']);

        //a lógica de handling de erros vai ser feita à semelhança do que aconteceu com update

        $data['password'] = bcrypt($data['password']);
        $user_type = UserType::pluck('id')->toArray();
        $data['usertype_id'] = array_rand($user_type);
        $user = User::create($data);

        return response(
            [
                'status' => 0,
                'data' => $user,
                'msg' => 'ok'
            ],
            200
        );
    }

    /**
     * @OA\Get(
     *      path="/user/{id}",
     *      operationId="showUser",
     *      tags={"User"},
     *      summary="Returns an user giving its id",
     *      description="Returns an user giving its id",
     *      @OA\Response(
     *          response=200,
     *          description="Operação com sucesso"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
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
     * Shows a specific user
     */
    public function show(User $user)
    {
        //
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/user/{id}",
     *      operationId="updateUser",
     *      tags={"User"},
     *      summary="Updates an user giving its id",
     *      description="Updates an user giving its id",
     *      @OA\Response(
     *          response=200,
     *          description="Operação com sucesso"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
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
     *                     description="User's name",
     *                     property="name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="User's email",
     *                     property="email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     description="User's password",
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="User's type",
     *                     property="usertype_id",
     *                     type="integer",
     *                 ),
     *                 required={"name", "email", "password", "usertype_id"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=422, description="Erro de validação"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Updates an user
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        //
//        $user->name       = Input::get('name');
//        $user->email      = Input::get('email');
//        $user->save();

        //FORMA FEITA EM AULA
        $data = $request->only(['name', 'email', 'password', 'usertype_id']);

        //por forma a minimizar o código escrito
        //php artisan make:request UserUpdateRequest
        //cria-se um requester
        /*$validator = Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ],
            //para definir erros noutra língua ou personalizados
            [
                'name.required' => 'O campo nome é obrigatório'
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
            //$validator->errors()->all();
        }*/

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->usertype_id = $data['usertype_id'];
        $user->save();

        return response(
            [
                'status' => 0,
                'data' => $user,
                'msg' => 'Utilizador atualizado com sucesso'
            ],
            200
        );
    }

    /**
     * @OA\Delete(
     *      path="/user/{id}",
     *      operationId="deleteUser",
     *      tags={"User"},
     *      summary="Deletes an user giving its id",
     *      description="Deletes an user giving its id",
     *      @OA\Response(
     *          response=200,
     *          description="Utilizador apagado com sucesso"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="User id",
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
     * Deletes an user
     */
    public function destroy(User $user)
    {
        //
        //para usar o softdelete é necessário adicionar a class ao ficheiro User.php
        //e no ficheiro de migração
        //o que faz é adiconar um timestamp ao campo de deleted at
        //o user passa a ser dado como apagado
        $user->delete();

        return "Utilizador apagado";
    }
}
