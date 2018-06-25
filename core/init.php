<?php

// set error logger
require_once CORE_DIR . '/spf/logger.php';
set_error_handler("errorHandler");

require_once CORE_DIR . '/spf/app.php';
require_once CORE_DIR . '/spf/router.php';
require_once CORE_DIR . '/spf/autoloader.php';
require_once CORE_DIR . '/spf/ctx.php';