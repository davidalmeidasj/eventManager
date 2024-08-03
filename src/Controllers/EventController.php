<?php

namespace App\Controllers;

use App\Services\EventService;
use App\Validators\EventValidator;
use App\Helpers\ResponseBuilder;
use App\Models\Event;

class EventController
{
    private $eventService;
    private $eventValidator;

    public function __construct(EventService $eventService, EventValidator $eventValidator)
    {
        $this->eventService = $eventService;
        $this->eventValidator = $eventValidator;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->eventValidator->validate($_POST);

            if (!empty($errors)) {
                ResponseBuilder::error('Erro na validação', $errors);
            }

            $event = new Event();
            $event->setTitle($_POST['title']);
            $event->setDescription($_POST['description']);
            $event->setStartDatetime($_POST['start_datetime']);
            $event->setEndDatetime($_POST['end_datetime']);

            $success = $this->eventService->createEvent($event);
            if ($success) {
                ResponseBuilder::success([], 'Evento criado com sucesso');
            } else {
                ResponseBuilder::error('Falha ao criar evento');
            }
        }
    }

    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->eventValidator->validate($_POST);

            if (!empty($errors)) {
                ResponseBuilder::error('Erro na validação', $errors);
            }

            $event = new Event();
            $event->setId($_POST['id']);
            $event->setTitle($_POST['title']);
            $event->setDescription($_POST['description']);
            $event->setStartDatetime($_POST['start_datetime']);
            $event->setEndDatetime($_POST['end_datetime']);

            $success = $this->eventService->updateEvent($event);
            if ($success) {
                ResponseBuilder::success([], 'Evento atualizado com sucesso');
            } else {
                ResponseBuilder::error('Falha ao atualizar evento');
            }
        }
    }

    public function cancel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $success = $this->eventService->deleteEvent($id);
            if ($success) {
                ResponseBuilder::success([], 'Evento cancelado com sucesso');
            } else {
                ResponseBuilder::error('Falha ao cancelar evento');
            }
        }
    }

    public function getListFormatted()
    {
        $events = $this->eventService->getAllEvents();

        ResponseBuilder::success($events);
    }

    public function getEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $event = $this->eventService->getEvent($id);
            if ($event) {
                ResponseBuilder::success([
                    'id' => $event->getId(),
                    'title' => $event->getTitle(),
                    'description' => $event->getDescription(),
                    'start_datetime' => $event->getStartDatetime(),
                    'end_datetime' => $event->getEndDatetime(),
                ]);
            } else {
                ResponseBuilder::error('Evento não encontrado');
            }
        } else {
            ResponseBuilder::error('Requisição inválida');
        }
    }
}
