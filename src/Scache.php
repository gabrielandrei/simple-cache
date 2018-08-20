<?php
/**
 * Created by    Gabriel Andrei gabrielandrei79@gmail.com
 * Date:         20/08/18
 * Time:         09:27
 */

namespace Scache;

class Scache
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
     * Scache constructor.
     * @param DriverInterface $driver
     * @param array $realms
     */
    public function __construct(DriverInterface $driver, array $realms)
    {
        $this->driver = $driver;
        $this->realms = $realms;
    }


}