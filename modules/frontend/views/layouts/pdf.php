<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 */

?>
<?php $this->beginPage() ?>

<body>
<?php $this->beginBody() ?>

            <?= $content ?>


<footer class="footer">
    <div class="container">
        <p class="pull-left">Report generated on: Nov 3, 2015 10:30 AM</p>

        <p class="pull-right"><img src="/images/splogo-black-dot-back.jpg" alt="splogo" height="47"></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
