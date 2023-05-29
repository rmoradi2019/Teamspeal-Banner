<?php

    namespace Tivet\Banner;

    use Zend\Cache\Storage\Adapter\Filesystem;
    use Zend\Cache\StorageFactory;

    class Cache
    {
        /**
         * @var Filesystem
         */
        private static $cache;


        /**
         * @param $key
         * @param $value
         * @return bool
         */
        public static function set($key, $value)
        {
            return static::fileSystemCache()->setItem(md5($key), $value);
        }


        /**
         * @param $key
         * @param null $success
         * @param null $casToken
         * @return mixed
         */
        public static function get($key, & $success = null, & $casToken = null)
        {
            return static::fileSystemCache()->getItem(md5($key), $success, $casToken);
        }


        /**
         * @param $key
         * @return bool
         */
        public static function has($key)
        {
            return static::fileSystemCache()->hasItem(md5($key));
        }


        private static function fileSystemCache()
        {
            if (!static::$cache) {

                static::$cache = StorageFactory::factory([
                    'adapter' => [
                        'name'    => 'filesystem',
                        'options' => [
                            'ttl'       => conf('banner.cache_ttl'),
                            'cache_dir' => BASE_DIR . DIRECTORY_SEPARATOR . 'cache',
                        ]
                    ]
                ]);
            }

            return static::$cache;
        }
    }