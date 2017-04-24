<?php


namespace MondialRelay;


class Point
{
    private $name;
    private $latitude;
    private $longitude;
    private $label;
    private $cp;

    public function __construct($name, $latitude, $longitude, $label, $cp)
    {
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->label = $label;
        $this->cp = $cp;
    }

    public function name()
    {
        return $this->name;
    }

    public function latitude()
    {
        return $this->latitude;
    }

    public function longitude()
    {
        return $this->longitude;
    }

    public function label()
    {
        return $this->label;
    }

    public function cp()
    {
        return $this->cp;
    }
}