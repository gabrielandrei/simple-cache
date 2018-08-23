<?php
/**
 * Created by    Gabriel Andrei gabrielandrei79@gmail.com
 * Date:         20/08/18
 * Time:         14:28
 */

namespace SimpleCache\Drivers;


use SimpleCache\DriverInterface;

class MemcachedDriver implements DriverInterface
{
    /**
     * @var MemcachedDriverConfig
     */
    private $config;

    /**
     * @var \Memcached
     */
    private $connection;

    /**
     * MemcachedDriver constructor.
     * @param MemcachedDriverConfig $config
     */
    public function __construct(MemcachedDriverConfig $config)
    {
        $this->config = $config;
        $mconnection = \MemcachedConnection::getInstance();
        $this->connection = $mconnection::getConnection();
        foreach ($this->config->getServerList() as $s){
            $mconnection::addServer($s['host'],$s['port']);
        }
    }


    /**
     * @param $realm
     * @param $idkey
     * @param array $data
     * @return bool
     */
    public function save($realm, $idkey, array $data): bool
    {
        return $this->connection->add($realm.'_'.$idkey,$data,$this->config->getLifeDefault() + time());
    }

    /**
     * @param $realm
     * @param $idkey
     * @param int|null $life
     * @return array
     */
    public function retrieve($realm, $idkey, int $life = null): array
    {
        return $this->connection->get($realm.'_'.$idkey);
    }

    /**
     * @param $realm
     * @param $idkey
     * @return bool
     */
    public function invalidate($realm, $idkey)
    {
        return $this->connection->delete($realm.'_'.$idkey);
    }

    /**
     * @param $realm
     * @return bool
     */
    public function invalidateRealm($realm)
    {
        return $this->connection->flush();
    }

}