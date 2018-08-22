<?php

namespace ContinuumDigital\Uid\Traits;

use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;

trait HasUid
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
        extract(config('database.uid'));

        $uid = (new Hashids($salt, $minLength, $alphabet))->encode(microtime());

        if (self::uid($uid)->count() > 0) {
            return static::generateUid();
        }

        return $uid;
    }
}