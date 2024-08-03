<?php

use App\Components\Modal\AddEventModal;
use App\Components\Modal\EventModal;
use App\Components\Toast\Toast;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Event Manager'; ?></title>
    <link rel="stylesheet" href="/css/Components/Toast/styles.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/Components/Layoult/styles.css">

    <script src="https://kit.fontawesome.com/1df5d09f33.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.15/index.global.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
            crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>
    <script src="/js/layoult.js"></script>
</head>
<body>
<div class="container mt-5">
    <div id='top' class='locale-selector'>
        <select id='locale-selector'></select>
    </div>
    <div id='calendar'></div>
</div>
<?php echo AddEventModal::render(); ?>
<?php echo EventModal::render(); ?>
<?php

$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
echo Toast::render($successMessage);
?>
</body>
</html>
