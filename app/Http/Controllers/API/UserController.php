<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $created_user = User::create($request->validated());

        $token = $created_user->createToken('myapptoken')->plainTextToken;

        $responce = [
            'error'     => null,
            'result'    => new UserResource($created_user),
            'token'     => $token,
        ];

        return response($responce, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user, $id)
    {
        $authId = $request->user()->id;

        if ($authId !== +$id) {
            return response([
                'errors' => ['name' => ['"Data cannot be updated"']],
            ], 401);
        }

        $user = User::find($id);
        $user->birthday = Carbon::createFromFormat('Y-m-d', $request->birthday)->format('Y-m-d');
        $user->save();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
