<?php

namespace App\Components\Modal;

class EventModal
{
    public static function render()
    {
        ob_start();
        ?>
        <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Evento</h5>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" id='title'>

                                </h5>
                                <p class="card-text" id='description'>
                                </p>
                                <p class="card-text"><small class="text-muted" id='start'>Inicia:

                                </small></p>
                                <p class="card-text"><small class="text-muted" id='end'>Finaliza:

                                </small></p>
                                <button class="btn btn-primary edit-event" id='edit-event-button' data-id='' data-bs-toggle="modal" data-bs-target="#addEventModal">Editar evento</button>
                                <button class="btn btn-danger cancel-event" id='cancel-event-button' data-id=''>Cancelar evento</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $output = ob_get_clean();
        return $output;
    }
}
