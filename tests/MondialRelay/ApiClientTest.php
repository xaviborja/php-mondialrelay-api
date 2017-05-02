<?php

namespace MondialRelay;

class ApiClientTest extends \PHPUnit_Framework_TestCase
{

    CONST WEBSITEID = "BDTEST13";
    CONST WEBSITEKEY = "PrivateK";
    CONST URL = "http://api.mondialrelay.com/Web_Services.asmx?WSDL";

    /** @var  ApiClient */
    private $client;

    public function setUp()
    {
        $this->client = new ApiClient(new \SoapClient("http://api.mondialrelay.com/Web_Services.asmx?WSDL"), self::WEBSITEID,self::WEBSITEKEY);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itShouldReturnAnExceptionInvalidParametersAreSent()
    {
        $this->client->findDeliveryPoints([]);
    }

    /**
     * @test
     */
    public function itShouldReturnAnEmptyStringIfNoPointsAreFound()
    {
        $points = $this->client->findDeliveryPoints(array(
            'Pays' => "ES",
            'Ville' => "",
            'CP' => '12345',
            'Latitude' => "",
            'Longitude' => "",
            'Taille' => "",
            'Poids' => "",
            'Action' => "",
            'DelaiEnvoi' => "0",
            'RayonRecherche' => "0"
        ));
        $this->assertEmpty($points);
    }

    /**
     * @test
     */
    public function itShouldReturnAnArrayOfPointsIfParametersMatch()
    {
        $points = $this->client->findDeliveryPoints(array(
            'Pays' => "ES",
            'Ville' => "",
            'CP' => '08915',
            'Latitude' => "",
            'Longitude' => "",
            'Taille' => "",
            'Poids' => "",
            'Action' => "",
            'DelaiEnvoi' => "0",
            'RayonRecherche' => "20"
        ));
        foreach($points as $point){
            $this->assertInstanceOf(Point::class, $point);
        }
    }

    /**
     * @test
     */
    public function itShouldReturnAValidPoint()
    {
        $point = $this->client->findDeliveryPoint('077712','ES');
        $this->assertInstanceOf(Point::class, $point);
    }
}
