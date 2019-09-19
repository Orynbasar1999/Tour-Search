<?php

namespace backend\controllers;

use frontend\models\SearchTourForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\httpclient\Client;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new SearchTourForm();
        if(\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())){

            $partnerGet = new Client();
            $responseJson = $partnerGet->createRequest()->setMethod('GET')->setUrl('https://ht.kz/test/searchPartner1')->setData([
                'departCity' => $model->depCity,
                'country' => $model->arrCountry,
                'date' => $model->date,
                'nights' => $model->numOfNights
            ])->send();

            $responseJsonData = $responseJson->getData();

            $partnerPost = new Client();
            $responseXml = $partnerPost->createRequest()->setMethod('POST')->setUrl('https://ht.kz/test/searchPartner2')->setData([
                'cityId' => $model->depCity,
                'countryId' => $model->arrCountry,
                'dateFrom' => $model->date,
                'nights' => $model->numOfNights
            ])->send();


            $responseXmlData = $responseXml->getData();

            $i = 0;
            $resultArray = array();
            foreach ($responseJsonData['tours'] as $tour) {
                $resultArray[$i]['hotelName'] = $tour['hotelName'];
                $resultArray[$i]['partnerName'] = 1;
                $resultArray[$i]['price'] = $tour['price'].$tour['currency'];
                $i++;
            }
            foreach ($responseXmlData['tours'] as $tour) {
                $resultArray[$i]['hotelName'] = $tour['hotel'];
                $resultArray[$i]['partnerName'] = 2;
                $resultArray[$i]['price'] = $tour['tourPrice'].$tour['currency'];
                $i++;
            }

            ArrayHelper::multisort($resultArray, 'price', SORT_ASC);
            $resultJson = Json::encode($resultArray);


            return $resultJson;

        }

    }

}
