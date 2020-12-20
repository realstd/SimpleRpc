<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd39961f08ec8548aadd871f2d640b35c
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SimpleRpc\\' => 10,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SimpleRpc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/framework/SimpleRpc',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Application',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd39961f08ec8548aadd871f2d640b35c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd39961f08ec8548aadd871f2d640b35c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
