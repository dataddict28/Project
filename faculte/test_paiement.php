<?php
// Simple test to check if Paiement model can be loaded
define('APP_PATH', __DIR__ . '/app');
define('BASE_PATH', __DIR__);

require_once APP_PATH . '/models/Paiement.php';
echo "Paiement model loaded successfully.\n";

// Test if class exists
if (class_exists('Paiement')) {
    echo "Paiement class exists.\n";
} else {
    echo "Paiement class does not exist.\n";
}
?>
