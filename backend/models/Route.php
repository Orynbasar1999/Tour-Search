<?php

namespace backend\models;





/**
 * This is the model class for table "route".
 *
 * @property int $id
 * @property int $city_id
 * @property int $country_id
 *
 * @property Country $country
 * @property City $city
 */
class Route extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'country_id'], 'required'],
            [['city_id', 'country_id'], 'integer'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'country_id' => 'Country ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public static function getCitiesList() {
        $cities = Route::find()->distinct()->all();
        $citiesArray = array();
        $i = 0;
        foreach ($cities as $city) {
            $citiesArray[$i]['id'] = $city->city->id;
            $citiesArray[$i]['name'] = $city->city->name;
            $i++;
        }
        return $citiesArray;
    }
}
