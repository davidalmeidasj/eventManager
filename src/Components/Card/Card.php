<?php

namespace App\Components\Card;

use App\Helpers\DateFormatter;

class Card
{
    public static function render($event)
    {
        ob_start();
        ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                <p class="card-text"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                <p class="card-text"><small class="text-muted">Inicia: <?php echo DateFormatter::formatToLocal($event['start_datetime']); ?></small></p>
                <p class="card-text"><small class="text-muted">Finaliza: <?php echo DateFormatter::formatToLocal($event['end_datetime']); ?></small></p>
                <button class="btn btn-primary edit-event" data-id="<?php echo $event['id']; ?>" data-bs-toggle="modal" data-bs-target="#addEventModal">Editar evento</button>
                <button class="btn btn-danger cancel-event" data-id="<?php echo $event['id']; ?>">Cancelar evento</button>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
