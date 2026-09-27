<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Yêu cầu: Api localhost:****/ 
    public function login(Request $request)
    {
        $userName = $request->input('userName');
        $password = $request->input('password'); // Đã mã hóa MD5/Base64 từ client

        // Tìm user khớp chính xác thông tin do mật khẩu không dùng Hash Bcrypt mặc định
        $user = User::where('UserName', $userName)
                    ->where('Password', $password)
                    ->first();

        if (!$user) {
            return response()->json(['error' => 'Tài khoản hoặc mật khẩu không đúng'], 401);
        }

        // Sinh JWT Token
        $token = JWTAuth::fromUser($user);

        // Lưu token vào bảng User theo yêu cầu
        $user->update(['Token' => $token]);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }

    // Yêu cầu: Api localhost:****/auth
    public function auth()
    {
        // Trả về thông tin user đang sở hữu token hợp lệ
        return response()->json(auth('api')->user());
    }

    // Bài thực hành số 1
    public function helloWorld()
    {
        return response()->json(['message' => 'Hello World']);
    }
}