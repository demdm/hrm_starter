<?php

/**
 * @var yii\web\View $this
 * @var common\models\SocialNetworkAccount $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Social Network Account',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Social Network Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="social-network-account-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
