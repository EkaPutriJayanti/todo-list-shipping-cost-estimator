<?php

namespace App\Helpers;

use InvalidArgumentException;

class ShippingHelper
{
    public static function calculateCost($weight, $distance, $service)
    {
        if (!is_numeric($weight) || $weight < 0) {
            throw new InvalidArgumentException('Berat tidak boleh negatif');
        }

        if (!is_numeric($distance) || $distance < 0) {
            throw new InvalidArgumentException('Jarak tidak boleh negatif');
        }

        if (!in_array($service, ['regular', 'express'])) {
            throw new InvalidArgumentException('Tipe layanan tidak valid');
        }

        $cost = ($weight * 5000) + ($distance * 2000);

        if ($service === 'express') {
            $cost += 10000; // express surcharge
        }

        return $cost;
    }
}
