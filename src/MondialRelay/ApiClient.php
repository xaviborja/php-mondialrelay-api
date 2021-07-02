<?php

namespace MondialRelay;

use MondialRelay\Expedition\ExpeditionFactory;
use MondialRelay\Point\PointFactory;
use MondialRelay\Ticket\TicketFactory;

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
        try {
            $request = $this->decorateRequest($request);
            $result = $this->client->WSI3_PointRelais_Recherche($request);
            $pointFactory = new PointFactory();
            $this->checkResponse('WSI3_PointRelais_Recherche', $result);
            $delivery_points = [];
            if (!property_exists($result->WSI3_PointRelais_RechercheResult->PointsRelais, 'PointRelais_Details')) {
                return $delivery_points;
            }
            if (is_object($result->WSI3_PointRelais_RechercheResult->PointsRelais->PointRelais_Details)) {
                $delivery_points[] = $pointFactory->create($result->WSI3_PointRelais_RechercheResult->PointsRelais->PointRelais_Details);
                return $delivery_points;
            }
            foreach ($result->WSI3_PointRelais_RechercheResult->PointsRelais->PointRelais_Details as $destination_point) {
                $delivery_points[] = $pointFactory->create($destination_point);
            }
            return $delivery_points;
        } catch (\SoapFault $e) {
            throw new \Exception($e->GetMessage());
        }

    }

    public function findDeliveryPoint($id, $country)
    {
        try {
            return $this->findDeliveryPoints(array(
                'NumPointRelais' => $id,
                'Pays' => $country
            ));

        } catch (\SoapFault $e) {
            throw new \Exception();
        }
    }

    private function decorateRequest($request)
    {
        $key = $this->websiteId;
        foreach ($request as $parameter => $value) {
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

    public function createExpedition(array $request)
    {
        try {

            $request = $this->decorateRequest($request);
            $result = $this->client->WSI2_CreationExpedition($request);
            $this->checkResponse('WSI2_CreationExpedition', $result);

            return (new ExpeditionFactory())->create($result->WSI2_CreationExpeditionResult->STAT,
                $result->WSI2_CreationExpeditionResult->ExpeditionNum,
                $result->WSI2_CreationExpeditionResult->TRI_AgenceCode,
                $result->WSI2_CreationExpeditionResult->TRI_Groupe,
                $result->WSI2_CreationExpeditionResult->TRI_Navette,
                $result->WSI2_CreationExpeditionResult->TRI_Agence,
                $result->WSI2_CreationExpeditionResult->TRI_TourneeCode,
                $result->WSI2_CreationExpeditionResult->TRI_LivraisonMode,
                $result->WSI2_CreationExpeditionResult->CodesBarres->string);

        } catch (\SoapFault $e) {
            throw new \Exception();
        }
    }

    public function generateTickets(array $request)
    {

        try {

            $request = $this->decorateRequest($request);
            $result = $this->client->WSI3_GetEtiquettes($request);
            $this->checkResponse('WSI3_GetEtiquettes', $result);

            return (new TicketFactory())->create($result->WSI3_GetEtiquettesResult->STAT,
                $result->WSI3_GetEtiquettesResult->URL_PDF_A4,
                $result->WSI3_GetEtiquettesResult->URL_PDF_A5,
                $result->WSI3_GetEtiquettesResult->URL_PDF_10x15);

        } catch (\SoapFault $e) {
            throw new \Exception();
        }
    }

}
