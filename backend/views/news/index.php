<?php

use common\models\News;
use common\widgets\googleMap\GoogleMapWidget;
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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title',
            'description:ntext',
//            'created_at',
//            'updated_at',
            // 'is_deleted',
            [
                'attribute' => 'id_user',
                'format'    => 'raw',
                'value'     => function ($model) {
                    $model::setCoordinates([
                        'lat' => $model->latitude,
                        'lan' => $model->longitude
                    ]);
                    return $model->idUser->username;
                }
            ],
            'date_begin',
            'date_end',
            'place',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?= GoogleMapWidget::widget([
        'key'               => Yii::$app->params['googleApiKey'],
        'coordinates'       => News::getCoordinates(),
        'isGetUserLocation' => false,
        'mapCenter' => false,
    ]
); ?>
