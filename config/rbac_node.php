<?php
/**
 * Created by PhpStorm.
 * User: jesse
 * Date: 16/9/7
 * Time: 10:52
 * private_node: usedId:1-
 */
return [
    'private_node' => [
        [
            'node_name' => 'personnel',
            'title'     => '门店职工',
            'node_id'   => '1',
            'child'    => [
                [
                    'node_id'   => '2',
                    'node_name' => 'storeManage',
                    'title'     => '门店管理',
                    'child'    => [
                        [
                            'node_id'   => '3',
                            'node_name' => 'getStoreList',
                            'title'     => '门店查询',
                            'resource'  => ['/store/getStoreList']
                        ],
                        [
                            'node_id'   => '4',
                            'node_name' => 'addStore',
                            'title'     => '新增/更新门店',
                            'resource'  => ['/store/addStore', '/store/updateStoreInfo']
                        ]
                    ]
                ],
                [
                    'node_id'   => '5',
                    'node_name' => 'employee',
                    'title'     => '职工信息',
                    'child'    => [
                        [
                            'node_id'   => '6',
                            'node_name' => 'getEmployeeList',
                            'title'     => '员工查询',
                            'resource'  => ['employee/getEmployeeList']
                        ],
                        [
                            'node_id'   => '7',
                            'node_name' => 'addEmployee',
                            'title'     => '新增/更新/删除员工',
                            'resource'  => ['/employee/addEmployee', '/employee/updateEmployee','/employee/removeEmployee']
                        ],
                        [
                            'node_id'   => '8',
                            'node_name' => 'addEmployee',
                            'title'     => '导入员工',
                            'resource'  => ['/employee/importEmployee']
                        ],
                        [
                            'node_id'   => '9',
                            'node_name' => 'getEmployeeInfo',
                            'title'     => '员工数据信息',
                            'resource'  => ['/employee/getEmployeeInfo', '/employee/getEmpDataView', '/employee/getEmpOrderList']
                        ]
                    ]
                ],
                [
                    'node_id'   => '10',
                    'node_name' => 'cashier',
                    'title'     => '前台账号',
                    'child'    => [
                        [
                            'node_id'   => '11',
                            'node_name' => 'getCashier',
                            'title'     => '收银员查询',
                            'resource'  => ['/employee/getEmployeeList']
                        ],
                        [
                            'node_id'   => '12',
                            'node_name' => 'addEmployee',
                            'title'     => '新增/更新/删除前台',
                            'resource'  => ['/employee/addCashier', '/employee/updateCashier', '/employee/removeCashier']
                        ]
                    ]
                ],
            ]
        ],
        [
            'node_name' => 'basics',
            'title'     => '品项管理',
            'node_id'   => '13',
            'child'    => [
                [
                    'node_id'   => '14',
                    'node_name' => 'itemMgr',
                    'title'     => '项目管理',
                    'child'    => [
                        [
                            'node_id'   => '15',
                            'node_name' => 'item',
                            'title'     => '项目管理',
                            'resource'  => ['/item/addItem', '/item/getItemList', '/item/modifyItem']
                        ],
                        [
                            'node_id'   => '16',
                            'node_name' => 'itemType',
                            'title'     => '项目分类管理',
                            'resource'  => ['/item/addItemType', '/item/modifyItemType', '/item/modifyItemType']
                        ]
                    ]
                ],
                [
                    'node_id'   => '17',
                    'node_name' => 'goodMgr',
                    'title'     => '产品管理',
                    'child'    => [
                        [
                            'node_id'   => '18',
                            'node_name' => 'good',
                            'title'     => '产品管理',
                            'resource'  => ['/good/addGood','/good/getGoodsList', 'good/updateGood']
                        ],
                        [
                            'node_id'   => '19',
                            'node_name' => 'goodBrand',
                            'title'     => '产品品牌管理',
                            'resource'  => ['/good/addGoodBrand','/good/getBrandList', 'good/updateBrand']
                        ]
                    ]
                ]
            ]
        ],
        [
            'node_name' => 'user-center',
            'title'     => '会员中心',
            'node_id'   => '20',
            'child'    => [
                [
                    'node_id'   => '21',
                    'node_name' => 'user-mgr',
                    'title'     => '会员管理',
                    'child'     => [
                        [
                            'node_id'   => '22',
                            'node_name' => 'getUsers',
                            'title'     => '会员/详情查询',
                            'resource'  => ['/users/getUserList','/users/getUserDetail','/users/getUserItemList', '/users/getOrderList', '/users/getUseOrderList']
                        ],
                        [
                            'node_id'   => '23',
                            'node_name' => 'addUser',
                            'title'     => '创建/编辑用户',
                            'resource'  => ['/users/addUser', '/users/updateUser']
                        ],
                        [
                            'node_id'   => '24',
                            'node_name' => 'importUser',
                            'title'     => '导入用户',
                            'resource'  => ['/users/importUser']
                        ]
                    ]
                ]
            ]
        ],
        [
            'node_name' => 'orders',
            'title'     => '收银单据',
            'node_id'   => '25',
            'child'    => [
                [
                    'node_id'   => '26',
                    'node_name' => 'yeji-order',
                    'title'     => '业绩单据',
                    'child'     => [
                        [
                            'node_id'   => '27',
                            'node_name' => 'yeji-order-list',
                            'title'     => '业绩单据查询',
                            'resource'  => ['/order/getOrderList']
                        ]
                    ]
                ],
                [
                    'node_id'   => '28',
                    'node_name' => 'xiaohao-order',
                    'title'     => '消耗单据',
                    'child'     => [
                        [
                            'node_id'   => '29',
                            'node_name' => 'xiaohao-order-list',
                            'title'     => '消耗单据查询',
                            'resource'  => ['/order/getUseOrderList']
                        ]
                    ]
                ]
            ]
        ],
        [
            'node_name' => 'data-analysis',
            'title'     => '数据统计',
            'node_id'   => '30',
            'child'    => [
                [
                    'node_id'   => '31',
                    'node_name' => 'shop-data',
                    'title'     => '门店数据',
                    'child'     => [
                        [
                            'node_id'   => '32',
                            'node_name' => 'getUsers',
                            'title'     => '门店数据',
                            'resource'  => ['/storeData/getShopsDataView']
                        ]
                    ]
                ]
            ]
        ],
        [
            'node_name' => 'authManage',
            'title'     => '权限管理',
            'node_id'   => '1001',
            'child'    => [
                [
                    'node_id'   => '1002',
                    'node_name' => 'roleManage',
                    'title'     => '角色管理',
                    'child'    => [
                        [
                            'node_id'   => '1003',
                            'node_name' => 'addRole',
                            'title'     => '创建角色',
                            'resource'  => ['/admin/addRole']
                        ],
                        [
                            'node_id'   => '1004',
                            'node_name' => 'modifyRoleAccess',
                            'title'     => '修改权限',
                            'resource'  => ['/admin/modifyRoleAccess', '/admin/roleAccess']
                        ],
                        [
                            'node_id'   => '1005',
                            'node_name' => 'disableRole',
                            'title'     => '删除角色',
                            'resource'  => ['/admin/disableRole']
                        ],
                    ]
                ],
                [
                    'node_id'   => '1006',
                    'node_name' => 'accountManage',
                    'title'     => '帐号管理',
                    'child'    => [
                        [
                            'node_id'   => '1007',
                            'node_name' => 'accountList',
                            'title'     => '账户列表',
                            'resource'  => ['/admin/getAccountList']
                        ],
                        [
                            'node_id'   => '1008',
                            'node_name' => 'delAccount',
                            'title'     => '删除帐号',
                            'resource'  => ['/admin/disableAccount']
                        ],
                        [
                            'node_id'   => '1009',
                            'node_name' => 'openAccount',
                            'title'     => '创建帐号',
                            'resource'  => ['/admin/openAccount', '/admin/getRoleList']
                        ]
                    ]
                ]
            ]
        ]
    ]
];
