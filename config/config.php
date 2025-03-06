<?php
// Application settings
define('APP_NAME', 'OpenLearn');
define('APP_ENV', 'production');
define('APP_DEBUG', false);

// Security settings
define('CSRF_TOKEN_NAME', 'openlearn_csrf');
define('PASSWORD_COST', 12);

// File upload settings
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
define('ALLOWED_FILE_TYPES', ['pdf', 'docx', 'pptx']);