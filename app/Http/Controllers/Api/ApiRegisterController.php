<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiRegisterController extends Controller
{
    public function register(Request $request):JsonResponse
    {   
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required|string|max:100',
            'nama_usaha' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:penggunas',
            'password' => 'required|min:6',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'invalid'=>$validator->getMessageBag()
            ],422);
        }

        try {
            $pengguna = Pengguna::create([
                'nama_pengguna' => $request->nama_pengguna,
                'nama_usaha' => $request->nama_usaha,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = $pengguna->createToken($pengguna->email)->plainTextToken;
    
            return response()->json([
                'data'=>[
                    'token' => $token,
                    'user' => [
                        'id'=>$pengguna->id,
                        'email'=>$pengguna->email,
                        'nama_pengguna'=>$pengguna->nama_pengguna,
                        'nama_usaha'=>$pengguna->nama_usaha,
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
