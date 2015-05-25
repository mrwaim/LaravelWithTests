<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use Symfony\Component\Finder\SplFileInfo;

class ListModel extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'list:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all models.';

    public function fire() {
        $files = File::allFiles(app_path());
        foreach ($files as $file) {
            /* @var $file SplFileInfo */
            $noExt = preg_replace("/\.[^.]+$/", "", $file->getBasename());
            $f = $file->openFile();
            $content = $f->fread($f->getSize());

            if (str_contains($content, "class $noExt extends Model")) {
                $this->comment($file->getFilename());
            }
        }
    }

}
