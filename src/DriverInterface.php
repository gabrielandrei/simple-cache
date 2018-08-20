<?php
/**
 * Created by    Gabriel Andrei gabrielandrei79@gmail.com
 * Date:         20/08/18
 * Time:         09:29
 */

namespace SimpleCache;


interface DriverInterface
{

    /**
     * @param $realm
     * @param $idkey
     * @param array $data
     * @return bool
     */
    public function save($realm,$idkey, array $data):bool;

    /**
     * @param $realm
     * @param $idkey
     * @param int|null $life
     * @return array
     */
    public function retrieve($realm,$idkey, int $life = null):array;

    /**
     * @param $realm
     * @param $idkey
     * @return bool
     */
    public function invalidate($realm,$idkey);

    /**
     * @param $realm
     * @return bool
     */
    public function invalidateRealm($realm);
}