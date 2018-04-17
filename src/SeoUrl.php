<?php

namespace Luna\SeoUrls;

use Illuminate\Database\Eloquent\Model;

/**
 * SeoUrl model.
 *
 * @package     Luna\SeoUrls
 * @author      Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class SeoUrl extends Model
{
    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @var array
     */
    public $dates = ['last_used'];
}
