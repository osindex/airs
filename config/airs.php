<?php

return [
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