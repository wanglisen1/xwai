<?php

namespace App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\StudentModel;
class StudentController extends Controller
{
	//返回提示信息
	public function getBack($code='',$msg='',$date=''){
    $data=[
        'code'=>$code,
        'msg'=>$msg,
        'date'=>$date
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

    return $res['data'];
  }





}