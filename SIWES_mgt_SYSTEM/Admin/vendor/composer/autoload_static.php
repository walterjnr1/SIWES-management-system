<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb5b358db628a580d4f85b4dc0121c2ac
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb5b358db628a580d4f85b4dc0121c2ac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb5b358db628a580d4f85b4dc0121c2ac::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb5b358db628a580d4f85b4dc0121c2ac::$classMap;

        }, null, ClassLoader::class);
    }
}
