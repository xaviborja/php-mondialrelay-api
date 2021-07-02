<?php

namespace MondialRelay;

use MondialRelay\Expedition\Expedition;
use MondialRelay\Point\Point;
use MondialRelay\Ticket\Ticket;

class ApiClientTest extends \PHPUnit_Framework_TestCase
{

    CONST WEBSITEID = "BDTEST13";
    CONST WEBSITEKEY = "PrivateK";
    CONST URL = "http://api.mondialrelay.com/Web_Services.asmx?WSDL";

    /** @var  ApiClient */
    private $client;

    public function setUp()
    {
        $this->client = new ApiClient(new \SoapClient("http://api.mondialrelay.com/Web_Services.asmx?WSDL"),
            self::WEBSITEID, self::WEBSITEKEY);
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
                                                  'NumPointRelais' => "077712",
                                                  'Ville' => "",
                                                  'CP' => "08915",
                                                  'Latitude' => "",
                                                  'Longitude' => "",
                                                  'Taille' => "",
                                                  'Poids' => "",
                                                  'Action' => "",
                                                  'DelaiEnvoi' => "0",
                                                  'RayonRecherche' => "20"
                                              ));
        foreach ($points as $point) {
            $this->assertInstanceOf(Point::class, $point);
        }
    }

    /**
     * @test
     */
    public function itShouldReturnAValidPoint()
    {
        $point = $this->client->findDeliveryPoint('44431', 'ES');
        $this->assertInstanceOf(Point::class, end($point));
    }

    /**
     * @test
     */
    public function itShouldReturnAValidExpedition()
    {
        $expedition = $this->client->createExpedition(array(
            'ModeCol' => 'CCC', /*^(CCC|CDR|CDS|REL)$*/
            'ModeLiv' => '24R', /*^(LCC|LD1|LDS|24R|24L|24X|ESP|DRI)$*/
            'NDossier' => '55415',
            'NClient' => '147014',
            'Expe_Langage' => 'ES',
            'Expe_Ad1' => 'Albert',
            'Expe_Ad2' => '',
            'Expe_Ad3' => 'Calle Falsa',
            'Expe_Ad4' => '123',
            'Expe_Ville' => 'Granollers',
            'Expe_CP' => '08402',
            'Expe_Pays' => 'ES',
            'Expe_Tel1' => '+34666234566',
            'Expe_Tel2' => '',
            'Expe_Mail' => 'pepe@test.com',
            'Dest_Langage' => 'ES',
            'Dest_Ad1' => 'Client1',
            'Dest_Ad2' => 'LLIBRERIA CASABELLA',
            'Dest_Ad3' => 'AV PUIG I CADAFALCH',
            'Dest_Ad4' => '10',
            'Dest_Ville' => 'Granollers',
            'Dest_CP' => '08402',
            'Dest_Pays' => 'ES',
            'Dest_Tel1' => '',
            'Dest_Mail' => 'test@test.com',
            'Poids' => '123',
            'Longueur' => '1',
            'Taille' => 'XL',
            'NbColis' => '1',
            'CRT_Valeur' => '1780',
            'CRT_Devise' => 'EUR',
            'Exp_Valeur' => '1780',
            'Exp_Devise' => 'EUR',
            'COL_Rel_Pays' => 'ES',
            'COL_Rel' => '0000',
            'LIV_Rel_Pays' => 'ES',
            'LIV_Rel' => '44431',
            'TAvisage' => 'N',
            'TReprise' => 'N',
            'Montage' => '0',
            'TRDV' => 'N',
            'Instructions' => '0',
            'Assurance' => ''
        ));
        $this->assertInstanceOf(Expedition::class, $expedition);
    }

    /**
     * @test
     */
    public function itShouldReturnAValidTicket()
    {
        $ticket = $this->client->generateTickets(array(
            'Expeditions' => '12345678', /*^[0-9]{8}(;[0-9]{8})*$*/
            'Langue' => 'ES' /*^[A-Z]{2}$*/
        ));

        $this->assertInstanceOf(Ticket::class, $ticket);
    }


    /**
     * @test
     */
    public function itShouldReturnAnArrayOfValidTickets()
    {
        $tickets = $this->client->generateTickets(array(
            'Expeditions' => '12345678;87654321', /*^[0-9]{8}(;[0-9]{8})*$*/
            'Langue' => 'ES' /*^[A-Z]{2}$*/
        ));

        foreach ($tickets as $ticket) {
            $this->assertInstanceOf(Ticket::class, $ticket);
        }
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itShouldReturnAnExceptionInvalidParametersOfTicketsAreSent()
    {
        $this->client->generateTickets([]);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itShouldReturnAnExceptionInvalidParametersOfExpeditionsAreSent()
    {
        $this->client->createExpedition([]);
    }

}
