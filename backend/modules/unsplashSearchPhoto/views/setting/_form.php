<?php

use common\models\SocialNetworkAccount;
use common\models\UnsplashSearchPhotoSetting;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\UnsplashSearchPhotoSetting $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="unsplash-search-photo-setting-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?= $form->errorSummary($model); ?>

                <?= $form->field($model, 'social_network_account_id')->dropDownList(
                    ArrayHelper::map(SocialNetworkAccount::find()->all(), 'id', 'name'),
                    ['prompt' => Yii::t('backend', 'Please select an item...')]
                ) ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'search')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'per_page')->textInput(['type' => 'number']) ?>

                <?= $form->field($model, 'orientation')->dropDownList(
                    UnsplashSearchPhotoSetting::ORIENTATION_LIST,
                    ['prompt' => Yii::t('backend', 'Please select an item...')]
                ) ?>

                <?= $form->field($model, 'collections')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'comment')->textarea() ?>

                <?= $form->field($model, 'is_active')->checkbox() ?>

            </div>
            <div class="card-footer">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
