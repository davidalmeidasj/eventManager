<?php

namespace App\Validators;

class EventValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = 'O título é obrigatório';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'A descrição é obrigatória';
        }

        if (empty($data['start_datetime'])) {
            $errors['start_datetime'] = 'A data e hora de início são obrigatórias';
        } else {
            $start_datetime = \DateTime::createFromFormat('Y-m-d\TH:i', $data['start_datetime'], new \DateTimeZone('America/Sao_Paulo'));
            if ($start_datetime === false) {
                $errors['start_datetime'] = 'Formato de data e hora de início inválido';
            } else {
                $current_datetime = new \DateTime("now", new \DateTimeZone('America/Sao_Paulo'));
                if ($start_datetime < $current_datetime) {
                    $errors['start_datetime'] = 'A data e hora de início não podem ser no passado';
                }
            }
        }

        if (empty($data['end_datetime'])) {
            $errors['end_datetime'] = 'A data e hora de término são obrigatórias';
        } else {
            $end_datetime = \DateTime::createFromFormat('Y-m-d\TH:i', $data['end_datetime'], new \DateTimeZone('America/Sao_Paulo'));
            if ($end_datetime === false) {
                $errors['end_datetime'] = 'Formato de data e hora de término inválido';
            } elseif (isset($start_datetime) && $end_datetime <= $start_datetime) {
                $errors['end_datetime'] = 'A data e hora de término não podem ser antes ou igual à data e hora de início';
            }
        }

        return $errors;
    }
}
