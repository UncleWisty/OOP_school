php -S localhost:8000 -t public
vendor/bin/phpunit tests
vendor/bin/phpunit tests/Domain/Course/CourseTest.php
vendor/bin/phpunit --filter test_subject_can_be_created_and_getters_work tests/Domain/Subject/SubjectTest.php
