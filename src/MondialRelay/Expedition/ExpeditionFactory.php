<?php

namespace MondialRelay\Expedition;

/**
 * Created by PhpStorm.
 * User: albertclaret
 * Date: 14/06/17
 * Time: 09:19
 */
class ExpeditionFactory
{
    public function create(
        $stat,
        $expeditionNum,
        $triAgenceCode,
        $triGroupe,
        $triNavette,
        $triAgence,
        $triTourneeCode,
        $triLivraisonMode,
        $codesBarres)
    {
        return new Expedition($stat,
            $expeditionNum,
            $triAgenceCode,
            $triGroupe,
            $triNavette,
            $triAgence,
            $triTourneeCode,
            $triLivraisonMode,
            $codesBarres);
    }
}