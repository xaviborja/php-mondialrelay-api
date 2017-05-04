<?php


namespace MondialRelay;


class BussinessHours
{
    private $day;
    private $openingTime1;
    private $closingTime1;
    private $openingTime2;
    private $closingTime2;

    public function __construct($day, $openingTime1, $closingTime1, $openingTime2, $closingTime2)
    {
        $this->day = $day;
        $this->openingTime1 = $openingTime1;
        $this->closingTime1 = $closingTime1;
        $this->openingTime2 = $openingTime2;
        $this->closingTime2 = $closingTime2;
    }

    public function day()
    {
        return $this->day;
    }

    public function openingTime1()
    {
        return $this->openingTime1;
    }

    public function closingTime1()
    {
        return $this->closingTime1;
    }

    public function openingTime2()
    {
        return $this->openingTime2;
    }

    public function closingTime2()
    {
        return $this->closingTime2;
    }



}