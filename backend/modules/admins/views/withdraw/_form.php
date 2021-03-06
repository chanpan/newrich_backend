<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model backend\modules\admins\models\Withdraw */
/* @var $form yii\bootstrap\ActiveForm */
$this->title = 'ถอนเงิน';
?>

    <div class="card">
        <div class="card-header"><?= $this->title;?></div>
        <div class="card-body">

            <?php $form = ActiveForm::begin([
                'id' => $model->formName(),
                'options' => ['enctype'=>'multipart/form-data']
            ]); ?>
            <div >
                <div class="mb-3">
                    <label>ชื่อลูกค้า: <b><?= \backend\lib\CNUtils::getUserById($model->user_id) ?></b></label>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'status')->inline()->radioList(\backend\lib\CNUtils::$statusWithdraw) ?>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
                    </div>
                </div>

            </div>
            <div class="text-right">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'ยืนยัน'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-submit' : 'btn btn-primary btn-lg btn-submit']) ?>

            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>
        // JS script
        $('form#<?= $model->formName()?>').on('beforeSubmit', function (e) {
            $('.btn-submit').prepend('<span class="icon-spin"><i class="fa fa-spinner fa-spin"></i></span> ');
            $('.btn-submit').attr('disabled', true);

            var $form = $(this);
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
                success: function (result) {
                    $('.btn-submit .icon-spin').remove();
                    $('.btn-submit').attr('disabled', false);

                    if (result.status == 'success') {
                        swal({
                            title: '',
                            text: result.message,
                            type: result.status,
                            timer: 1000
                        });
                        setTimeout(function () {
                            location.href = '<?= \yii\helpers\Url::to(['/admins/withdraw'])?>';
                        }, 1000);

                    } else {
                        swal({
                            title: '',
                            text: result.message,
                            type: result.status,
                            //timer: 1000
                        });
                    }
                }
            });
            return false;
        });
    </script>
<?php \richardfan\widget\JSRegister::end(); ?>
