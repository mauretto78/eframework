<?php

return [
    'BaseForm' => DI\object(\Framework\Framework\Form\BaseForm::class),
    'BootstrapForm' => DI\object(\Framework\Framework\Form\BootstrapForm::class),
    'Form' => DI\object(\Framework\Framework\Form\BaseForm::class),
    'Lessify' => DI\object(\Framework\Framework\Lessify::class),
    'Mailer' => DI\object(\Framework\Framework\Mailer\Mailer::class),
    'Sluggify' => DI\object(\Framework\Framework\Sluggify::class),
    'Validator' => DI\object(\Framework\Framework\Validator\Validator::class),
];
