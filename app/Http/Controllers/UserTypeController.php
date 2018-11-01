<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTypeStoreRequest;
use App\Http\Requests\UserTypeUpdateRequest;
use App\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    /**
     * @OA\Get(
     *      path="/usertype",
     *      operationId="getUserTypeList",
     *      tags={"UserType"},
     *      summary="Get list of all user types",
     *      description="Returns list of all user types",
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
     * Returns all user types
     */
    public function index()
    {
        //
        return UserType::all();
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
     *      path="/usertype",
     *      operationId="storeUserType",
     *      tags={"UserType"},
     *      summary="Creates a new user type",
     *      description="Creates a user type",
     *      @OA\Response(
     *          response=200,
     *          description="Success! User type created."
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
     *                 required={"title"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=422, description="Erro de validação"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Creates a new user type
     */
    public function store(UserTypeStoreRequest $request)
    {
        //
        $data = $request->only(['title']);

        $user_type = UserType::create($data);

        return response(
            [
                'status' => 200,
                'data' => $user_type,
                'msg' => 'Success! User type created.'
            ]
        );
    }

    /**
     * @OA\Get(
     *      path="/usertype/{id}",
     *      operationId="showUserType",
     *      tags={"UserType"},
     *      summary="Returns an user type giving its id",
     *      description="Returns an user type giving its id",
     *      @OA\Response(
     *          response=200,
     *          description="Operação com sucesso"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="User type id",
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
    public function show(UserType $userType)
    {
        //
        return $userType;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function edit(UserType $userType)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/usertype/{id}",
     *      operationId="updateUserType",
     *      tags={"UserType"},
     *      summary="Updates a user type",
     *      description="Updates a user type",
     *      @OA\Response(
     *          response=200,
     *          description="Operação com sucesso"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="UserType id",
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
     *                     description="User type's title",
     *                     property="title",
     *                     type="string",
     *                 ),
     *                 required={"title"}
     *             )
     *         )
     *     ),
     *       @OA\Response(response=422, description="Erro de validação"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Creates a new user type
     */
    public function update(UserTypeUpdateRequest $request, UserType $userType)
    {
        //
        $data = $request->only(['title']);
        $userType->title = $data['title'];
        $userType->save();

        return response(
            [
                'status' => 200,
                'data' => $userType,
                'msg' => 'Operação com sucesso'
            ]
        );
    }

    /**
     * @OA\Delete(
     *      path="/usertype/{id}",
     *      operationId="deleteUserType",
     *      tags={"UserType"},
     *      summary="Deletes an user type giving its id",
     *      description="Deletes an user type giving its id",
     *      @OA\Response(
     *          response=200,
     *          description="Operação com sucesso"
     *       ),
     *     @OA\Parameter(
     *          name="id",
     *          description="User type id",
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
     * Deletes an user type
     */
    public function destroy(UserType $userType)
    {
        //
        $userType->delete();
        return "Tipo de user apagado";
    }
}
