<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Mail;
use App\Model\HomeUser;

class RegisterController extends Controller
{
    //前台邮箱注册页
    public function register()
    {
        return view('home.emailregister');
    }

    //    邮箱登录处理
    public function doRegister(Request $request)
    {
        $input = $request->except('_token');
//        dd($input);
        $input['user_pass'] = Crypt::encrypt($input['user_pass']);
        $input['email'] = $input['user_name'];
        $input['token'] = md5($input['email'].$input['user_pass'].'123');
        $input['expire'] = time()+3600*24;

        $user = HomeUser::create($input);

        if($user){

            Mail::send('email.active',['user'=>$user],function ($m) use ($user) {
//              $m->from('hello@app.com', 'Your Application');

                $m->to($user->email, $user->name)->subject('激活邮箱');
            });


            return redirect('login')->with('active','请先登录邮箱激活账号');
        }else{
            return redirect('emailregister');
        }

    }


    //注册账号邮箱激活
    public function active(Request $request){
        //找到要激活的用户，将用户的active字段改成1

        $user = HomeUser::findOrFail($request->userid);

        //验证token的有效性，保证链接是通过邮箱中的激活链接发送的
        if($request->token  != $user->token){
            return '当前链接非有效链接，请确保您是通过邮箱的激活链接来激活的';
        }
        //激活时间是否已经超时
        if(time() > $user->expire){
            return '激活链接已经超时，请重新注册';
        }

        $res = $user->update(['active'=>1]);
        //激活成功，跳转到登录页
        if($res){
            return redirect('login')->with('msg','账号激活成功');
        }else{
            return '邮箱激活失败，请检查激活链接，或者重新注册账号';
        }
    }
}
