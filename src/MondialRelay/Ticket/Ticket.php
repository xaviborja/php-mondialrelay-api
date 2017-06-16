<?php

namespace MondialRelay\Ticket;
/**
 * Created by PhpStorm.
 * User: albertclaret
 * Date: 14/06/17
 * Time: 10:22
 */
class Ticket
{
    private $stat;
    private $urlPDFA4;
    private $urlPDFA5;
    private $url10x15;

    /**
     * Ticket constructor.
     * @param $stat
     * @param $urlPDFA4
     * @param $urlPDFA5
     */
    public function __construct($stat, $urlPDFA4, $urlPDFA5, $url10x15)
    {
        $this->stat = $stat;
        $this->urlPDFA4 = $urlPDFA4;
        $this->urlPDFA5 = $urlPDFA5;
        $this->url10x15 = $url10x15;
    }

    /**
     * @return mixed
     */
    public function getStat()
    {
        return $this->stat;
    }

    /**
     * @return mixed
     */
    public function getUrlPDFA4()
    {
        return $this->urlPDFA4;
    }

    /**
     * @return mixed
     */
    public function getUrlPDFA5()
    {
        return $this->urlPDFA5;
    }

    /**
     * @return mixed
     */
    public function getUrl10x15()
    {
        return $this->url10x15;
    }

}