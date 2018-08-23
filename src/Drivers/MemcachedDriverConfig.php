<?php
/**
 * Created by    Gabriel Andrei gabrielandrei79@gmail.com
 * Date:         20/08/18
 * Time:         14:28
 */

namespace SimpleCache\Drivers;


class MemcachedDriverConfig
{
    /**
     * @var int
     */
    private $lifeDefault;
    /**
     * @var array
     */
    private $serverList;

    /**
     * MemcachedDriverConfig constructor.
     * @param int $lifeDefault
     * @param array $serverList
     */
    public function __construct(int $lifeDefault, array $serverList)
    {
        $this->lifeDefault = $lifeDefault;
        $this->serverList = $serverList;
    }


    /**
     * @return int
     */
    public function getLifeDefault(): int
    {
        return $this->lifeDefault;
    }

    /**
     * @param int $lifeDefault
     * @return MemcachedDriverConfig
     */
    public function setLifeDefault(int $lifeDefault): MemcachedDriverConfig
    {
        $this->lifeDefault = $lifeDefault;
        return $this;
    }

    /**
     * @return array
     */
    public function getServerList(): array
    {
        return $this->serverList;
    }

    /**
     * @param array $serverList
     * @return MemcachedDriverConfig
     */
    public function setServerList(array $serverList): MemcachedDriverConfig
    {
        $this->serverList = $serverList;
        return $this;
    }



}