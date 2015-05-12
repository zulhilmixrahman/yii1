<div class="alert alert-danger" role="alert">
    <strong>Ralat Sistem</strong>
    <br /><br />
    <?php
    if ($error['code'] == '404') {
        echo Yii::t('common', 'Halaman tidak ditemui.');
    } else {
        echo Yii::t('common', 'Terdapat ralat sistem. Sila hubungi Pentadbir Sistem.');
    }
    ?>
</div>