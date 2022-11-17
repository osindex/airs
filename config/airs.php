<?php

return [
    'guards' => [
        'admin' => [
            'model' => \Zkuyuo\Airs\Models\AdminUser::class,
            'login_fields' => [
                'username',
            ],
            'conditions' => [
                ['status', '=', 1]
            ]
        ]
    ]
];