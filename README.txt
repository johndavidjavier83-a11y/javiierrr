SETUP (XAMPP / WAMP / any PHP 8+ + MySQL host)
1. Unzip into htdocs/jd-portfolio
2. phpMyAdmin > Import > sql/database.sql
3. Edit DB user/password in config.php if needed
4. Open http://localhost/jd-portfolio/login.php
   The FIRST visit lets you create the admin account (only you). After that, registration is closed.
5. Visitors just open index.php and can only view/download.
Upload limit is 20MB; raise upload_max_filesize and post_max_size in php.ini if needed.
