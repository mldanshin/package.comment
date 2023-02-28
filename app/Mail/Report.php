<?php

namespace Danshin\Comment\Mail;

use Danshin\Comment\Models\Report as ReportModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Report extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public ReportModel $report)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject(config('danshin-comment.mail.subject'))
            ->view('danshin/comment::emails.report');
    }
}
