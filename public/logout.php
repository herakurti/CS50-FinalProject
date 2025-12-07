<?php
require_once __DIR__ . '/../app/lib/auth.php';

logout_user();
redirect('login.php');
