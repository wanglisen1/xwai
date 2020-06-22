<?php

namespace App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\StudentModel;
class StudentController extends Controller
{
	public function stucode(Request $request){
        $code = $_GET['code'];//获取code
		$weixin =  file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=	wx69cbb9e821210abb&secret=19cddecc89314ab3b31f9976cedc41f6&code=".$code."&grant_type=authorization_code");//通过code换取网页授权access_token
			$jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
			$array = get_object_vars($jsondecode);//转换成数组
			$openid = $array['openid'];//输出openid
		return $openid;
		}
}