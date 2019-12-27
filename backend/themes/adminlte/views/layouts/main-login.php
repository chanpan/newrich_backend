<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" >
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $baseUrl = $this->theme->baseUrl;?>
    <link rel="stylesheet" href="<?= $baseUrl;?>/css/custom.css"/>
</head>
<body class="login-page" style="background: url('<?= \yii\helpers\Url::to('@web/img/bg5.jpg')?>'); background-attachment: fixed;background-position: center;background-size: cover;">

    <?php $this->beginBody() ?>
        <div class="container">
            <h3 class="text-center" style="color: #fff;font-family: serif;    font-weight: bold;"><?= isset(Yii::$app->params['name_app'])?Yii::$app->params['name_app']:''?></h3>
            <?= $content ?>
        </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
