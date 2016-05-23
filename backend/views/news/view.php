<?php

use common\widgets\googleMap\GoogleMapWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'title',
            'description:ntext',
            'created_at',
            'updated_at',
            'date_begin',
            'date_end',
        ],
    ]) ?>

    <?= GoogleMapWidget::widget([
            'key'               => Yii::$app->params['googleApiKey'],
            'isGetUserLocation' => false,
            'coordinates'       => [
                [
                    'lat'   => $model->latitude,
                    'lan'   => $model->longitude,
                    'title' => nl2br($model->title."\n\r"."lat:".$model->latitude."\n\r"."long:".$model->longitude),
                ]
            ],
        ]
    ); ?>
</div>
