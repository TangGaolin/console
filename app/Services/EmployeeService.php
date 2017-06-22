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
use Excel;


Class EmployeeService
{

    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getEmployeeList($param)
    {
        if (is_numeric($param['emp_name_phone'])) {
            $param['phone_no'] = $param['emp_name_phone'];
        } else {
            $param['emp_name'] = $param['emp_name_phone'];
        }

        $storeRepository = app(ShopRepositoryInterface::class);
        $storeList = $storeRepository->getStoreList();
        $newStoreData = [];
        foreach ($storeList as $v) {
            $newStoreData[$v['shop_id']] = $v['shop_name'];
        }
        $data = $this->employeeRepository->getEmployeeList($param);
        foreach ($data['data'] as &$v) {
            $v["shop_name"] = $newStoreData[$v["shop_id"]] ?? "总部";
        }
        return $data;
    }

    public function addEmployee($param)
    {
        $employeeData = $param;

        $res = $this->employeeRepository->addEmployee($employeeData);
        if (!$res) {
            return [
                'statusCode' => config('response_code.STATUSCODE_USERERROR'),
                'msg' => "手机号码已经存在",
                'success' => false
            ];
        }
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg' => config('response_code.MSG_OK'),
            'success' => true
        ];
    }

    public function updateEmployee($param)
    {

        $employeeData = $param;
        $res = $this->employeeRepository->updateEmployee($employeeData);
        if (!$res) {
            return [
                'statusCode' => config('response_code.STATUSCODE_USERERROR'),
                'msg' => "手机号码已经存在",
                'success' => false
            ];
        }
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg' => config('response_code.MSG_OK'),
            'success' => true
        ];
    }

    public function removeEmployee($param)
    {
        $updateData = [
            "emp_id" => $param['emp_id'],
            "status" => -1
        ];
        $this->employeeRepository->removeEmployee($updateData);
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg' => config('response_code.MSG_OK'),
            'success' => true
        ];
    }

    public function importEmployee($param)
    {

        $shopRepository = app(ShopRepositoryInterface::class);
        $shopData = $shopRepository->getStoreList();
        $converShopData = [];
        foreach ($shopData as $v){
            $converShopData[$v['shop_name']] = $v['shop_id'];
        }
        $data = Excel::load($param['file']->getPathName(), function ($reader) {
            return $reader;
        });
        $employeeData = $data->getSheet(0)->toArray();
        unset($employeeData[0]);

        foreach ($employeeData as $v) {
            if(!isset($converShopData[$v[0]])){
                continue;
            }
            $tmpEmployeeData['shop_id']  = $converShopData[$v['0']];
            $tmpEmployeeData['emp_name'] =  $v[1];
            $tmpEmployeeData['job']      =  $v[2];
            $tmpEmployeeData['phone_no'] =  $v[3];
            $tmpEmployeeData['sex']      =  10;

            $res = $this->employeeRepository->addEmployee($tmpEmployeeData);
            if(!$res){
                $this->employeeRepository->updateEmployee($tmpEmployeeData);
            }
        }
    }


}