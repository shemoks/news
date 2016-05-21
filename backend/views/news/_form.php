<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">
    <?php $form = ActiveForm::begin();?>
    <input type="text" id="us2-address" style="width: 200px"/>
    <br>
    <input type="text" id="us2-radius"/>
    <br>
    <input type="text" id="us2-lat"/>
    <br>
    <input type="text" id="us2-lon"/>
    <br>





    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_begin')->widget(DateTimePicker::classname(), [
        'options'       => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'date_end')->widget(DateTimePicker::classname(), [
        'options'       => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'place')->widget('\pigolab\locationpicker\CoordinatesPicker' , [
        'key' => 'AIzaSyBRJ2DjZT7emb_YBmtTxNd_rOSuB4CofSs' ,
        'valueTemplate' => '{latitude},{longitude}' , // Optional , this is default result format
        'options' => [
            'style' => 'width: 100%; height: 400px',  // map canvas width and height
        ] ,
        'enableSearchBox' => false, // Optional , default is true
        'searchBoxOptions' => [ // searchBox html attributes
            'style' => 'width: 300px;', // Optional , default width and height defined in css coordinates-picker.css
        ],
        'mapOptions' => [
            // set google map optinos
            'rotateControl' => true,
            'scaleControl' => false,
            'streetViewControl' => true,
            'mapTypeId' => new JsExpression('google.maps.MapTypeId.SATELLITE'),
            'heading'=> 90,
            'tilt' => 45 ,
            'mapTypeControl' => true,
            'mapTypeControlOptions' => [
                'style'    => new JsExpression('google.maps.MapTypeControlStyle.HORIZONTAL_BAR'),
                'position' => new JsExpression('google.maps.ControlPosition.TOP_CENTER'),
            ]
        ],
        'clientOptions' => [
            // 'radius'    => 300,
            'location' => [
                'latitude'  =>  49.4285400 ,
                'longitude' => 32.0620700,
            ],
            'inputBinding' => [
                'latitudeInput'     => new JsExpression("$('#us2-lat')"),
                'longitudeInput'    => new JsExpression("$('#us2-lon')"),
                'radiusInput'       => new JsExpression("$('#us2-radius')"),
                'locationNameInput' => new JsExpression("$('#us2-address')")
            ]
        ]
    ])
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
