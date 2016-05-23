<?php

use common\models\News;
use common\widgets\googleMap\GoogleMapWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest) {
            echo Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']);
        } ?>
    </p>
    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        'title',
        'description:ntext',
        [
            'attribute' => 'id_user',
            'format'    => 'raw',
            'value'     => function ($model) {
                $model::setCoordinates([
                    'lat'   => $model->latitude,
                    'lan'   => $model->longitude,
                    'title' => $model->title,
                ]);
                return $model->idUser->username;
            }
        ],
        'date_begin',
        'date_end',
        'place',
    ];
    if (!Yii::$app->user->isGuest) {
        array_push($columns, ['class' => 'yii\grid\ActionColumn']);
    }
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => $columns
    ]); ?>
</div>

<?= GoogleMapWidget::widget([
        'key'               => Yii::$app->params['googleApiKey'],
        'coordinates'       => News::getCoordinates(),
        'isGetUserLocation' => false,
    ]
); ?>
