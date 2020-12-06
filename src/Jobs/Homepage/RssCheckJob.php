<?php

namespace MarkDingemanse\Beyondlove\Jobs\Homepage;

use Illuminate\Support\Facades\Log;
use MarkDingemanse\Beyondlove\Jobs\Job;
use willvincent\Feeds\Facades\FeedsFacade as Feeds;
use MarkDingemanse\Beyondlove\Models\Rss;
use Illuminate\Contracts\Mail\Mailer;
use MarkDingemanse\Beyondlove\Mail\RssMail;

class RssCheckJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //...
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        Feeds $feed,
        Mailer $mail
    ) {
        $rssCsvList = str_getcsv(env('RSS_URLS'));

        foreach ($rssCsvList as $key => $rss) {
            $feedArray = $feed::make($rss);
            $newItem   = $feedArray->get_items()[0];
            $title     = $newItem->get_title();
            $label     = $newItem->get_category()->get_label();

            $model     = new Rss;
            $post      = $model
                         ->where('first_post', $title)
                         ->first();

            if(is_null($post)) {
                $this->newPost($model, $title);
                $this->sendMail($post, $newItem, $label, $mail);
                continue;
            }

            if ($post->getFirstPost() == $title) {
                Log::info("no new content found on r/symphonicmetal");
                continue;
            }

            $this->newPost($model, $title);
            $this->sendMail($post, $newItem, $label, $mail);
        }
    }

    private function newPost($model, $title) {
        $model->create([
            'first_post' => $title,
        ]);

        Log::info("written a new item from reddit r/symphonicmetal into the db.");
    }

    private function sendMail($post, $newItem, $label, $mail) {
        Log::info("Starting to send mail!!!");
        $mail->queue(new RssMail($newItem, $post, $label));
        Log::info("Mail is send!!!");
    }
}
