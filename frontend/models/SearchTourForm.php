<?php


namespace frontend\models;

use yii\base\Model;

class SearchTourForm extends Model
{
    public $depCity;
    public $arrCountry;
    public $date;
    public $numOfNights;

    public function rules()
    {
        return [
            [['depCity', 'arrCountry', 'date', 'numOfNights'], 'required'],
        ];
    }


}