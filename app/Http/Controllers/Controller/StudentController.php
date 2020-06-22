<?php

namespace App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\StudentModel;
class StudentController extends Controller
{
	//返回提示信息
	public function getBack($code='',$msg='',$data1=''){
    $data=[
        'code'=>$code,
        'msg'=>$msg,
        'data1'=>$data1
    ];
    return json_encode($data);
}

	public function stucode(Request $request){

    $code = $_GET['code'];
   
    //配置appid
    $appid = !empty($_GET['appid']) ? $_GET['appid'] : 'wx69cbb9e821210abb ';
    //配置appscret
    $secret = !empty($_GET['secret']) ? $_GET['secret'] : '19cddecc89314ab3b31f9976cedc41f6';

    if(empty($code)||empty($appid)||empty($secret)){
        return $this->getBack('0','非法请求','');
    }

    //api接口
    $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $api);
    $res = json_decode(curl_exec($curl),true);
    curl_close($curl);
    
    $openid = $res['openid'];
    $res1 = StudentModel::where('stu_openid',$openid)->first();
    if(!empty($res1)){
    	return $this->getBack('1','登陆成功',$res);
    }else{
    	return $this->getBack('2','登陆失败','');
    }
   

  }

  public function styloginpwd(Request $request){
  	 	$tel = $request->input('tel');
        $password = $request->input('pwd');
        $data1=StudentModel::where('tel',$tel)->first();
         if(!empty($data['tel'])){
         	 if($data['password'] === $password) {
         	 	$res2 = [
         	 		'openid' => $data1['stu_openid'],
         	 		'stu_sess_key' => $data1['Fjt8MmueXV3d8cBKc77vYA==']
         	 	]; 
         	 	return $this->getBack('1','登陆成功',$res2);
         	 }else{
         	 	return $this->getBack('3','密码错误','');
         	 }
         }else{
         	return $this->getBack('2','手机号不存在','');
         }
  }





}