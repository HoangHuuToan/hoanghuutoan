<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1c68f497b6fb910f7439ba332981f62d
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mytest\\' => 7,
        ),
        'C' => 
        array (
            'Connect_DB\\' => 11,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mytest\\' => 
        array (
            0 => __DIR__ . '/../..' . '/mytest',
        ),
        'Connect_DB\\' => 
        array (
            0 => __DIR__ . '/../..' . '/connect_DB',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1c68f497b6fb910f7439ba332981f62d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1c68f497b6fb910f7439ba332981f62d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1c68f497b6fb910f7439ba332981f62d::$classMap;

        }, null, ClassLoader::class);
    }
}
