<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1a235033fcf9544d115d809a7a632473
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sips\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sips\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/Sips',
        ),
    );

    public static $classMap = array (
        'Sips\\HttpClient' => __DIR__ . '/../..' . '/lib/Sips/Httpclient.php',
        'Sips\\Normalizer' => __DIR__ . '/../..' . '/lib/Sips/Normalizer.php',
        'Sips\\Passphrase' => __DIR__ . '/../..' . '/lib/Sips/Passphrase.php',
        'Sips\\PaymentRequest' => __DIR__ . '/../..' . '/lib/Sips/PaymentRequest.php',
        'Sips\\PaymentResponse' => __DIR__ . '/../..' . '/lib/Sips/PaymentResponse.php',
        'Sips\\ShaComposer\\AllParametersShaComposer' => __DIR__ . '/../..' . '/lib/Sips/ShaComposer/AllParametersShaComposer.php',
        'Sips\\ShaComposer\\ShaComposer' => __DIR__ . '/../..' . '/lib/Sips/ShaComposer/ShaComposer.php',
        'Sips\\SipsCurrency' => __DIR__ . '/../..' . '/lib/Sips/SipsCurrency.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1a235033fcf9544d115d809a7a632473::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1a235033fcf9544d115d809a7a632473::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1a235033fcf9544d115d809a7a632473::$classMap;

        }, null, ClassLoader::class);
    }
}
