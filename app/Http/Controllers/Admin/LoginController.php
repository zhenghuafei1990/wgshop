<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder; 
use App\Model\Admin\User;

class LoginController extends Controller
{
    public function login()
    {
    	return view('admin/login/login');
    }
    public function dologin(Request $request)
    {
    	//检测验证码
    	$code = session('code');
    	if($code !== $request->code)
    	{
    		return back()->with('error','验证码错误!');
    	}
    	//检测用户名
    	$users = User::where('username',$request->username)->first();
    	/*dd($users);*/
    	if(!$users)
    	{
    		return back()->with('error','用户名或密码错误');
    	}
    	//检测密码
    	if(decrypt($users->password) != $request->password)
    	{
    		return back()->with('error','用户名或密码错误');
    	}
    	//存储session信息
    	session(['uid'=>$users->uid]);
    	return redirect('/admin')->with('success','登录成功');
    }
    //生成验证码方法
	public function cap()
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(123, 203, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 90, $height = 35, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
       /* \Session::flash('code', $phrase);*/
       		Session(['code'=>$phrase]);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }
}
