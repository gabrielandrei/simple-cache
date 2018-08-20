<?php
/**
 * Created by    Gabriel Andrei gabrielandrei79@gmail.com
 * Date:         20/08/18
 * Time:         09:32
 */

namespace SimpleCache\Drivers;

use SimpleCache\DriverInterface;
use SimpleCache\SimpleCacheException;

class JsonDriver implements DriverInterface
{
    /**
     * @var JsonDriverConfig
     */
    private $jsonConfig;

    /**
     * Json constructor.
     * @param JsonDriverConfig $jsonConfig
     */
    public function __construct(JsonDriverConfig $jsonConfig)
    {
        $this->jsonConfig = $jsonConfig;
    }

    /**
     * @param $realm
     * @param $idkey
     * @param array $data
     * @return bool
     * @throws SimpleCacheException
     */
    public function save($realm, $idkey, array $data): bool
    {
        $file = $this->fileAbsolute($realm, $idkey);
        return file_put_contents($file, json_encode($data));
    }

    /**
     * @param $realm
     * @param $idkey
     * @param int|null $life
     * @return array
     * @throws SimpleCacheException
     */
    public function retrieve($realm, $idkey, int $life = null): array
    {
        $file = $this->fileAbsolute($realm, $idkey);

        if ($this->fileValid($file, $life)) {
            return ['status' => true, 'data' => json_decode(file_get_contents($file), true)];
        }
        return ['status' => false, 'data' => []];
    }

    /**
     * @param $realm
     * @param $idkey
     * @return bool|void
     * @throws SimpleCacheException
     */
    public function invalidate($realm, $idkey)
    {
        $file = $this->fileAbsolute($realm, $idkey);
        if (is_file($file)) {
            if (!@unlink($file)) {
                throw new SimpleCacheException("Can't delete file: " . $file);
            }
        }

    }

    /**
     * @param $realm
     * @return bool|void
     * @throws SimpleCacheException
     */
    public function invalidateRealm($realm)
    {
        $folder = $this->folderAbsolute($realm);
        foreach (glob($folder . '/*.json') as $file) {
            if (is_file($file)) {
                if (!@unlink($file)) {
                    throw new SimpleCacheException("Can't delete file: " . $file);
                }
            }
        }
    }

    /**
     * @param $folder
     * @throws SimpleCacheException
     */
    private function folderCheck($folder)
    {
        if (!is_dir($folder)) {
            if(!@mkdir($folder, 0777, true)){
                throw new SimpleCacheException("Can't create folder: ".$folder);
            }
        }
    }

    /**
     * @param $realm
     * @param $file
     * @return string
     * @throws SimpleCacheException
     */
    private function fileAbsolute($realm, $file)
    {
        $folder = $this->folderAbsolute($realm);
        return $folder . '/' . $file . '.json';
    }

    /**
     * @param $realm
     * @return string
     * @throws SimpleCacheException
     */
    private function folderAbsolute($realm)
    {
        $folder = $this->jsonConfig->getCacheFolder() . '/' . $realm . '/';
        $this->folderCheck($folder);
        return $folder;
    }

    /**
     * @param $file
     * @param null $life
     * @return bool
     * @throws SimpleCacheException
     */
    private function fileValid($file, $life = null)
    {
        if (!file_exists($file)) {
            return false;
        } else {
            $now = new \DateTime();
            $mmtime = filemtime($file);

            if ($mmtime === false) {
                throw new SimpleCacheException("Can't determine file modified time");
            }

            $life = $life !== null ? $life : $this->jsonConfig->getLifeDefault();

            if ($now->getTimestamp() - $mmtime > $life) {
                return false;
            }
        }


        return true;
    }
}