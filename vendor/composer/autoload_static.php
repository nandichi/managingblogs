<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit44ff330c478847ee05d6907283fd4b4d
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Parsedown' => 
            array (
                0 => __DIR__ . '/..' . '/erusev/parsedown',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit44ff330c478847ee05d6907283fd4b4d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit44ff330c478847ee05d6907283fd4b4d::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit44ff330c478847ee05d6907283fd4b4d::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit44ff330c478847ee05d6907283fd4b4d::$classMap;

        }, null, ClassLoader::class);
    }
}
