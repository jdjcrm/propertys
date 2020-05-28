<?php
namespace  app\admin\controller;
use think\Controller;
use app\admin\model\Admin as AdminModel;
use think\Db;

/**
 * 系统管理
 */
class System extends Common
{
	public function systemAdd()
	{
		if(check()){
		    $data=input('post.');
		    if(empty($data)){
		        exit('非法操作此页面');
		    }
		    $data['status'] = 1;
		    $data['ctime']	= time();
		    $info=model('System')->allowField(true)->save($data);

		    if($info){
		        win('添加成功');
		    }else{
		        fail('添加失败');
		    }
		}else{
		    return view();
		}
	}

	public function systemUpload(){
	    // 获取表单上传文件 例如上传了001.jpg
	      $file = request()->file('file');
	        if(empty($file)){
	            exit('非法操作此页面');
	        }
	    //动到框架应用根目录/public/uploads/ 目录下
	     $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
	    if($info){
	        // 成功上传后 获取上传信息
	           echo json_encode(['font'=>'上传成功','code'=>1,'src'=>$info->getSaveName()]);
	    }else{
	        // 上传失败获取错误信息
	          fail($file->getError());
	    }
	}

	public function systemList()
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
		    $system_info = model('System')->order('system_id','desc')->page($page,$limit)->select();
		    $count=model('System')->count();
		    $info=['code'=>0,'msg'=>'','count'=>$count,'data'=>$system_info];
		    echo json_encode($info);
		    exit;

		}else{
		    return view();
		}
	}

	public function systemDel()
	{
		$system_id = input('post.system_id');
		if (empty($system_id)) {
			fail('非法操作此页面');
		}
		$where=[
		    'system_id'=>$system_id
		];
		//删除
		$res=model('System')->where($where)->delete();
		if($res){
		    win('删除成功');
		}else{
		    fail('删除失败');
		}
	}

	public function systemUpdateInfo()
	{
		$system_id = input('get.system_id');
		if (empty($system_id)) {
			fail('非法操作此页面');
		}
		$where = [
			'system_id'	=> $system_id
		];
		$data = model('System')->where($where)->find();
		$this->assign('data',$data);
		return view();
	}
	public function systemUpdate()
	{
		$data = input('post.');
		if (empty($data)) {
			fail('非法操作此页面');
		}

		$where = [
			'system_id'	=> $data['system_id']
		];

		$font = [
			'company_logo'	=> $data['company_logo'],
			'company_name'	=> $data['company_name'],
			'system_data'	=> $data['system_data'],
			'system_name'	=> $data['system_name']
		];
		
		$reslut = Db::table('system')->where($where)->update($font);

		if ($reslut) {
		    win('修改成功');
		} else {
		    fail('修改失败');
		}
	}
}