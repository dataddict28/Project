<?php
$page_title = 'À propos';
$show_navbar = true;
$show_sidebar = true;

ob_start();
include APP_PATH . '/views/about_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
