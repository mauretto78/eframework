<?php
/*
|--------------------------------------------------------------------------
| DI Services Definitions.
|--------------------------------------------------------------------------
*/

return [
    'Admin' => DI\object(\Framework\Framework\WP\Admin\Admin::class),
    'BaseForm' => DI\object(\Framework\Framework\Form\BaseForm::class),
    'BootstrapForm' => DI\object(\Framework\Framework\Form\BootstrapForm::class),
    'Breadcrumbs' => DI\object(\Framework\Framework\WP\Breadcrumbs::class),
    'Enqueuer' => DI\object(\Framework\Framework\WP\Enqueuer::class),
    'Lessify' => DI\object(\Framework\Framework\Lessify::class),
    'Mailer' => function () {
        return new \Framework\Framework\Mailer\MailerManager('Swiftmailer');
    },
    'Nav' => DI\object(\Framework\Framework\WP\Nav\Nav::class),
    'Pag' => DI\object(\Framework\Framework\WP\Pag::class),
    'Path' => DI\object(\Framework\Framework\WP\Path::class),
    'Query' => DI\object(\Framework\Framework\WP\Query::class),
    'Session' => DI\object(\Framework\Framework\Session\SessionBridge::class),
    'Sluggify' => DI\object(\Framework\Framework\Sluggify::class),
    'Support' => DI\object(\Framework\Framework\WP\Support::class),
    'Theme' => DI\object(\Framework\Framework\WP\Theme::class),
    'Validator' => function (\Framework\Framework\Validator\ErrorHandler $errorHandler, \Symfony\Component\HttpFoundation\Request $request) {
        return new \Framework\Framework\Validator\Validator($errorHandler, $request);
    },
];
