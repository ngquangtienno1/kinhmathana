<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
class AuthenticationController extends Controller
{
    public function login(){
        return view('admin.login.login');
    }
    public function postLogin(UserLoginRequest $request){
        // $request->validate([
        //     'email' => 'required|email|exists:users,email',
        //     'password' => 'required|string|min:8',
        // ], [
        //     'email.required' => 'Không được để trống email',
        //     'email.email' => 'Email không đúng định dạng ',
        //     'email.exists'=> 'Email chưa được đăng ký',
        //     'password.required'=>'Không được để trống password',
        //     'password.string'=> 'Password không phải là chuỗi',
        //     'password.min'=> 'Password phải trên 8 ký tự'
        // ]);
        $dataUserLogin = [
            'email' =>$request->email,
            'password'=>$request->password
        ];
        $remember = $request->has('remember');

        if(Auth::attempt($dataUserLogin, $remember)){
            //Logout het tai khoan khac
            Session::where('user_id', Auth::id())->delete();
            // Tao phien dang nhap moi
            session()->put('user_id', Auth::id());
            if(Auth::user()->role == '1'){
                return redirect()->route('products.list-products')->with([
                    'message' => 'Dang nhap thanh cong'
                ]);
            }else{
                echo "dang";
            }
          
        }else{
            return redirect()->back()->with([
                'message' => 'Email hoac password khong dung'
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with([
            'message' => 'Dang xuat thanh cong'
        ]);
    }

    public function register(){
        return view('client.register');
    }

    public function postRegister(Request $request){
        $check = User::where('email', $request->email)->exists();
        if($check){
            return redirect()->back()->with([
                'message' => 'Tai khoan email da ton tai'
            ]);
        }else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];
            $newUser = User::create($data);
            return redirect()->route('login')->with([
                'message' => 'Dang ky thanh cong. Vui long dang nhap'
            ]);
        }
    }
}
