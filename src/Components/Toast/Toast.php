<?php

namespace App\Components\Toast;

class Toast
{
    public static function render($message, $type = 'success')
    {
        $headerClass = $type === 'error' ? 'toast-header-error' : 'toast-header-success';

        ob_start();
        ?>
        <link rel="stylesheet" href="/css/Components/Toast/styles.css">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header <?php echo $headerClass; ?>">
                <strong class="mr-auto">Notificação</strong>
            </div>
            <div class="toast-body">
                <?php echo htmlspecialchars($message); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
