<?php

namespace App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\StudentModel;
class StudentController extends Controller
{
	public function stucode(Request $request){
	$data = request()->post();

    $code = !empty($data['code']) ? $data['code'] : '';
    //配置appid
    $appid = !empty($data['appid']) ? $data['appid'] : 'wx69cbb9e821210abb ';
    //配置appscret
    $secret = !empty($data['secret']) ? $data['secret'] : '19cddecc89314ab3b31f9976cedc41f6';

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

    return $this->getBack('1','ok',$res);
}