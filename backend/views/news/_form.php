<?php

use common\widgets\googleMap\GoogleMapWidget;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_begin')->widget(DateTimePicker::classname(), [
        'options'       => ['placeholder' => 'Enter event time ...'],
        'readonly'      => true,
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'date_end')->widget(DateTimePicker::classname(), [
        'options'       => ['placeholder' => 'Enter event time ...'],
        'readonly'      => true,
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>
    <?= $form->field($model, 'place')->input('string') ?>
    <?= $form->field($model, 'latitude')->input('string')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'longitude')->input('string')->hiddenInput()->label(false) ?>
    <?php
    $options['key'] = Yii::$app->params['googleApiKey'];
    $options['isDraggableMarker'] = true;
    $options['isGetUserLocation'] = $model->isNewRecord;
    $options['mapCenter'] = !$model->isNewRecord;
    $options['placeId'] = 'news-place';
    $options['latId'] = 'news-latitude';
    $options['langId'] = 'news-longitude';
    if (!$model->isNewRecord) {
        $options['coordinates'][] = [
            'lat' => $model->latitude,
            'lan' => $model->longitude];
    }
    echo GoogleMapWidget::widget($options); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
