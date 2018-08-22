<?php

namespace ContinuumDigital\Uid;

use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;

trait UidTrait
{
    /**
     * Generate the uid when the model is being created.
     */
    public static function bootUidTrait()
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
        $config = config('services.continuum-digital.uid');
        $uid = (new Hashids($config['salt'], $config['minLength']))
            ->encode(microtime());

        if (self::publicId($uid)->count() > 0) {
            return static::generateUid();
        }

        return $uid;
    }
}