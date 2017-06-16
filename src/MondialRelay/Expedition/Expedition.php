<?php

namespace MondialRelay\Expedition;


class Expedition
{
    private $stat;
    private $expeditionNum;
    private $triAgenceCode;
    private $triGroupe;
    private $triNavette;
    private $triAgence;
    private $triTourneeCode;
    private $triLivraisonMode;
    private $codesBarres;

    /**
     * Expedition constructor.
     * @param $stat
     * @param $expeditionNum
     * @param $triAgenceCode
     * @param $triGroupe
     * @param $triNavette
     * @param $triAgence
     * @param $triTourneeCode
     * @param $triLivraisonMode
     * @param $codesBarres
     */
    public function __construct(
        $stat,
        $expeditionNum,
        $triAgenceCode,
        $triGroupe,
        $triNavette,
        $triAgence,
        $triTourneeCode,
        $triLivraisonMode,
        $codesBarres
    ) {
        $this->stat = $stat;
        $this->expeditionNum = $expeditionNum;
        $this->triAgenceCode = $triAgenceCode;
        $this->triGroupe = $triGroupe;
        $this->triNavette = $triNavette;
        $this->triAgence = $triAgence;
        $this->triTourneeCode = $triTourneeCode;
        $this->triLivraisonMode = $triLivraisonMode;
        $this->codesBarres = $codesBarres;
    }

    /**
     * @return mixed
     */
    public function stat()
    {
        return $this->stat;
    }

    /**
     * @return mixed
     */
    public function expeditionNum()
    {
        return $this->expeditionNum;
    }

    /**
     * @return mixed
     */
    public function triAgenceCode()
    {
        return $this->triAgenceCode;
    }

    /**
     * @return mixed
     */
    public function triGroupe()
    {
        return $this->triGroupe;
    }

    /**
     * @return mixed
     */
    public function triNavette()
    {
        return $this->triNavette;
    }

    /**
     * @return mixed
     */
    public function triAgence()
    {
        return $this->triAgence;
    }

    /**
     * @return mixed
     */
    public function triTourneeCode()
    {
        return $this->triTourneeCode;
    }

    /**
     * @return mixed
     */
    public function triLivraisonMode()
    {
        return $this->triLivraisonMode;
    }

    /**
     * @return mixed
     */
    public function codesBarres()
    {
        return $this->codesBarres;
    }

}