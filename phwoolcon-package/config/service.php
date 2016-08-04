<?php
return [
    'user' => 'www-data',
    'group' => 'www-data',
    'worker_num' => 16,
    'daemonize' => 1,
    'max_request' => 10000,
    'backlog' => 8192,

    'run_dir' => '/tmp/phwoolcon/',
    'linux_init_script' => '/etc/init.d/phwoolcon',
    'debug' => false,
    'profiler' => false,
    'start_on_boot' => true,
];
