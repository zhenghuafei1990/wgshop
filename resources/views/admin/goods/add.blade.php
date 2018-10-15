@extends('layout.admins')

@section('title',$title)

@section('content')

<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span>{{$title}}</span>
    </div>               
    <div class="mws-panel-body no-padding">
    	<!-- @if(session('success'))
    		<div class="mws-form-message success">
        		{{session('success')}}
    		</div>
    	@endif -->

    	@if (count($errors) > 0)
		    <div class="mws-form-message error">
		    	<b>错误信息:</b>
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li><b>{{ $error }}</b></li>
		            @endforeach
		        </ul>
		    </div>
		@endif
    	<form class="mws-form" action="/admin/goods" method="post" enctype="multipart/form-data">
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
        				<label class="mws-form-label">商品分类</label>
        				<div class="mws-form-item">
        					<select class="small" name="tid">
        						<option value="0">--请选择分类--</option> 
        						@foreach($rs as $k=>$v)
        						<option value="{{$v->tid}}">{{$v->tname}}</option> 
        						@endforeach    
        					</select>
        				</div>
        		</div> 
    			<div class="mws-form-row">
    				<label class="mws-form-label">商品名称</label>
    				<div class="mws-form-item">
    					<input class="small" type="text" name="gname">
    				</div>
    			</div>
    			<div class="mws-form-row">
    				<label class="mws-form-label">价格</label>
    				<div class="mws-form-item">
    					<input class="small" type="text" name="price">
    				</div>
    			</div>
    			<div class="mws-form-row">
    				<label class="mws-form-label">库存</label>
    				<div class="mws-form-item">
    					<input class="small" type="text" name="stock">
    				</div>
    			</div>
    			<div class="mws-form-row">
                    	<label class="mws-form-label">商品图片</label>
                    	<div class="mws-form-item">
                        	<div class="fileinput-holder" style="position: relative;">
                        		<input style="position: absolute; top: 0px; right: 0px; margin: 0px; cursor: pointer; font-size: 999px; opacity: 0; z-index: 999;" type="file" name="gpic[]" multiple style="width:300px;">
                        	</div>
                        </div>
                </div> 
                <div class="mws-form-row">
    				<label class="mws-form-label">添加时间</label>
    				<div class="mws-form-item">
    					<input class="small" type="text" name="addtime" value="{{date('Y年m月d日 H时i分s秒')}}">
    				</div>
    			</div>
    			 <div class="mws-form-row">
    				<label class="mws-form-label">商品详情</label>
    				<div class="mws-form-item">   				
    				<script id="editor" name="content" type="text/plain" style="width:850px;height:400px;"></script>
    				</div>
    			</div>                                 		
    			<div class="mws-form-row">
    				<label class="mws-form-label">状态</label>
    				<div class="mws-form-item clearfix">
    					<ul class="mws-form-list inline">
    						<li> <label><input type="radio" value="0" name="status" checked="checked">上架</label></li>
    						<li><label><input type="radio" value="1" name="status" >下架</label></li>               			
    					</ul>
    				</div>
    			</div>  				
    		</div>
    		<div class="mws-button-row">
    			{{csrf_field()}}
    			<input value="提交" class="btn btn-primary" type="submit">                    	
    		</div>
    	</form>
    </div>    	
</div>       
@stop
@section('js')

	<script type="text/javascript">
		//实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    	var ue = UE.getEditor('editor');
		$('input').focus(function(){
			$('.mws-form-message').slideUp();
		}); 
			
		
		/*setTimeout(function(){
			$('.mws-form-message').fadeOut();
		},3000);*/
	</script>
@stop
