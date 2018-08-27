<?php

namespace App\Library;

class ClassFactory{

	public static function model( $model ){
		$model_name = "\\App\\Models\\$model";
		return new $model_name();
	}

}
