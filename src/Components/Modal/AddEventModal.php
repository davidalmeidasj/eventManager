<?php

namespace App\Components\Modal;

class AddEventModal
{
    public static function render()
    {
        ob_start();
        ?>
        <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEventModalLabel">Criar evento</h5>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addEventForm" method="POST" action="/add-event">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="title">Título</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="description">Descrição</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="start_datetime">Começa em</label>
                                <input type="datetime-local" class="form-control" id="start_datetime" name="start_datetime" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="end_datetime">Termina em</label>
                                <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $output = ob_get_clean();
        return $output;
    }
}
