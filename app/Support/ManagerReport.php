<?php

namespace Danshin\Comment\Support;

use Illuminate\Support\Facades\Mail;
use Danshin\Comment\Mail\Report as ReportMail;
use Danshin\Comment\Models\Report as ReportModel;

final class ManagerReport
{
    private ?string $replyTo;
    private ReportModel $report;

    /**
     * @param string[] $content
     */
    public function __construct(array $content)
    {
        $this->replyTo = config("danshin-comment.mail.replay_to.address");
        $this->initialize($content);
    }

    public function send(): void
    {
        if (!empty($this->replyTo)) {
            Mail::to($this->replyTo)->send(new ReportMail($this->report));
        }
    }

    /**
     * @param string[] $content
     */
    private function initialize(array $content): void
    {
        $this->report = new ReportModel(
            (new \DateTime())->format('Y-m-d h:i:s'),
            $content
        );
    }
}
