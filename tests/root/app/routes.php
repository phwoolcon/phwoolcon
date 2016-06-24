<?php
/* @var Phwoolcon\Router $this */

use Phwoolcon\Tests\Helper\Filter\AlwaysException as AlwaysExceptionFilter;
use Phwoolcon\Tests\Helper\Filter\AlwaysFail as AlwaysFailFilter;

$this->prefix('/prefix', [
    'GET' => [
        'test-route' => 'Phwoolcon\Tests\Helper\TestController::getTestPrefixedRoute',
    ],
])->prefix('/api', [
    'GET' => [
        '/:params' => 'Phwoolcon\Tests\Helper\TestApiController::missingMethod',
        'test-route' => 'Phwoolcon\Tests\Helper\TestApiController::getTestRoute',
    ],
], MultiFilter::instance()
    ->add(DisableSessionFilter::instance())
    ->add(DisableCsrfFilter::instance()))
    ->prefix('/admin', [
        'GET' => [
            'test-route' => 'Phwoolcon\Tests\Helper\TestAdminController::getTestRoute',
        ],
    ]);

return [
    'GET' => [
        'test-closure-route' => function () {
            return 'Test Closure Route Content';
        },
        'test-controller-route' => 'Phwoolcon\Tests\Helper\TestController::getTestRoute',
        'test-exception-filter-route' => [
            'controller' => function () {
                return 'Wont be executed';
            },
            'filter' => AlwaysExceptionFilter::instance(),
        ],
    ],
    'POST' => [
        'test-filtered-route' => [
            'controller' => 'Phwoolcon\Tests\Helper\TestController',
            'action' => 'getTestRoute',
            'filter' => MultiFilter::instance()
                ->add(DisableSessionFilter::instance())
                ->add(DisableCsrfFilter::instance()),
        ],
        'test-failed-filter-route' => [
            'controller' => function () {
                return 'Wont be executed';
            },
            'filter' => MultiFilter::instance()
                ->add(AlwaysFailFilter::instance())
                ->add(DisableSessionFilter::instance())
                ->add(DisableCsrfFilter::instance()),
        ],
        'test-csrf-check' => function () {
            return 'Wont be executed';
        },
    ],
];
