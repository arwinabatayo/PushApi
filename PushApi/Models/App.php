<?php

namespace PushApi\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @author Eloi Ballarà Madrid <eloi@tviso.com>
 *
 * Model of the apps table, manages all the relationships and dependencies
 * that can be done on this table
 */
class App extends Eloquent
{
    public $timestamps = false;
    protected $fillable = array('name', 'secret');
    protected $hidden = array('created');

    // Only can be created MAX num of apps
    const MAX_APPS_ENABLED = 1;

    /**
     * Setting an app secret when the app is created
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function($app) {
        	$app->secret = self::generateSecret();
        });
    }

    /**
     * Generates a random secret for the app
     * @return [string] A unique secret generated randomly
     */
    private static function generateSecret() {
        return substr(md5("fakers__" . rand()), 0, 16);
    }
}