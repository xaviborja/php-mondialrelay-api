<?php


namespace MondialRelay\Point;


class Point
{
    private $id;
    private $latitude;
    private $longitude;
    private $cp;
    private $address;
    private $city;
    private $country;
    private $location;
    private $activityType;
    private $information;
    private $business_hours;

    public function __construct(
        $id,
        $latitude,
        $longitude,
        $cp,
        array $address,
        $city,
        $country,
        array $location,
        $activityType,
        $information,
        array $business_hours
    ) {
        $this->id = $id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->cp = $cp;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->location = $location;
        $this->activityType = $activityType;
        $this->information = $information;
        $this->business_hours = $business_hours;
    }


    public function id()
    {
        return $this->id;
    }

    public function address()
    {
        return $this->address;
    }

    public function latitude()
    {
        return $this->latitude;
    }

    public function longitude()
    {
        return $this->longitude;
    }

    public function cp()
    {
        return $this->cp;
    }

    public function city()
    {
        return $this->city;
    }

    public function country()
    {
        return $this->country;
    }

    public function location()
    {
        return $this->location;
    }

    public function activityType()
    {
        return $this->activityType;
    }

    public function information()
    {
        return $this->information;
    }

    public function business_hours()
    {
        return $this->business_hours;
    }


}