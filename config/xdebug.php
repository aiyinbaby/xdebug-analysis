<?php
return [
    'trace' => [
        'build_tree_type' => 1,
        'default_file' => rtrim(dirname(dirname(__FILE__)),'/') . '/xdebug.xt',
        'line_parser_type' => 1,
        'close' => 1,
        'pid_file' =>  rtrim(dirname(dirname(__FILE__)),'/') . '/pid',
        'data_path' => rtrim(dirname(dirname(__FILE__)),'/') . '/storage/xdebug/trace/temp',
        'log_file' =>  rtrim(dirname(dirname(__FILE__)),'/') . '/storage/xdebug/trace/log.txt',
    ],
];