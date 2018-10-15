@extends('layout.admins')

@section('title',$title)

@section('content')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>商品类别管理页面</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" action="/admin/cate/{{$rs->tid}}" method="post">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">分类名</label>
                        <div class="mws-form-item">
                            <input type="text" class="small" name="tname" value="{{$rs->tname}}">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">父级分类</label>
                        <div class="mws-form-item">
                            <select class="small" name="pid" disabled>
                                <option value="0">--请选择分类--</option>  
                                @foreach($info as $k=>$v)
                                @if($v->tid == $rs->pid)
                                    <option value="{{$v->tid}}" selected>{{$v->tname}}</option> 
                                @endif    
                                @endforeach                                 
                            </select>
                        </div>
                    </div> 
                    <div class="mws-form-row"></div> 
                    <div class="mws-button-row">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <input value="提交" class="btn btn-primary" type="submit">                        
                    </div>                  
            </form>
        </div>      
    </div>
@stop