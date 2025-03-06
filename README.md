# sch




openlearn/
├── .htaccess
├── index.php
├── composer.json
├── composer.lock
├── vendor/
│
├── config/
│   ├── database.php
│   ├── config.php
│   └── routes.php
│
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   └── dashboard.css
│   ├── js/
│   │   ├── auth.js
│   │   ├── main.js
│   │   └── dashboard.js
│   ├── img/
│   │   ├── logo.png
│   │   └── favicon.ico
│   └── uploads/
│       ├── courses/
│       └── profile/
│
├── includes/
│   ├── auth.php
│   ├── header.php
│   ├── footer.php
│   ├── navbar.php
│   ├── auth_modal.php
│   ├── db_connect.php
│   └── functions.php
│
├── lib/
│   ├── Validator.php
│   ├── AuthMiddleware.php
│   └── CourseManager.php
│
├── pages/
│   ├── public/
│   │   ├── courses.php
│   │   ├── course-view.php
│   │   ├── about.php
│   │   └── contact.php
│   │
│   ├── instructor/
│   │   ├── dashboard.php
│   │   ├── courses/
│   │   │   ├── create.php
│   │   │   ├── edit.php
│   │   │   └── manage.php
│   │   ├── profile/
│   │   │   ├── view.php
│   │   │   └── edit.php
│   │   └── students/
│   │       └── list.php
│   │
│   └── admin/
│       ├── dashboard.php
│       ├── users.php
│       └── settings.php
│
├── processes/
│   ├── auth/
│   │   ├── login.php
│   │   ├── logout.php
│   │   ├── register.php
│   │   └── password-reset.php
│   │
│   ├── courses/
│   │   ├── create.php
│   │   ├── update.php
│   │   └── delete.php
│   │
│   └── enrollments/
│       ├── enroll.php
│       └── unenroll.php
│
├── templates/
│   ├── emails/
│   │   ├── welcome.html
│   │   └── password-reset.html
│   │
│   └── errors/
│       ├── 404.php
│       └── 500.php
│
├── tests/
│   ├── unit/
│   └── integration/
│
└── vendor/
