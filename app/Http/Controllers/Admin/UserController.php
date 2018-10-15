<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Hash;
use App\Model\Admin\User;
use Illuminate\Contracts\Encryption\DecryptException;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //单条件查询
        /*$uname = $request->input('username');
        $num = $request->input('num',10);
        $rs = User::where('username','like','%'.$uname.'%')->paginate($num);*/

        //多条件查询
             $rs = User::orderBy('uid','asc')
        ->where(function($query) use($request){
            //检测关键字
            $username = $request->input('username');
            $auth = $request->input('auth');

            //如果用户名不为空
            if(!empty($username)) {
                $query->where('username','like','%'.$username.'%');
            }
            //如果权限不为空
            //?单纯的搜索权限 怎么解决?
            if(!empty($auth)) {
                $query->where('auth','=',$auth);
            }

        })
        ->paginate($request->input('num', 10));
            
        return view('admin/user/index',[
            'title'=>'用户列表页',
            'rs'   =>$rs,
            'request'=>$request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //显示表单
        return view('admin/user/add',['title'=>'用户的添加页面']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $res = $request->except('_token','profile','repass');

        //文件上传
        if($request->hasFile('profile')){
            //自定义名字
            $name = time().rand(1111,9999);
            //获取后缀
            $suffix = $request->file('profile')->getClientOriginalExtension();
            //移动
            $request->file('profile')->move('upload',$name.'.'.$suffix);
        }
        $res['profile']='/upload/'.$name.'.'.$suffix;
        //加密
        // $res['password']=Hash::make($request->input('password'));
        $res['password']=encrypt($request->input('password'));
        //往数据库里面添加
    
        try{
            $rs = User::create($res);
            if($rs){
                return redirect('/admin/user')->with('success','添加成功');
            }
        }catch(\Exception $e){
            return back()->with('error','添加失败');
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
        //根据id获取数据
        $res = User::where('uid',$id)->first();
        //dd(decrypt($res['password']));

        try {
           $res['password']=decrypt($res['password']);
        } catch (DecryptException $e) {
        //
        }
        // $res['password']=decrypt($res['password']);
        return view('admin/user/edit',[
                    'title'=>'用户的修改页面',
                    'res'  =>$res,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        //获取数据
        $img =DB::table('users')->where('uid',$id)->get();
       //?unlink怎么删除
        $res = $request->except('_token','repass','_method');

         //文件上传
        if($request->hasFile('profile')){
            //自定义名字
            $name = time().rand(1111,9999);
            //获取后缀
            $suffix = $request->file('profile')->getClientOriginalExtension();
            //移动
            $request->file('profile')->move('upload',$name.'.'.$suffix);
            $res['profile']='/upload/'.$name.'.'.$suffix;
        }
        
         $res['password']=encrypt($request->input('password'));

        //往数据库里面添加
                
        try{
            $rs = User::where('uid',$id)->update($res);
            if($rs){
                return redirect('/admin/user')->with('success','修改成功');
            }
        }catch(\Exception $e){
            return back()->with('error','修改失败');
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
        try{
            $res = User::where('uid',$id)->delete();
            if($res){
                return redirect('/admin/user')->with('success','删除成功');
            }
        }catch(\Exception $e){
            return back()->with('error','添加失败');
        }
    }
}
