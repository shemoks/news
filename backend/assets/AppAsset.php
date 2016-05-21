<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
     // 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBRJ2DjZT7emb_YBmtTxNd_rOSuB4CofSs&callback=initMap',
        //'https://maps.googleapis.com/maps/api/js?signed_in=true&callback=initMap',
      'js/googleAPI.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
