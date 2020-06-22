<?php

namespace App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CatalogModel;
class CatalogController extends Controller
{
	public function cataloglist(){
		$res=CatalogModel::get();
		dump($res);
	}

}
