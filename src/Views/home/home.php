<?php

use App\Helpers\DateHelper;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ob_start();
?>

<?php

$content = ob_get_clean();
$title = 'Home';
include __DIR__ . '/../layout.php';
?>

