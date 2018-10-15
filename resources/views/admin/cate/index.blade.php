@extends('layout.admins')

@section('title',$title)

@section('content')
<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>
            <i class="icon-table">
            </i>
           {{$title}}
        </span>
    </div>
    <div class="mws-panel-body no-padding">
        <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
        	<form method="get" action="/admin/cate">
	            <div id="DataTables_Table_1_length" class="dataTables_length">
	                <label>
	                    显示
	                    <select size="1" name="num" aria-controls="DataTables_Table_1">
	                        <option value="5" @if($request->num == 5)selected="selected" @endif> 
	                            5
	                        </option>
	                        <option value="10"  @if($request->num == 10)selected="selected" @endif>
	                            10
	                        </option>
	                        <option value="20" @if($request->num == 20)selected="selected" @endif> 
	                            20
	                        </option>
	                    </select>
	                    条数据
	                </label>
	            </div>
	            <div class="dataTables_filter" id="DataTables_Table_1_filter">
	                <label>
	                    分类名:
	                    <input aria-controls="DataTables_Table_1"  name="tname" type="text" value="{{$request->tname}}" />	                    
	                </label>
	                <button class="btn btn-info">搜索</button>
	            </div>
        	</form>
            <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1"
            aria-describedby="DataTables_Table_1_info" style="text-align:center;">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 60px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                            ID
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 251.2px;" aria-label="Browser: activate to sort column ascending">
                            分类名
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 234.2px;" aria-label="Platform(s): activate to sort column ascending">
                            父级名
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 160.2px;" aria-label="Engine version: activate to sort column ascending">
                            路径
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 118px;" aria-label="CSS grade: activate to sort column ascending">
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                	@foreach($rs as $k=>$v)
                    <tr class="@if($k % 2==0)odd @else even @endif">
                        <td class="">
                            {{$v->tid}}
                        </td>
                        <td class=" " style="text-align:left;">
                            &nbsp;&nbsp;{{$v->tname}}
                        </td>
                        <td class=" ">
                           {{catename($v->pid)}}
                        </td>
                        <td class=" ">
                           {{$v->path}}  		
                        </td>
                        <td class=" ">
                            <a class="btn btn-primary" href="/admin/cate/{{$v->tid}}/edit">修改</a>
                            <form action="/admin/cate/{{$v->tid}}" method="post" style="display: inline;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button class="btn btn-danger">删除</button>
                                
                            </form>                            
                        </td>
                    </tr>
                    @endforeach                                            
                </tbody>
            </table>
            <div class="dataTables_info" id="DataTables_Table_1_info">
            </div>
            <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate">
            	<style type="text/css">
            		.pagination li{
            			float: left;
					    height: 20px;
					    padding: 0 10px;
					    display: block;
					    font-size: 12px;
					    line-height: 20px;
					    text-align: center;
					    cursor: pointer;
					    outline: none;
					    background-color: #444444;
					    color: #fff;
					    text-decoration: none;
					    border-right: 1px solid #232323;
					    border-left: 1px solid #666666;
					    border-right: 1px solid rgba(0, 0, 0, 0.5);
					    border-left: 1px solid rgba(255, 255, 255, 0.15);
					    -webkit-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.5), inset 0px 1px 0px rgba(255, 255, 255, 0.15);
					    -moz-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.5), inset 0px 1px 0px rgba(255, 255, 255, 0.15);
					    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.5), inset 0px 1px 0px rgba(255, 255, 255, 0.15);
            		}
            		.pagination .active{
            			    background-color: #c5d52b;
            			    color: #323232;
    						border: none;
    						background-image: none;
    						box-shadow: inset 0px 0px 4px rgba(0, 0, 0, 0.25);
            		}
            		.pagination li a{
            			color:white;
            		}
            		.pagination .disabled{
            			    color: #666666;
   						    cursor: default;
            		}
            		.pagination{
            			margin:0px;
            		}
            	</style>
            	{{$rs->appends($request->all())->links()}}                
            </div>
        </div>
    </div>
</div>


@stop

@section('js')
<script type="text/javascript">
    setTimeout(function(){
        $('.mws-form-message').slideUp();
    },2000);
</script>
@stop