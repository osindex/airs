<?php

return [
    'api' => [
        'restful' => true, // 是否 RESTful 方法，默认为true，所有操作都将使用 HTTP,如果为false 成功结果都返回200状态。
    ],
    'guards' => [
        'admin' => [
            'model' => \Osi\Airs\Models\AdminUser::class,
            'login_fields' => [
                'username',
            ],
            'conditions' => [
                ['status', '=', 1]
            ]
        ]
    ]
];