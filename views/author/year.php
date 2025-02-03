<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

echo GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' => $years,
        'pagination' => false, // Отключаем пагинацию
    ]),
    'columns' => [
        [
            'attribute' => 'year',
            'label' => 'Год',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model['year'], Url::toRoute(['/author/top-authors', 'year' => $model['year']]), [
                    'title' => 'Топ 10 авторов за ' . $model['year'],
                ]);
            },
        ],
    ],
]);