<?php

namespace Danshin\Comment\Console\Commands;

use Illuminate\Console\Command;
use Danshin\Comment\Support\ManagerReport;
use Danshin\Comment\Support\ManagerRepository;

class Cut extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comment:cut';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Frees up space in the comment file';

    public function handle(ManagerRepository $managerRepository): int
    {
        $slice = $managerRepository->cut();
        if ($slice !== null) {
            (new ManagerReport($slice))->send();
        }

        $this->info("Danshin, comment:cut OK");
        return 0;
    }
}
