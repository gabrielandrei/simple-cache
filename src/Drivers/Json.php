<?php
/**
 * Created by    Gabriel Andrei gabrielandrei79@gmail.com
 * Date:         20/08/18
 * Time:         09:32
 */

namespace SimpleCache\Drivers;

use SimpleCache\DriverInterface;

class Json implements DriverInterface
{
    /**
     * @var JsonConfig
     */
    private $jsonConfig;

    /**
     * Json constructor.
     * @param JsonConfig $jsonConfig
     */
    public function __construct(JsonConfig $jsonConfig)
    {
        $this->jsonConfig = $jsonConfig;
    }

    /**
     * @param $realm
     * @param $idkey
     * @param array $data
     * @return bool
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
     */
    public function invalidate($realm, $idkey)
    {
        $file = $this->fileAbsolute($realm, $idkey);
        if (is_file($file)) {
            //todo exception
            unlink($file);
        }

    }

    /**
     * @param $realm
     *
     */
    public function invalidateRealm($realm)
    {
        $folder = $this->folderAbsolute($realm);
        foreach (glob($folder . '/*.json') as $file) {
            if (is_file($file)) {
                //todo exception
                unlink($file);
            }
        }
    }

    /**
     * @param $folder
     */
    private function folderCheck($folder)
    {
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    /**
     * @param $realm
     * @param $file
     * @return string
     */
    private function fileAbsolute($realm, $file)
    {
        $folder = $this->folderAbsolute($realm);
        return $folder . '/' . $file . '.json';
    }

    /**
     * @param $realm
     * @return string
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
     */
    private function fileValid($file, $life = null)
    {
        if (!file_exists($file)) {
            return false;
        } else {
            $now = new \DateTime();
            $mmtime = filemtime($file);

            if ($mmtime === false) {
                //todo exception?
                return false;
            }

            $life = $life !== null ? $life : $this->jsonConfig->getLifeDefault();

            if ($now->getTimestamp() - $mmtime > $life) {
                return false;
            }
        }


        return true;
    }
}