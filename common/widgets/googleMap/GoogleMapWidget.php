<?php

namespace common\widgets\googleMap;

use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class GoogleMapWidget extends Widget
{
    public $key;
    public $id;
    public $coordinates;
    public $isDraggableMarker = false;
    public $isGetUserLocation = true;
    public $placeId;
    public $latId;
    public $langId;
    public $mapZoom = 15;
    public $mapCenter = false;

    public function init()
    {
        parent::init();
        $this->options['id'] = !is_null($this->id) ? $this->id : 'map';
        $url = "//maps.googleapis.com/maps/api/js?" . http_build_query([
                'key'       => $this->key,
                'signed_in' => true
            ]);
        $this->view->registerJsFile($url, [
            'position' => View::POS_END
        ]);
        GoogleMapAsset::register($this->view);
    }

    protected function registerClientOptions()
    {
        $options = Json::htmlEncode([
            'id'                => $this->options['id'],
            'coordinates'       => $this->coordinates,
            'isDraggableMarker' => $this->isDraggableMarker,
            'placeId'           => $this->placeId,
            'latId'             => $this->latId,
            'langId'            => $this->langId,
            'mapZoom'           => $this->mapZoom,
            'isGetUserLocation' => $this->isGetUserLocation,
            'mapCenter'         => $this->mapCenter
        ]);
        $js = "$().googleMap($options);";
        $this->getView()->registerJs($js);
    }

    public function run()
    {
        echo Html::tag('div', '', $this->options);
        $this->registerClientOptions();
    }
}