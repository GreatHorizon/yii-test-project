<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>
    <br>
    <?= $form->field($model, 'authorId')->textInput() ?>
    <br>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <br>
    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
