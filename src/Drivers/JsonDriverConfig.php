<?php
/**
 * Created by    Gabriel Andrei gabrielandrei79@gmail.com
 * Date:         20/08/18
 * Time:         10:19
 */

namespace SimpleCache\Drivers;


class JsonDriverConfig
{
    private $lifeDefault;
    private $cacheFolder;

    /**
     * JsonConfig constructor.
     * @param $lifeDefault
     * @param $cacheFolder
     */
    public function __construct($lifeDefault, $cacheFolder)
    {
        //todo check validity

        $this->lifeDefault = $lifeDefault;
        $this->cacheFolder = '/'.trim($cacheFolder,'/');
    }


    /**
     * @return mixed
     */
    public function getLifeDefault()
    {
        return $this->lifeDefault;
    }

    /**
     * @param mixed $lifeDefault
     * @return JsonDriverConfig
     */
    public function setLifeDefault($lifeDefault)
    {
        $this->lifeDefault = $lifeDefault;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCacheFolder()
    {
        return $this->cacheFolder;
    }

    /**
     * @param mixed $cacheFolder
     * @return JsonDriverConfig
     */
    public function setCacheFolder($cacheFolder)
    {
        $this->cacheFolder = $cacheFolder;
        return $this;
    }

}