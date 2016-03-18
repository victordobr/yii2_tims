<?php

use kartik\select2\Select2;

?>

<div class="row">
    <?= $form->field($model, 'filter_author_id')->label(false)->widget(Select2::classname(), [
        'data' => $model->getAuthorList(),
        'options' => [
            'placeholder' => 'Select a bus number ...',
        ],
        'pluginOptions' => [
            'theme' => Select2::THEME_BOOTSTRAP,
            'multiple' => false,
            'maximumInputLength' => 10,
            'allowClear' => true,
        ],
    ]);
    ?>
</div>