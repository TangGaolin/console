<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use App\Services\AdminActionService;

use Request;


class AdminActionController extends Controller
{

    protected $adminActionService;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(AdminActionService $adminActionService)
    {
        $this->adminActionService = $adminActionService;
    }

    public function cancelOrderAction()
    {
        $param = [
            "order_id" => Request::input("order_id"),
        ];
        $rule = [
            "order_id" => "nullable|numeric"
        ];

        $this->validation($param, $rule);
        $param['aid'] = $this->getAid();
        return $this->adminActionService->cancelOrderAction($param);
    }


}
