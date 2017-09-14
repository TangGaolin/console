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

    public function getServerEmpList($param)
    {
        $storeRepository = app(ShopRepositoryInterface::class);
        $storeList = $storeRepository->getStoreList();
        $newStoreData = [];
        foreach ($storeList as $v) {
            $newStoreData[$v['shop_id']] = $v['shop_name'];
        }
        //先获取所有跨店员工
        $server_all_emps = $this->employeeRepository->getEmployeeList(['is_server_all'=> 1,'limit' => 100]);
        //再获取不跨店的门店员工
        $param['is_server_all'] = 0;

        $data = $this->employeeRepository->getEmployeeList($param);
        $tmpServerAll = [];
        foreach ($server_all_emps['data'] as $v){
            if($v['shop_id'] == $param['shop_id']) {
                $data['data'][] = $v;
            }else{
                $v['emp_name'] = $v['emp_name'] . "(跨店)";
                $tmpServerAll[] = $v;
            }
        }
        $data['data'] = array_merge($data['data'], $tmpServerAll);
        return success($data);
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

        //更新之前判断手机号码是否被其他人使用
        if(isset($employeeData['phone_no'])) {
            $res = $this->employeeRepository->getEmployeeInfo(['phone_no' => $employeeData['phone_no']]);
            if ($res && $res['emp_id'] != $employeeData['emp_id']) {
                return [
                    'statusCode' => config('response_code.STATUSCODE_USERERROR'),
                    'msg' => "手机号码已经存在",
                    'success' => false
                ];
            }
        }

        $this->employeeRepository->updateEmployee($employeeData['emp_id'], $employeeData);
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg' => config('response_code.MSG_OK'),
            'success' => true
        ];
    }

    public function addCashier($param)
    {
        $employeeData = $param;
        //设置初始化密码
        $employeeData['password'] = mt_rand(100000, 999999);
        //判断手机号码是否存已经存在
        $res = $this->employeeRepository->getEmployeeInfo(['phone_no' => $employeeData['phone_no']]);
        if ($res) {
            //如果密码不为空
            if($res['password']){
                unset($employeeData['password']);
            }
            $this->employeeRepository->updateEmployee($res['emp_id'], $employeeData);
        }else{
            $this->employeeRepository->addEmployee($employeeData);
        }

        if(isset($employeeData['password'])) {
            //发送短信密码
        }

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg' => config('response_code.MSG_OK'),
            'success' => true
        ];
    }

    public function importEmployee($param)
    {
        $data = Excel::load($param['file']->getPathName(), function ($reader) {
            return $reader;
        });
        $employeeData = $data->getSheet(0)->toArray();
        //删除无用数据
        unset($employeeData[0]);
        unset($employeeData[1]);
        unset($employeeData[2]);

        foreach ($employeeData as $v) {
            $tmpEmployeeData['shop_id']  = $param['shop_id'];
            $tmpEmployeeData['emp_name'] =  trim($v[0]);
            $tmpEmployeeData['job']      =  trim($v[1]);
            $tmpEmployeeData['phone_no'] =  trim($v[2]);
            //检查数据，过滤无效数据
            if(!$tmpEmployeeData['emp_name'] || !$tmpEmployeeData['job']  || !$tmpEmployeeData['phone_no'] ) {
                continue;
            }
            $res = $this->employeeRepository->addEmployee($tmpEmployeeData);
            if($res){
                $this->employeeRepository->updateEmployee($res['emp_id'], $tmpEmployeeData);
            }
        }
    }

    public function getEmployeeInfo($param)
    {
        $whereParam = ['emp_id' => $param['emp_id']];
        $empInfo = $this->employeeRepository->getEmployeeInfo($whereParam);
        if(!$empInfo) {
            return fail(501, "员工信息不存在!");
        }
        if(0 == $empInfo['shop_id']) {
            $empInfo['shop_name'] = "总部";
        }else {
            $storeRepository = app(ShopRepositoryInterface::class);
            $storeInfo = $storeRepository->getShopInfo($empInfo['shop_id']);
            $empInfo['shop_name'] = $storeInfo['shop_name'];
        }
        unset($empInfo['password']);
        return success($empInfo);
    }


}