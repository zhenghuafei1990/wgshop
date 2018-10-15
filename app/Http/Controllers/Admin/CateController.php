<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Cate;
use DB;
class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rs=Cate::select(DB::raw('*,concat(path,tid) as paths'))->where('tname','like','%'.$request->input('tname').'%')->orderBy('paths')->paginate($request->input('num', 10));
        foreach($rs as $k=>$v){
            $n = substr_count($v->path,',')-1;
            $v->tname = str_repeat('&nbsp;',$n*8).'|--'.$v->tname;
        }
        return view('admin/cate/index',[
            'title'=>'分类列表',
            'rs'=>$rs,
            'request'=>$request
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rs = Cate::select(DB::raw('*,concat(path,tid) as paths'))->orderBy('paths')->get();
        foreach($rs as $k=>$v){
            $n = substr_count($v->path,',')-1;
            $v->tname = str_repeat('&nbsp;',$n*8).'|--'.$v->tname;
        }
        return view('admin/cate/add',[
            'title'=>'商品类别的添加页面',
            'rs' => $rs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //表单验证
        /*$this->validate($request, [
            'cate' => 'required',
        ],[
            'cate.require'=>'分类名不能为空',
        ]);*/

        //获取数据
        $rs = $request->except('_token');
        if($rs['pid']== '0'){
            $rs['path']='0,';
        }else{
            $data = Cate::where('tid',$rs['pid'])->first();
            $rs['path']=$data->path.$data->tid.',';
        } 
        try{
            $info=Cate::create($rs);
            if($info){
                return redirect('/admin/cate')->with('success','添加成功');
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
        $res = Cate::where('tid',$id)->first();
        //dd(decrypt($res['password']));
        $info = Cate::select(DB::raw('*,concat(path,tid) as paths'))->orderBy('paths')->get();
        foreach($info as $k=>$v){
            $n = substr_count($v->path,',')-1;
            $v->tname = str_repeat('&nbsp;',$n*8).'|--'.$v->tname;
        }
        return view('admin/cate/edit',[
                    'title'=>'分类的修改页面',
                    'rs'  =>$res,
                    'info'=>$info
        ]);

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
        $rs = $request->only('tname');
        try{
            $data = Cate::where('tid',$id)->update($rs);
            if($data){
                return redirect('admin/cate')->with('success','修改成功');
            }
        }catch(\Exception $e){
            return back()->with('error','添加失败');
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
            $res = Cate::where('tid',$id)->delete();
            if($res){
                return redirect('/admin/cate')->with('success','删除成功');
            }
        }catch(\Exception $e){
            return back()->with('error','添加失败');
        }
    }
}
