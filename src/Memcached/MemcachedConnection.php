<?php
/**
 * Created by    Gabriel Andrei gabrielandrei79@gmail.com
 * Date:         20/08/18
 * Time:         14:29
 */

class MemcachedConnection
{
    /**
     * @var MemcachedConnection
     */
    private static $instance = null;
    /**
     * @var \Memcached
     */
    private static $connection;

    /**
     * MemcachedConnection constructor.
     */
    private function __construct()
    {
        self::$connection = new \Memcached();
    }

    /**
     * @return MemcachedConnection|null
     */
    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new MemcachedConnection();
        }

        return self::$instance;
    }

    /**
     * @return Memcached
     */
    public static function getConnection(): \Memcached
    {
        return self::$connection;
    }



    /**
     * @param $host
     * @param $port
     */
    public static function addServer($host,$port){
        $servers = self::$connection->getServerList();
        if(count($servers)>0){
            foreach($servers as $s){
                if($s['host'] == $host && $s['port'] = $port){
                    return;
                }
            }
        }

        self::$connection->addServer($host,$port);
    }


}