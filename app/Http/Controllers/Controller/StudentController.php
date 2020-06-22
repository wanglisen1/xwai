<?php

namespace App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\StudentModel;
class StudentController extends Controller
{
	public function stucode(Request $request){
		$code = $_GET['code'];//小程序传来的code值
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid="wx69cbb9e821210abb"&secret="19cddecc89314ab3b31f9976cedc41f6"&js_code=' . $code . '&grant_type=authorization_code';
        //yourAppid为开发者appid.appSecret为开发者的appsecret,都可以从微信公众平台获取；
        $info = file_get_contents($url);//发送HTTPs请求并获取返回的数据，推荐使用curl
        $json = json_decode($info);//对json数据解码
        $arr = get_object_vars($json);
        //dump($arr);die;
        $openid = $arr['openid'];
		return $openid;
	}
}