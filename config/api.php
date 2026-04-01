<?php

if (!defined('API_DOMAIN_PREFIX')) {
    define('API_DOMAIN_PREFIX', 'http://localhost:8000');
}

if (!defined('API_BASE_URL')) {
    define('API_BASE_URL', rtrim(API_DOMAIN_PREFIX, '/') . '/api/v1');
}
