<?php

namespace common\widgets\googleMap;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class GoogleMapAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/googleMap/assets';
    public $publishOptions = [
        'forceCopy' => true
    ];
    public $css = [
    ];
    public $js = [
        'js/googleAPI.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
