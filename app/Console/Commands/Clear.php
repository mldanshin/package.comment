<?php

namespace Danshin\Comment\Console\Commands;

use Illuminate\Console\Command;
use Danshin\Comment\Support\ManagerRepository;

class Clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "comment:clear";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Clears the comments repository completely";

    public function handle(ManagerRepository $managerRepository): int
    {
        $managerRepository->clear();
        $this->info("Danshin, comment:clear OK");
        return 0;
    }
}
