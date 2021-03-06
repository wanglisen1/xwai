<?php

namespace App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\StudentModel;
use App\Model\ChapterModel;
use App\Model\CatalogModel;
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

	//验证用户是否过期
	public function session(){
		 session_start();
        if(empty($_SESSION["uid"])){
        	return $this->getBack('0','身份已过期，请重新登陆','');
        }
	}

	//微信登陆
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
    	 			session_start();
                    $_SESSION["uid"]=$data2['stu_openid'];
    	return $this->getBack('1','登陆成功',$res);
    }else{
    	return $this->getBack('2','登陆失败','');
    }
   

  }

  	//账号密码登陆
  public function stuloginpwd(Request $request){
  	 	$tel = $request->input('tel');
        $pwd = $request->input('pwd');
        $data2=StudentModel::where('stu_tel',$tel)->first();
         if(!empty($data2['stu_tel'])){
         	 if($data2['stu_pwd'] === $pwd) {
         	 	 
         	 		session_start();
                    $_SESSION["uid"]=$data2['stu_openid'];
                    $res2 = [
         	 		'openid' => $data2['stu_openid'],
         	 		'session_key' => $data2['stu_sess_key'],
         	 		'session' => $_SESSION["uid"]
         	 	];
         	 	return $this->getBack('1','登陆成功',$res2);
         	 }else{
         	 	return $this->getBack('3','密码错误','');
         	 }
         }else{
         	return $this->getBack('2','手机号不存在','');
         }
  }

  	//小问模块展示（家长端）
  public function stuxw(Request $request){
  		$this->session();
  		echo $_SESSION["uid"];
  		$res = StudentModel::where('stu_openid',$_SESSION["uid"])->first();
  		$uid = $res['stu_id'];
  		$res1 = ChapterModel::where('chap_stu',$uid)->first();
  		$ywsub = CatalogModel::whereIn('cata_id',$res1['chap_yw'])->get();
  		$sxsub = CatalogModel::whereIn('cata_id',$res1['chap_sx'])->get();
  		$kbsub = CatalogModel::whereIn('cata_id',$res1['chap_kb'])->get();
  		$pdsub = CatalogModel::whereIn('cata_id',$res1['chap_pd'])->get();
  		$subject = [
  			'ywsub' => $ywsub,
  			'sxsub' => $sxsub,
  			'kbsub' => $kbsub,
  			'pdsub' => $pdsub
  		];

  		//$ywseason = array_unique($ywsub['cata_season']);
  		print_r($ywsub);exit;
  }


}