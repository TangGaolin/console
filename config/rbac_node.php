<?php
/**
 * Created by PhpStorm.
 * User: jesse
 * Date: 16/9/7
 * Time: 10:52
 */
return [
    'private_node' => [
        [
            'node_name' => 'courseInfo',
            'title'     => '课程信息',
            'node_id'   => '1',
            'chiled'    => [
                [
                    'node_id'   => '2',
                    'node_name' => 'course',
                    'title'     => '课程查询',
                    'chiled'    => [
                        [
                            'node_id'   => '3',
                            'node_name' => 'searchCourseInfo',
                            'title'     => '课程查询',
                            'resource'  => ['/course/searchCourseInfo']
                        ],
                        [
                            'node_id'   => '4',
                            'node_name' => 'getCourseInfo',
                            'title'     => '课程详情',
                            'resource'  => ['/course/getCourseInfo', "/course/getCoursewareInfo","/course/setCourseReport","/course/resendReport"]
                        ],
                        [
                            'node_id'   => '64',
                            'node_name' => 'exportCourse',
                            'title'     => '课程信息导出',
                            'resource'  => ['/course/exportCourse']
                        ]

                    ]
                ]
            ]
        ],
        [
            'node_name' => 'scheduleCourse',
            'title'     => '学生排课',
            'node_id'   => '32',
            'chiled'    => [
                [
                    'node_id'   => '33',
                    'node_name' => 'searchStudentInfo',
                    'title'     => '学生信息查询',
                    'chiled'    => [
                        [
                            'node_id'   => '34',
                            'node_name' => 'searchStudentInfo',
                            'title'     => '学生信息查询',
                            'resource'  => ['/scheduleCourse/searchStudentInfo', '/scheduleCourse/searchStudentCourseInfo', '/student/detail', '/student/modify','/student/getFiles']
                        ],
                        [
                            'node_id'   => '63',
                            'node_name' => 'addFile',
                            'title'     => '学生附件上传',
                            'resource'  => ['/student/addFile','/student/uploadFile']
                        ]
                    ]
                ],
                [
                    'node_id'   => '35',
                    'node_name' => 'course',
                    'title'     => '学生排课',
                    'chiled'    => [
                        [
                            'node_id'   => '36',
                            'node_name' => 'searchIdleTeacher',
                            'title'     => '闲时老师查询',
                            'resource'  => ['/scheduleCourse/searchIdleTeacher']
                        ],
                        [
                            'node_id'   => '37',
                            'node_name' => 'getTrialTeacher',
                            'title'     => '获取试听课老师',
                            'resource'  => ['/scheduleCourse/getTrialTeacher']
                        ],
                        [
                            'node_id'   => '38',
                            'node_name' => 'scheduleTrialCourse',
                            'title'     => '排试听课',
                            'resource'  => ['/scheduleCourse/scheduleTrialCourse']
                        ],
                        [
                            'node_id'   => '39',
                            'node_name' => 'scheduleCourse',
                            'title'     => '排正式课',
                            'resource'  => ['/scheduleCourse/scheduleCourse']
                        ],
                        [
                            'node_id'   => '50',
                            'node_name' => 'scheduleDeviceCourse',
                            'title'     => '排设备检测课',
                            'resource'  => ['/scheduleCourse/scheduleDeviceCourse']
                        ],
                        [
                            'node_id'   => '51',
                            'node_name' => 'getDeviceTeacher',
                            'title'     => '获取设备检测课老师',
                            'resource'  => ['/scheduleCourse/getDeviceTeacher']
                        ],
                        [
                            'node_id'   => '40',
                            'node_name' => 'scheduleCourse',
                            'title'     => '取消试听课',
                            'resource'  => ['/scheduleCourse/cancelTrialCourse']
                        ],
                        [
                            'node_id'   => '41',
                            'node_name' => 'getStudentPeriod',
                            'title'     => '获取剩余课时',
                            'resource'  => ['/scheduleCourse/getStudentPeriod']
                        ],
                        [
                            'node_id'   => '42',
                            'node_name' => 'getTeacherInfo',
                            'title'     => '获取老师课时信息',
                            'resource'  => ['/scheduleCourse/getTeacherInfo']
                        ],
                        [
                            'node_id'   => '43',
                            'node_name' => 'adjustCourse',
                            'title'     => '调课',
                            'resource'  => ['/scheduleCourse/adjustCourse']
                        ],
                        [
                            'node_id'   => '44',
                            'node_name' => 'deferCourse',
                            'title'     => '课程顺延',
                            'resource'  => ['/scheduleCourse/deferCourse']
                        ],
                        [
                            'node_id'   => '52',
                            'node_name' => 'label',
                            'title'     => '课程标注',
                            'resource'  => ['/course/setLabel', '/course/getLabel', '/course/labelList', '/course/labelExport']
                        ],
                        [
                            'node_id'   => '65',
                            'node_name' => 'recoverCourse',
                            'title'     => '异常课程恢复',
                            'resource'  => ['/course/recoverCourse']
                        ]
                    ]
                ],
            ]
        ],
        [
            'node_name' => 'financeManage',
            'title'     => '财务管理',
            'node_id'   => '16',
            'chiled'    => [
                [
                    'node_id'   => '17',
                    'node_name' => 'withdrawManage',
                    'title'     => '提现申请',
                    'chiled'    => [
                        [
                            'node_id'   => '18',
                            'node_name' => 'withdrawBatchList',
                            'title'     => '批次列表',
                            'resource'  => ['/withdraw/withdrawBatchList']
                        ],
                        [
                            'node_id'   => '19',
                            'node_name' => 'withdrawList',
                            'title'     => '流水列表',
                            'resource'  => ['/withdraw/withdrawList']
                        ],
                        [
                            'node_id'   => '20',
                            'node_name' => 'setWithdrawStatus',
                            'title'     => '导入已打款',
                            'resource'  => ['/withdraw/setWithdrawStatus']
                        ],
                        [
                            'node_id'   => '21',
                            'node_name' => 'setRemark',
                            'title'     => '添加备注',
                            'resource'  => ['/withdraw/setRemark']
                        ],
                        [
                            'node_id'   => '22',
                            'node_name' => 'setWithdrawFail',
                            'title'     => '设置打款失败',
                            'resource'  => ['/withdraw/setWithdrawFail']
                        ],
                        [
                            'node_id'   => '46',
                            'node_name' => 'export',
                            'title'     => '导出待打款',
                            'resource'  => ['/withdraw/export']
                        ]
                    ]
                ]
            ]
        ],
        [
            'node_name' => 'teacherManage',
            'title'     => '老师管理',
            'node_id'   => '23',
            'chiled'    => [
                [
                    'node_id'   => '24',
                    'node_name' => 'teacherManage',
                    'title'     => '老师信息',
                    'chiled'    => [
                        [
                            'node_id'   => '25',
                            'node_name' => 'teacherList',
                            'title'     => '老师列表',
                            'resource'  => ['/instructor/list']
                        ],
                        [
                            'node_id'   => '26',
                            'node_name' => 'teacherDetail',
                            'title'     => '老师详情',
                            'resource'  => ['/instructor/detail', '/instructor/lecture', '/instructor/edit', '/admin/uploadImg']
                        ],
                        [
                            'node_id'   => '59',
                            'node_name' => 'teacherImport',
                            'title'     => '老师导入',
                            'resource'  => ['/instructor/import']
                        ]
                    ]
                ]
            ]
        ],
        [
            'node_name' => 'orderManage',
            'title'     => '订单管理',
            'node_id'   => '27',
            'chiled'    => [
                [
                    'node_id'   => '28',
                    'node_name' => 'orderManage',
                    'title'     => '订单管理',
                    'chiled'    => [
                        [
                            'node_id'   => '29',
                            'node_name' => 'createOrder',
                            'title'     => '课时订单',
                            'resource'  => ['/order/createOrder', '/order/getCourseware', '/order/getAmount']
                        ],
                        [
                            'node_id'   => '30',
                            'node_name' => 'createAuditionOrder',
                            'title'     => '试听课订单',
                            'resource'  => ['/order/createOrder', '/order/getAuditionOrderAmount', '/order/auditionOrderList', '/order/orderDetail']
                        ],
                        [
                            'node_id'   => '31',
                            'node_name' => 'getCourseOrderList',
                            'title'     => '订单列表',
                            'resource'  => ['/order/getCourseOrderList', '/order/orderDetail']
                        ],
                        [
                            'node_id'   => '45',
                            'node_name' => 'getMatterOrderList',
                            'title'     => '点阵笔寄送',
                            'resource'  => ['/order/getPenOrderList']
                        ],
                        [
                            'node_id'   => '47',
                            'node_name' => 'getMatterOrderList',
                            'title'     => '取消寄送',
                            'resource'  => ['/order/cancelPost']
                        ],
                        [
                            'node_id'   => '48',
                            'node_name' => '/order/export',
                            'title'     => '点阵笔订单报表导出',
                            'resource'  => ['/order/export']
                        ],
                        [
                            'node_id'   => '49',
                            'node_name' => '/order/import',
                            'title'     => '点阵笔订单报表导入',
                            'resource'  => ['/order/import']
                        ], 
						[
							'node_id'   => '60',
							'node_name' => '/order/updateAddress',
							'title'     => '点阵笔订单地址编辑',
							'resource'  => ['/order/updateAddress']
						],
                        [
                            'node_id'   => '61',
                            'node_name' => '/order/exportOrder',
                            'title'     => '订单报表导出',
                            'resource'  => ['/order/exportOrder']
                        ],
                        [
                            'node_id'   => '62',
                            'node_name' => '/order/exportAudition',
                            'title'     => '试听课订单导出',
                            'resource'  => ['/order/exportAudition']
                        ],
                        [
                            'node_id'   => '53',
                            'node_name' => '/order/update',
                            'title'     => '订单修改(慎用)',
                            'resource'  => ['/order/update']
                        ],
                    ]
                ]
            ]
        ],
        [
            'node_name' => 'authManage',
            'title'     => '权限管理',
            'node_id'   => '5',
            'chiled'    => [
                [
                    'node_id'   => '6',
                    'node_name' => 'accountManage',
                    'title'     => '帐号管理',
                    'chiled'    => [
                        [
                            'node_id'   => '7',
                            'node_name' => 'accountList',
                            'title'     => '账户列表',
                            'resource'  => ['/admin/accountList']
                        ],
                        [
                            'node_id'   => '8',
                            'node_name' => 'modifyAccountPasswd',
                            'title'     => '修改密码',
                            'resource'  => ['/admin/modifyAccountPasswd']
                        ],
                        [
                            'node_id'   => '9',
                            'node_name' => 'modifyRole',
                            'title'     => '更改角色',
                            'resource'  => ['/admin/modifyRole']
                        ],
                        [
                            'node_id'   => '10',
                            'node_name' => 'delAccount',
                            'title'     => '删除帐号',
                            'resource'  => ['/admin/disableAccount']
                        ],
                        [
                            'node_id'   => '15',
                            'node_name' => 'openAccount',
                            'title'     => '创建帐号',
                            'resource'  => ['/admin/openAccount', '/admin/getRoleList']
                        ]
                    ]
                ],
                [
                    'node_id'   => '11',
                    'node_name' => 'roleManage',
                    'title'     => '角色管理',
                    'chiled'    => [
                        [
                            'node_id'   => '12',
                            'node_name' => 'addRole',
                            'title'     => '创建角色',
                            'resource'  => ['/admin/addRole']
                        ],
                        [
                            'node_id'   => '13',
                            'node_name' => 'modifyRoleAccess',
                            'title'     => '修改权限',
                            'resource'  => ['/admin/modifyRoleAccess', '/admin/roleAccess']
                        ],
                        [
                            'node_id'   => '14',
                            'node_name' => 'disableRole',
                            'title'     => '删除角色',
                            'resource'  => ['/admin/disableRole']
                        ],
                    ]
                ]
            ]
        ]
    ],

	'public_node' => [
		'/admin/getNode',
		'/admin/modifyPasswd',
        '/course/resendReportCrm'
	]
];
