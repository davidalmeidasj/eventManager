<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class EventDao
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function create(Event $event)
    {
        $stmt = $this->pdo->prepare("INSERT INTO events (title, description, start_datetime, end_datetime) VALUES (:title, :description, :start_datetime, :end_datetime)");
        $stmt->bindValue(':title', $event->getTitle());
        $stmt->bindValue(':description', $event->getDescription());
        $stmt->bindValue(':start_datetime', $event->getStartDatetime());
        $stmt->bindValue(':end_datetime', $event->getEndDatetime());
        return $stmt->execute();
    }

    public function read($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Event::class);
        return $stmt->fetch();
    }

    public function update(Event $event): bool
    {
        $stmt = $this->pdo->prepare("UPDATE events SET title = :title, description = :description, start_datetime = :start_datetime, end_datetime = :end_datetime, updated_at = NOW() WHERE id = :id");
        $stmt->bindValue(':title', $event->getTitle());
        $stmt->bindValue(':description', $event->getDescription());
        $stmt->bindValue(':start_datetime', $event->getStartDatetime());
        $stmt->bindValue(':end_datetime', $event->getEndDatetime());
        $stmt->bindValue(':id', $event->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM events WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function list()
    {
        $stmt = $this->pdo->query("SELECT * FROM events ORDER BY start_datetime ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
