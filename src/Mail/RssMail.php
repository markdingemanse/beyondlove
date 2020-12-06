<?php

namespace MarkDingemanse\Beyondlove\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RssMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The post instance.
     *
     * @var Symphonic
     */
    protected $post;

    /**
     * The RSS Item instance.
     *
     * @var SimplePie_Item
     */
    protected $newItem;

    /**
     * Name of the label of the rss feed
     *
     * @var String
     */
    protected $label;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newItem, $post, $label)
    {
        $this->newItem = $newItem;
        $this->post = $post;
        $this->label = $label;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $label = $this->getLabel();

        return $this
            ->to(env('EMAIL'))
            ->from(env('EMAIL'))
            ->subject("A new Song appeared on $label")
            ->view('mail.new_song')
            ->with([
                'item' => $this->getItem(),
                'post' => $this->getPost(),
                'label' => $label,
            ]);
    }

    /**
    * getter for the item
    */
    protected function getItem()
    {
        return $this->newItem;
    }

    /**
    * getter for the post
    */
    protected function getPost()
    {
        return $this->post;
    }

    /**
    * getter for the label
    */
    protected function getLabel()
    {
        return $this->label;
    }
}
