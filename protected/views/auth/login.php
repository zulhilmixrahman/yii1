<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'contents-register-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form',
    ))
);
?>
<div class="form-group">
    <label class="col-lg-2 control-label">ID Pengguna</label>
    <div class="col-lg-4">
        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'autocomplete' => 'off')); ?> 
        <?php echo $form->error($model, 'username', array('class' => 'text-danger')); ?> 
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label">Katalaluan</label>
    <div class="col-lg-4">
        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
        <?php echo $form->error($model, 'password', array('class' => 'text-danger')); ?> 
    </div>
</div>
<div id="buttonSection" class="form-group">
    <div class="col-sm-offset-2 col-sm-4 text-center">
    <button type="submit" class="btn btn-primary">Masuk</button> 
    <button type="button"  class="btn btn-danger" onclick="location.href='<?php echo Yii::app()->homeUrl ?>';">Batal</button>
    </div>
</div>
<?php $this->endWidget(); ?>
