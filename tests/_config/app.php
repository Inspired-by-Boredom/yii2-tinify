<?php
return [
    'id' => 'test-app',
    'class' => 'yii\console\Application',

    'basePath' => Yii::getAlias('@tests'),
    'vendorPath' => Yii::getAlias('@vendor'),
    'runtimePath' => Yii::getAlias('@tests/_output'),

    'bootstrap' => [],
];