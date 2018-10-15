<?php
	function catename($pid)
	{
		if($pid == '0'){
			return '顶级分类';
		}else{
			$rs = DB::table('type')->where('tid',$pid)->first();
			return $rs->tname;
		}
	}