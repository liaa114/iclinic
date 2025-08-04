<div class="login-wrapper">

  <div class="login-image">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/Login.png" alt="Ilustrasi Klinik" />
  </div>


  <div class="login-form">
    <h2>Login Klinik</h2>

    <?php echo CHtml::beginForm(); ?>

    <div class="form-group">
      <?php echo CHtml::activeLabel($model, 'role'); ?>
      <i class="fas fa-user-tag"></i>
      <?php echo CHtml::activeDropDownList($model, 'role', array(
        '' => '-- Pilih Role --',
        'Admin' => 'Admin',
        'Pendaftaran' => 'Pendaftaran',
        'Dokter' => 'Dokter',
        'Kasir' => 'Kasir'
      ), array('required' => true)); ?>
      <?php echo CHtml::error($model, 'role', array('class' => 'errorMessage')); ?>
    </div>

    <div class="form-group">
      <?php echo CHtml::activeLabel($model, 'username'); ?>
      <i class="fas fa-user"></i>
      <?php echo CHtml::activeTextField($model, 'username', array('placeholder' => 'Masukkan username', 'required' => true)); ?>
      <?php echo CHtml::error($model, 'username', array('class' => 'errorMessage')); ?>
    </div>

    <div class="form-group">
      <?php echo CHtml::activeLabel($model, 'password'); ?>
      <i class="fas fa-lock"></i>
      <?php echo CHtml::activePasswordField($model, 'password', array('placeholder' => 'Masukkan password', 'required' => true)); ?>
      <?php echo CHtml::error($model, 'password', array('class' => 'errorMessage')); ?>
    </div>

    <button type="submit">Masuk</button>

    <?php echo CHtml::endForm(); ?>
  </div>
</div>