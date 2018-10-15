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
    	<form class="mws-form" action="/admin/user" method="post" enctype="multipart/form-data">
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label class="mws-form-label">用户名</label>
    				<div class="mws-form-item">
    					<input class="small" type="text" name="username">
    				</div>
    			</div>
    			<div class="mws-form-row">
    				<label class="mws-form-label">密码</label>
    				<div class="mws-form-item">
    					<input class="small" type="password" name="password">
    				</div>
    			</div>
    			<div class="mws-form-row">
    				<label class="mws-form-label">确认密码</label>
    				<div class="mws-form-item">
    					<input class="small" type="password" name="repass">
    				</div>
    			</div>
    			<div class="mws-form-row">
                    	<label class="mws-form-label">头像</label>
                    	<div class="mws-form-item">
                        	<div class="fileinput-holder" style="position: relative;"><input style="position: absolute; top: 0px; right: 0px; margin: 0px; cursor: pointer; font-size: 999px; opacity: 0; z-index: 999;" type="file" name="profile" ></div>
                        </div>
                </div>                   		
    			<div class="mws-form-row">
    				<label class="mws-form-label">权限</label>
    				<div class="mws-form-item clearfix">
    					<ul class="mws-form-list inline">
    						<li> <label><input type="radio" value="0" name="auth">超级管理员</label></li>
    						<li><label><input type="radio" value="1" name="auth" checked="checked"> 普通管理员</label></li>               			
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
		$('input').focus(function(){
			$('.mws-form-message').slideUp();
		}); 
			
		
		/*setTimeout(function(){
			$('.mws-form-message').fadeOut();
		},3000);*/
	</script>
@stop