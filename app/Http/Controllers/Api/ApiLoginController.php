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
                'invalid'=>$validator->getMessageBag()
            ],422);
        }

        try {
            $cekEmail = Pengguna::where('email', $request->email)->first();
            if (!$cekEmail) {
                return response()->json(['failed' => 'Unauthorized'], 401);
            }
            $cekPassword = Hash::check($request->password, $cekEmail->password);
            if (!$cekPassword) {
                return response()->json(['failed' => 'Unauthorized'], 401);
            }
            $token = $cekEmail->createToken($cekEmail->email)->plainTextToken;
            return response()->json([
                'data'=>[
                    'token' => $token,
                    'user' => [
                        'id'=>$cekEmail->id,
                        'email'=>$cekEmail->email,
                        'nama_pengguna'=>$cekEmail->nama_pengguna,
                        'nama_usaha'=>$cekEmail->nama_usaha,
                    ]
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error'=>$th->getMessage()
            ],500);
        }
        
    }
}
