<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

$this->title='ส่วนลดเงินคืน';
?>

<div class="refund-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <h2><?= Html::encode($this->title)?></h2>
    <hr>
    <div>
	 <div class="mb-3">
         <label>ชื่อลูกค้า: <b><?= \backend\lib\CNUtils::getUserById($model->user_id)?></b></label>

     </div>


    <div class="row">
        <div class="col-md-6">	<?= $form->field($model, 'order_id')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">	<?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'status')->inline()->radioList(['1'=>'อนุมัติ','0'=>'ไม่อนุมัติ']) ?>

            </div>
            <div class="col-md-6">

                <?= $form->field($model, 'payment')->inline()->radioList(['1'=>'โอนแล้ว','0'=>'รอโอน']) ?>

            </div>
        </div>

    </div>
    <div class="modal-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'ยืนยัน'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-submit' : 'btn btn-primary btn-lg btn-submit']) ?>

    </div> 

    <?php ActiveForm::end(); ?>

</div>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
    $('.btn-submit').prepend('<span class="icon-spin"><i class="fa fa-spinner fa-spin"></i></span> ');
    $('.btn-submit').attr('disabled',true);

    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        $('.btn-submit .icon-spin').remove();
        $('.btn-submit').attr('disabled',false);
        if(result.status == 'success') {
            swal({
                title: result.message,
                text: result.message,
                type: result.status,
                timer: 1000
            });
            $(document).find('#modal-refund').modal('hide');
            $.pjax.reload({container:'#refund-grid-pjax'});

        } else {
            swal({
                title: result.message,
                text: result.message,
                type: result.status,
                timer: 1000
            });
        } 
    }).fail(function() {
        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
        console.log('server error');
    });
    return false;
});
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>