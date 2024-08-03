<?php

namespace App\Helpers;

class DateFormatter
{
    public static function formatToLocal($datetime): string
    {
        try {
            $date = new \DateTime($datetime, new \DateTimeZone('UTC'));
            $date->setTimezone(new \DateTimeZone('America/Sao_Paulo'));
            return $date->format('d/m/Y H:i:s');
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Formato de data inválido: ' . $e->getMessage());
        }
    }
}
