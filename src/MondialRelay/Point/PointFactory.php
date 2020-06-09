<?php

namespace MondialRelay\Point;

use MondialRelay\BussinessHours\BussinessHoursFactory;

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
                isset($response->LgAdr1) ? trim($response->LgAdr1) : '',
                isset($response->LgAdr2) ? trim($response->LgAdr2) : '',
                isset($response->LgAdr3) ? trim($response->LgAdr3) : '',
                isset($response->LgAdr4) ? trim($response->LgAdr4) : '',
            ],
            $response->Ville,
            $response->Pays,
            [
                isset($response->Localisation1) ? $response->Localisation1 : '',
                isset($response->Localisation2) ? $response->Localisation2 : ''
            ],
            $response->TypeActivite,
            $response->Information,
            $bussines_hours
        );

    }
}
