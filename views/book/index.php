<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (Yii::$app->user->can('manageBooks')) {
            echo Html::a('Создать книгу', ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'cover_image',
                'label' => 'Фото обложки',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::img($data->getPhotoUrl(), ['width' => '70px']);
                },
            ],
//            'id',
            'title',
            'year',
            'description:ntext',
            'isbn',
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
