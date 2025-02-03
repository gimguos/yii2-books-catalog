<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Author;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'], // Для загрузки файлов
]);

echo $form->field($model, 'title')->textInput(['maxlength' => true]);
echo $form->field($model, 'year')->textInput(['type' => 'number']);
echo $form->field($model, 'description')->textarea(['rows' => 6]);
echo $form->field($model, 'isbn')->textInput(['maxlength' => true]);

// Поле для выбора автора (многие-ко-многим)
// todo доделать автозаполнение и уникальность имени картинки
echo $form->field($model, 'authorIds')->checkboxList(
    ArrayHelper::map(Author::find()->all(), 'id', 'full_name'),
    ['separator' => '<br>']
);

echo Html::img('@web/img/uploads/' . $model->cover_image, ['title' => $model->title, 'style' => 'width:200px; height:200px;']);
// Поле для загрузки картинки
echo $form->field($model, 'imageFile')->fileInput();

echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);

ActiveForm::end();