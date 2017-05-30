<?php

namespace App\Http\Controllers;


class ConfigController extends Controller
{
    public function getConfig()
    {
        $result =  config('global');
        return $this->success($result);
    }

}
