<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

//use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback','autofocus' => 'autofocus',  'tabindex' => '1'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback','tabindex' => '2'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
//https://backend.newriched.com/site/auth?authclient=facebook
?>

<div class="row justify-content-center mt-5">

    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body">
                <h2 class="text-center mb-3 mt-3"><b>Newriched</b></h2>


                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>

                <?php if ($module->debug): ?>
                    <?= $form->field($model, 'login', [
                        'inputOptions' => [
                            'autofocus' => 'autofocus',
                            'class' => 'form-control',
                            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                    ?>

                <?php else: ?>

                    <?= $form->field($model, 'login',$fieldOptions1)->label('ชื่อผู้ใช้งานหรือ เบอร์โทรศัพท์');
                    ?>

                <?php endif ?>

                <?php if ($module->debug): ?>
                    <div class="alert alert-warning">
                        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                    </div>
                <?php else: ?>
                    <?= $form->field(
                        $model,
                        'password',
                        $fieldOptions2)
                        ->passwordInput()
                        ->label(
                            Yii::t('user', 'รหัสผ่าน')
                            . ($module->enablePasswordRecovery ?
                                ' (' . Html::a(
                                    Yii::t('user', 'ลืมรหัสผ่าน'),
                                    ['/user/recovery/request'],
                                    ['tabindex' => '5']
                                )
                                . ')' : '')
                        ) ?>
                <?php endif ?>
                 <?= Html::submitButton(
                    Yii::t('user', 'เข้าสู่ระบบ'),
                    ['class' => 'btn btn-primary btn-block btn-lg', 'tabindex' => '4']
                ) ?>

                <?php ActiveForm::end(); ?>
                
            </div>
            
            
        </div>
        
    </div>
     
</div>
<?php \appxq\sdii\widgets\CSSRegister::begin()?>
<style>

</style>
<?php \appxq\sdii\widgets\CSSRegister::end()?>


