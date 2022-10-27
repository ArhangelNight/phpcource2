<?php

$config = include 'config.php';
include 'QueryBuilder.php';
include 'connection.php';

return new QueryBuilder(
    Connection::make($config['database'])
);