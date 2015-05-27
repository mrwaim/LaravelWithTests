<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class EditMoveModel extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'edit:movemodel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move models from App to App\Models\.';

    public function fire() {
        if (!File::exists(app_path('Models'))) {
            File::makeDirectory(app_path('Models'));
        }

        foreach (ListModel::getAllModels() as $model) {
            $this->comment($model->getFilename());

            $file = $model->openFile('r');
            $content = $file->fread($file->getSize());
            $content = preg_replace("/\bnamespace\s+.*?;/", "namespace App\Models;", $content);
            $file = $model->openFile('w');
            $file->fwrite($content);
            $file->fflush();

            $targetFolder = app_path('Models/' . $model->getBasename());
            if ($model->getPathname() != $targetFolder) {
                File::move($model->getPathname(), $targetFolder);
            }

            $this->comment("Move: " . $model->getPathname() . " to " . $targetFolder);

            $className = preg_replace("/\.[^.]+$/", "", $file->getBasename());

            $p1 = base_path('app');
            $p2 = base_path('tests');
            $p3 = base_path('database/seeds');
            $command = "grep -l -R '^\s*use\b.*\\$className;' $p1 $p2 $p3";
            $this->comment("USE GREP COMMAND:$command");
            $out = null;
            $res = exec($command, $out);
            foreach ($out as $line) {
                if (!$line) {
                    continue;
                }

                $this->comment("LINE:$line");
                $regex = "/^(\\s*use\\s+).*?\\\\$className;/m";
                //dd($regex);
                $referrerContent = file_get_contents($line);
                $newReferrerContent = preg_replace($regex, "\$1App\\Models\\$className;", $referrerContent);

                if ($referrerContent != $newReferrerContent) {
                    file_put_contents($line, $referrerContent);
                }
            }

            //
            $command = "grep -l -R 'belongsTo\|hasMany\|hasOne' $p1";
            $this->comment("RELATIONSHIP COMMAND:$command");
            $out;
            $res = exec($command, $out);
            foreach ($out as $line) {
                if (!$line) {
                    continue;
                }

                $this->comment("LINE RELATIONSHIP:$line");
                $regex = "/(belongsTo|hasMany|hasOne)\('.*?\\\\$className'\)/m";
                $referrerContent = file_get_contents($line);
                $newReferrerContent = preg_replace($regex, "\$1('App\\Models\\$className')", $referrerContent);
                if ($newReferrerContent != $referrerContent) {
                    file_put_contents($line, $newReferrerContent);
                }
            }
        }
    }

}
