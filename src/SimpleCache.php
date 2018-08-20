<?php
/**
 * Created by    Gabriel Andrei gabrielandrei79@gmail.com
 * Date:         20/08/18
 * Time:         09:27
 */

namespace SimpleCache;

class SimpleCache
{
    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var array
     */
    private $realms;

    /**
     * SimpleCache constructor.
     * @param DriverInterface $driver
     * @param array $realms
     */
    public function __construct(DriverInterface $driver, array $realms)
    {
        $this->driver = $driver;
        $this->realms = $realms;
    }

    /**
     * @param $realm
     * @param $idkey
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function save($realm, $idkey, array $data): bool
    {
        $this->checkRealm($realm);
        return $this->driver->save($realm,$idkey,$data);
    }

    /**
     * @param $realm
     * @param $idkey
     * @param int|null $life
     * @return array
     * @throws \Exception
     */
    public function retrieve($realm, $idkey, int $life = null): array
    {
        $this->checkRealm($realm);
        return $this->driver->retrieve($realm,$idkey,$life);
    }

    /**
     * @param $realm
     * @param $idkey
     * @return bool
     * @throws \Exception
     */
    public function invalidate($realm, $idkey)
    {
        $this->checkRealm($realm);
        return $this->driver->invalidate($realm,$idkey);

    }

    /**
     * @param $realm
     * @return bool
     * @throws \Exception
     */
    public function invalidateRealm($realm)
    {
        $this->checkRealm($realm);
        return $this->driver->invalidateRealm($realm);
    }

    /**
     * @param $realm
     * @throws \Exception
     */
    private function checkRealm($realm)
    {
        if(array_search($realm,$this->realms,true) === false){
            throw new SimpleCacheException('Invalid Realms provided: '.$realm);
        }
    }


}