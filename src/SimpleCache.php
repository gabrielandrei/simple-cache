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
     * SimpleCache constructor.
     * @param DriverInterface $driver
     * @param array $realms
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
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
        return $this->driver->invalidate($realm,$idkey);

    }

    /**
     * @param $realm
     * @return bool
     * @throws \Exception
     */
    public function invalidateRealm($realm)
    {
        return $this->driver->invalidateRealm($realm);
    }

    /**
     * @return bool
     */
    public function invalidateAll(){
        return $this->driver->invalidateAll();
    }
}