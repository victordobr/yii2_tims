<?php

use kartik\select2\Select2;

?>

<div class="row">
    <?= $form->field($model, 'filter_bus_number')->label(false)->widget(Select2::classname(), [
            'data' => $model->getBusNumberList(),
            'options' => [
                'placeholder' => 'Select a bus number ...',
            ],
            'pluginOptions' => [
                'theme' => Select2::THEME_BOOTSTRAP,
                'multiple' => true,
                'maximumInputLength' => 10,
                'allowClear' => true,
            ],
        ]);
    ?>
</div>
