<?php
namespace  app\admin\controller;
use think\Controller;
use think\Db;

/**
 * 手机号
 */
class Phone extends Common
{
	public function phoneAdd()
	{
		if(check()){
		    $data=input('post.');
		    if(empty($data)){
		        exit('非法操作此页面');
		    }
		    $data['status'] = 1;
		    $data['ctime']	= time();
		    $info=model('Phone')->allowField(true)->save($data);

		    if($info){
		        win('添加成功');
		    }else{
		        fail('添加失败');
		    }
		}else{
		    return view();
		}
	}

	public function phoneList()
	{
		if( request() -> isAjax() ){

		    $page=input('get.page');
		    if(empty($page)){
		        exit('非法操作此页面');
		    }
		    $limit=input('get.limit');
		    if(empty($limit)){
		        exit('非法操作此页面');
		    }
		    $feedback_info = model('Phone')->order('phone_id','desc')->page($page,$limit)->select();
		    $count=model('Phone')->count();
		    $info=['code'=>0,'msg'=>'','count'=>$count,'data'=>$feedback_info];
		    echo json_encode($info);
		    exit;

		}else{
		    return view();
		}	
	}

	public function phoneDel()
	{
		$phone_id = input('post.phone_id');
		if (empty($phone_id)) {
			fail('非法操作此页面');
		}
		$where=[
		    'phone_id'=>$phone_id
		];
		//删除
		$res=model('Phone')->where($where)->delete();
		if($res){
		    win('删除成功');
		}else{
		    fail('删除失败');
		}
	}

	public function phoneUpdateInfo()
	{
		$phone_id=input('get.phone_id');
		if(empty($phone_id)){
		    fail('非法操作此页面');
		}
		$where=[
		    'phone_id'=>$phone_id
		];
		$data=model('Phone')->where($where)->find();
		$this->assign('data',$data);
		return view();
	}

	public function phoneUpdate()
	{
		$data = input('post.');
		if (empty($data)) {
			fail('非法操作此页面');
		}
		$where = [
			'phone_id'	=> $data['phone_id']
		];

		$font = [
			'phone_name'	=> $data['phone_name'],
			'phone'	=> $data['phone'],
		];
		
		$reslut = Db::table('Phone')->where($where)->update($font);

		if ($reslut) {
		    win('修改成功');
		} else {
		    fail('修改失败');
		}
	}

}