<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiLoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message'=>'invalid',
                'data'=>$validator->getMessageBag()
            ],422);
        }

        try {
            // $cek = Auth::attempt([
            //     'email' => $request->email,
            //     'password' => $request->password
            // ]);
            // if (!$cek) {
            //     return response()->json(['message' => 'Email or password ar incorrect'], 401);
            // }
            // $user = Auth::user();

            $user = Pengguna::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'Email atau password yang anda masukan salah'], 401);
            }
            $cekPassword = Hash::check($request->password, $user->password);
            if (!$cekPassword) {
                return response()->json(['message' => 'Email atau password yang anda masukan salah'], 401);
            }
            $token = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                'message'=>'success',
                'data'=>[
                    'token' => $token,
                    'user' => [
                        'id'=>$user->id,
                        'email'=>$user->email,
                        'nama_pengguna'=>$user->nama_pengguna,
                        'nama_usaha'=>$user->nama_usaha,
                    ]
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ],500);
        }
        
    }
}
