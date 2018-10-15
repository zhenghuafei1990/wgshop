<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Goods;
use App\Model\Admin\Cate;
use DB;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         //获取商品图片
         $res=DB::table('goodspicture')->first();
        //多条件查询
        $rs = Goods::orderBy('id','asc')
        ->where(function($query) use($request){
            //检测关键字
            $gname = $request->input('gname');
            $addtime = $request->input('addtime');

            //如果用户名不为空
            if(!empty($gname)) {
                $query->where('gname','like','%'.$gname.'%');
            }
            //如果权限不为空
            //?单纯的搜索权限 怎么解决?
            if(!empty($addtime)) {
                $query->where('addtime','like','%'.$addtime.'%');
            }

        })
        ->paginate($request->input('num', 10));

            
        return view('admin/goods/index',[
            'title'=>'商品列表页',
            'res'  =>$res,
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
        $rs=Cate::select(DB::raw('*,concat(path,tid) as paths'))->orderBy('paths')->get();
        foreach($rs as $k=>$v){
            $n = substr_count($v->path,',')-1;
            $v->tname = str_repeat('&nbsp;',$n*8).'|--'.$v->tname;
        }
        return view('admin\goods\add',[
            'title'=>'商品的添加页面',
            'rs'=>$rs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        //1.表单验证
        $this->validate($request, [
             'gname' => 'required|regex:/[\x{4e00}-\x{9fa5}]+/u',
             'price' => 'required|integer',
             'stock' => 'required|regex:/^[1-9]\d*$/'
        ],[
             'gname.required'=>'商品名称不能为空',
             'price.required'=>'价格不能为空',
             'stock.required'=>'库存不能为空',
             'gname.regex'=>'商品名称字数不能少于5位多于20位',            
             'price.integer'=>'价格格式不正确',
             'stock.regex'=>'库存格式不正确'
        ]);*/
       //获取提交过来的数据
        $rs = $request->except('_token','gpic');
        $data = Goods::create($rs);

        $id = $data->id;
        $gd = $data::find($id);
        //处理图片
        if($request->hasFile('gpic')){
            $files = $request->file('gpic');

            $gm = [];
            foreach($files as $k=>$v){
                $info = [];
                //随机生成文件名
                $gname = time().mt_rand(1111,9999);
                //获取文件后缀
                $suffix = $v->getClientOriginalExtension();
                //将文件拼接后移入到upload/goods文件夹下  
                $v->move('/upload/goods/',$gname.'.'.$suffix);

                $info['gpic'] = '/upload/goods/'.$gname.'.'.$suffix;
                $gm[] = $info;
            }
        }
        //关联模型
        
        try{
            $cds = $gd->gimgs()->createMany($gm);
            if($cds){
                return redirect('/admin/goods')->with('success','添加成功');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
