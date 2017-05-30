<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Shop\ShopRepositoryInterface;


Class EmployeeService {

    protected $responseCode;
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->responseCode         = config('response_code');
        $this->employeeRepository       = $employeeRepository;
    }

    public function getEmployeeList($param)
    {
        if (is_numeric($param['emp_name_phone'])) {
            $param['phone_no'] = $param['emp_name_phone'];
        } else {
            $param['emp_name'] = $param['emp_name_phone'];
        }
        $storeRepository =  app(ShopRepositoryInterface::class);
        $storeList = $storeRepository->getStoreList();
        $newStoreData = [];
        foreach ($storeList as $v){
            $newStoreData[$v['shop_id']] = $v['shop_name'];
        }
        $data =  $this->employeeRepository->getEmployeeList($param);
        foreach ($data['data'] as &$v) {
            $v["shop_name"] = $newStoreData[$v["shop_id"]] ?? "总部";
        }
        return $data;
    }

    public function addEmployee($param)
    {
        $employeeData = $param;
        $data =  $this->employeeRepository->addEmployee($employeeData);
        return $data;
    }


}