<?php

namespace MondialRelay\BussinessHours;

/**
 * Created by PhpStorm.
 * User: albertclaret
 * Date: 14/06/17
 * Time: 09:29
 */
class BussinessHoursFactory
{

    private static $property_days_name = [
        'monday' => 'Horaires_Lundi',
        'tuesday' => 'Horaires_Mardi',
        'wednesday' => 'Horaires_Mercredi',
        'thursday' => 'Horaires_Jeudi',
        'friday' => 'Horaires_Vendredi',
        'saturday' => 'Horaires_Samedi',
        'sunday' => 'Horaires_Dimanche'
    ];

    public function create($response)
    {
        $bussines_hours = [];
        foreach (self::$property_days_name as $day => $property) {
            $bussines_hours[] = new BussinessHours(
                $day,
                $response->$property->string[0],
                $response->$property->string[1],
                $response->$property->string[2],
                $response->$property->string[3]
            );
        }
        return $bussines_hours;

    }
}