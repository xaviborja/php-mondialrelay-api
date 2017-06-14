<?php

namespace MondialRelay\Point;

use MondialRelay\BussinessHours\BussinessHoursFactory;

/**
 * Created by PhpStorm.
 * User: albertclaret
 * Date: 14/06/17
 * Time: 09:27
 */
class PointFactory
{
    public function create($response)
    {
        $bussines_hours = (new BussinessHoursFactory())->create($response);
        return new Point(
            $response->Num,
            str_replace(",", ".", $response->Latitude),
            str_replace(",", ".", $response->Longitude),
            $response->CP,
            [
                trim($response->LgAdr1),
                trim($response->LgAdr2),
                trim($response->LgAdr3),
                trim($response->LgAdr4)
            ],
            $response->Ville,
            $response->Pays,
            [
                $response->Localisation1,
                $response->Localisation2
            ],
            $response->TypeActivite,
            $response->Information,
            $bussines_hours
        );

    }
}