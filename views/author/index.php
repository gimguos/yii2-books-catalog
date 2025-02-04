<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\search\AuthorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->can('manageBooks')) {
            echo Html::a('Создать автора', ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'full_name',
            [
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a('Подписаться на ' . $model->full_name, Url::toRoute(['subscription/subscribe', 'author_id' => $model->id]), [
                        'title' => 'Подписаться на ' . $model->full_name,
                    ]);
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'visibleButtons' => [
                    'view' => Yii::$app->user->can('viewBooks'),
                    'update' => Yii::$app->user->can('manageBooks'),
                    'delete' => Yii::$app->user->can('manageBooks'),
                ],
            ],
        ],
    ]); ?>


</div>
