<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputs = $request->only(['id', 'name', 'email']);

        try {
            $users = User::search($inputs)->orderBy('id', 'asc')->paginate(5);

            $users->appends($inputs);

            return response()->json($users);
            
        } catch (Exception $e) {
            \Log::info('Error searching user: '.$e);
            return response()->json([
                'errors' => 'Error searching user'
            ], 500);
        }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name'     => 'required|string',
                'email'    => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->all()
                ], 400);
            }

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]);

            return response()->json([
                'message' => 'User created correctly'
            ], 201);

        } catch (Exception $e) {
            \Log::info('Error storing user: '.$e);
            return response()->json([
                'errors' => 'Error storing user'
            ], 500);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            return response()->json([
                'message' => 'User updated correctly'
            ]);
            
        } catch (Exception $e) {
            \Log::info('Error updating user: '.$e);
            return response()->json([
                'errors' => 'Error updating user'
            ], 500);
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
        try {
            User::destroy($id);

            return response()->json([
                'message' => 'User deleted correctly'
            ]);
            
        } catch (Exception $e) {
            \Log::info('Error deleting user: '.$e);
            return response()->json([
                'errors' => 'Error deleting user'
            ], 500);
        }
    }
}
