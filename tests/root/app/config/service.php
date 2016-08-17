<?php
return [
    'user' => 'www-data',
    'group' => 'www-data',
    'worker_num' => 1,
    'daemonize' => 0,
    'max_request' => 10,
    'backlog' => 8192,

    'run_dir' => '/tmp/phwoolcon-test/',
    'linux_init_script' => '/etc/init.d/phwoolcon-test',
    'debug' => true,
    'profiler' => false,
    'start_on_boot' => true,
];
