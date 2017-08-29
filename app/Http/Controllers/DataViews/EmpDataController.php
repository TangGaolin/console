<?php

namespace App\Http\Controllers\DataViews;
use App\Http\Controllers\Controller;
use App\Services\EmpDataViewsService;
use Request;


class EmpDataController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $dataViewsService;
    public function __construct(EmpDataViewsService $dataViewsService)
    {
        $this->dataViewsService = $dataViewsService;
    }

    //员工当月
    public function getEmpDataView()
    {
        $param = [
            "emp_id"  => Request::input('emp_id'),
            "year"    => Request::input('year'),
            "mouth"   => Request::input('mouth'),
        ];

        $rule = [
            'emp_id'  => "required|integer",
            'year'    => "nullable|integer",
            'mouth'   => "nullable|integer",
        ];
        $this->validation($param, $rule);

        return $this->dataViewsService->getEmpDataView($param);
    }





}
