<?php

namespace MondialRelay;

class ApiClient
{

    private $websiteId;
    private $websiteKey;
    private $client;

    public function __construct(\SoapClient $soapClient, $websiteId, $websiteKey)
    {
        $this->websiteId = $websiteId;
        $this->websiteKey = $websiteKey;
        $this->client = $soapClient;
    }

    public function findDeliveryPoints(array $request)
    {
        try{
            $request = $this->decorateRequest($request);
            $result = $this->client->WSI3_PointRelais_Recherche($request);
            $this->checkResponse('WSI3_PointRelais_Recherche',$result);
            $delivery_points = [];
            if (!property_exists($result->WSI3_PointRelais_RechercheResult->PointsRelais, 'PointRelais_Details')){
                return $delivery_points;
            }
            $label_position = 1;
            if (is_object($result->WSI3_PointRelais_RechercheResult->PointsRelais->PointRelais_Details)){
                return $this->createPoint($result->WSI3_PointRelais_RechercheResult->PointsRelais->PointRelais_Details);
            }
            foreach($result->WSI3_PointRelais_RechercheResult->PointsRelais->PointRelais_Details as $destination_point){
                $delivery_points[] = $this->createPoint($destination_point);
                $label_position++;
            }
            return $delivery_points;
        } catch ( \SoapFault $e ) {
            throw new \Exception();
        }

    }

    public function findDeliveryPoint($id, $country)
    {
        try {
            return $this->findDeliveryPoints(array(
                'NumPointRelais' => $id,
                'Pays' => $country
            ));

        } catch ( \SoapFault $e ) {
            throw new \Exception();
        }
    }

    private function decorateRequest($request)
    {
        $key = $this->websiteId;
        foreach($request as $parameter => $value){
            $key .= $value;
        }
        $key .= $this->websiteKey;
        $request['Enseigne'] = $this->websiteId;
        $request['Security'] = strtoupper(md5($key));
        return $request;
    }

    private function checkResponse($method, $result)
    {
        $method = $method . "Result";
        if ($result->{$method}->STAT != 0) {
            $request = $this->decorateRequest([
                'STAT_ID' => $result->{$method}->STAT,
                'Langue' => 'ES',
            ]);
            $error_response = $this->client->WSI2_STAT_Label($request);
            throw new \InvalidArgumentException($error_response->WSI2_STAT_LabelResult);
        }
    }

    private function createPoint($response) {
        return new Point(
            $response->Num,
            trim($response->LgAdr1),
            str_replace(",",".",$response->Latitude),
            str_replace(",",".",$response->Longitude),
            $response->CP
        );
    }

}