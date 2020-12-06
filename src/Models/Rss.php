<?php

namespace MarkDingemanse\Beyondlove\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rss extends Model
{
    use SoftDeletes;
    /**
     * {@inheritdoc}
     */

    /**
     * {@inheritdoc}
     */
    protected $table = 'rss';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'first_post',
    ];

    /**
     * Get the first_post.
     *
     * @return string
     */
    public function getFirstPost()
    {
        return $this->getAttribute('first_post');
    }
    /**
     * Set the first_post.
     *
     * @param  string  $first_post
     * @return $this
     */
    public function setFirstPost($first_post)
    {
        $this->setAttribute('first_post', $first_post);
        return $this;
    }
}
