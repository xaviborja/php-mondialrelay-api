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
            $this->checkResponse($result);
            $delivery_points = [];
            if (!property_exists($result->WSI3_PointRelais_RechercheResult->PointsRelais, 'PointRelais_Details')){
                return $delivery_points;
            }
            $label_position = 1;
            foreach($result->WSI3_PointRelais_RechercheResult->PointsRelais->PointRelais_Details as $destination_point){
                $delivery_points[] = new Point(
                    $destination_point->Num,
                    trim($destination_point->LgAdr1),
                    str_replace(",",".",$destination_point->Latitude),
                    str_replace(",",".",$destination_point->Longitude),
                    $destination_point->CP
                );
                $label_position++;
            }
            return $delivery_points;
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

    private function checkResponse($result)
    {
        if ($result->WSI3_PointRelais_RechercheResult->STAT != 0) {
            $request = $this->decorateRequest([
                'STAT_ID' => $result->WSI3_PointRelais_RechercheResult->STAT,
                'Langue' => 'ES',
            ]);
            $error_response = $this->client->WSI2_STAT_Label($request);
            throw new \InvalidArgumentException($error_response->WSI2_STAT_LabelResult);
        }
    }


}