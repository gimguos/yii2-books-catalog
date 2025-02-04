<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Author;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

echo $form->field($model, 'title')->textInput(['maxlength' => true]);
echo $form->field($model, 'year')->textInput(['type' => 'number']);
echo $form->field($model, 'description')->textarea(['rows' => 6]);
echo $form->field($model, 'isbn')->textInput(['maxlength' => true]);
// todo доделать выбранные
echo $form->field($model, 'authorIds')->checkboxList(
    ArrayHelper::map(Author::find()->all(), 'id', 'full_name'),
    ['separator' => '<br>']
);
echo $form->field($model, 'cover_image')->fileInput();

echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);

ActiveForm::end();