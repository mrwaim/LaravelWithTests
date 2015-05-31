<?php

namespace App\Console\Commands;

use Config;
use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

// From https://gist.github.com/lucasmichot/7313220
class LogClearOld extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'log:clearold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete logs not equal to today.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {
        $fileSystem = new Filesystem();

        $now = date('Y-m-d');
        $files = Finder::create()->in(storage_path("logs"))->files();
        foreach ($files->files() as $file) {
            $fileName = $file->getFileName();
            if (!str_contains($fileName, $now)) {
                $this->comment("Deleting " . $fileName);
                $fileSystem->remove($file);
            } else {
                $this->comment("Keeping " . $fileName);
            }
        }
    }

}
