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
        <?= Html::a('Создать книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'cover_image',
                'format' => 'html',
                'label' => 'Изображение',
                'value' => function ($model) {
                    // Путь к изображению по умолчанию
                    $defaultImage = '/img/default-image.jpg';
                    $uploadPath = Yii::getAlias('@webroot/img/uploads');
                    $filePath = $uploadPath . '/' . $model->cover_image;
                    // Проверка на наличие изображения
                    $imagePath = is_file($filePath) ? '@web/img/uploads/' . $model->cover_image : $defaultImage;
                    return Html::img($imagePath, ['title' => $model->title, 'style' => 'width:100px; height:100px;']);
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
