 <div class="form-wrapper">
     <div class="section">
         <div class="url-section">
             <h2>Tambah Pengguna</h2>
             <span>|</span>
             <a href="#"><i class='bx bx-home-alt'></i></a>
             <span class="url-rout">></span>
             <a href="<?php echo Yii::app()->createUrl('site/userList'); ?>">Pengguna</a>
             <span class="url-rout">></span>
             <span>Tambah</span>
         </div>

         <div class="action-card-header">
             <h2>Informasi Pengguna</h2>
             <p>Pastikan data pengguna diisi dengan benar.</p>
         </div>
     </div>

     <div class="form-container">
         <?php echo CHtml::beginForm(); ?>

         <div class="form-group">
             <?php echo CHtml::label('Username', 'username'); ?>
             <?php echo CHtml::textField('Users[username]', $model->username); ?>
             <?php echo CHtml::error($model, 'username'); ?>
         </div>

         <div class="form-group">
             <?php echo CHtml::label('Password', 'password'); ?>
             <?php echo CHtml::passwordField('Users[password]'); ?>
             <?php echo CHtml::error($model, 'password'); ?>
         </div>

         <div class="form-group">
             <?php echo CHtml::label('Role', 'role'); ?>
             <?php echo CHtml::dropDownList('Users[role]', $model->role, array(
                    'Pendaftaran' => 'Pendaftaran',
                    'Dokter' => 'Dokter',
                    'Kasir' => 'Kasir',
                ), ['prompt' => '-- Pilih Role --']); ?>
             <?php echo CHtml::error($model, 'role'); ?>
         </div>

         <div class="form-group">
             <?php echo CHtml::label('Nama Lengkap', 'nama_lengkap'); ?>
             <?php echo CHtml::textField('Users[nama_lengkap]', $model->nama_lengkap); ?>
             <?php echo CHtml::error($model, 'nama_lengkap'); ?>
         </div>

         <div class="form-actions">
             <?php echo CHtml::submitButton('Simpan', ['class' => 'btn btn-save']); ?>
             <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
         </div>

         <?php echo CHtml::endForm(); ?>
     </div>
 </div>