<?php


namespace app\controllers;


use app\services\LocationService;
use Yii;
use yii\web\Response;

;

class LocationController extends SecuredController
{
    /**
     * Getting string with address (like: Россия, Абаза, Спортивная 4)
     * and return json with
     * @param string $geocode
     * @return array
     * @throws \Exception
     */
    public function actionGeocode(string $geocode): array
    {
        $locationService = new LocationService();
        Yii::$app->response->format = Response::FORMAT_JSON;

      return  $locationService->getLocation($geocode);
    }
}