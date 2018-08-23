<?php

namespace ContinuumDigital\Uid\Traits;

use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;

trait HasUid
{
    /**
     * Generate and fill the uid when the model is being created.
     */
    public static function bootHasUid()
    {
        static::creating(function (Model $model) {
            if (!$model->uid) {
                $model->uid = self::generateUid();
            }
        });
    }

    /**
     * Scope by uid.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $uid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUid($query, $uid)
    {
        return $query->where('uid', $uid);
    }

    /**
     * Generate an unique uid.
     *
     * @return string
     */
    private static function generateUid()
    {
        $uid = (new Hashids(self::getSalt(), self::getMinLength(), self::getAlphabet()))
            ->encode(self::getMicrotimeAsInteger());

        if (self::uid($uid)->count() > 0) {
            return static::generateUid();
        }

        return $uid;
    }

    /**
     * Get 'salt' from config of its default value.
     *
     * @return string
     */
    private static function getSalt()
    {
        return config('database.uid.salt', '');
    }

    /**
     * Get 'minLength' from config of its default value.
     *
     * @return string
     */
    private static function getMinLength()
    {
        return config('database.uid.minLength', 0);
    }

    /**
     * Get 'alphabet' from config of its default value.
     *
     * @return string
     */
    private static function getAlphabet()
    {
        return config('database.uid.alphabet', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    }

    /**
     * Generate a integer number based in microtime.
     *
     * @return int
     */
    private static function getMicrotimeAsInteger()
    {
        return (int) (10000*microtime(true));
    }
}