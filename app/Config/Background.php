<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Background extends BaseConfig
{
    public array $config = [
        'worker_filename' => 'bg_worker.php',
        'timeout' => 1,
        'auto_create_worker' => true,
        'log_errors' => true,
    ];
}
