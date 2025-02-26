<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Config;
use File;
use Carbon\Carbon;

class DeleteZipFiles extends Command
{
  protected $signature = 'files:delete-old {days : The number of days before which files should be deleted}';
    protected $description = 'Delete files older than a specified number of days';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $days = (int)$this->argument('days');
        $path = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_ZIPPATH'));// specify your directory path here

        if (!File::exists($path)) {
            $this->error("The directory does not exist.");
            return;
        }

        $files = File::allFiles($path);

        $now = Carbon::now();

        foreach ($files as $file) {
            $creationTime = Carbon::createFromTimestamp($file->getCTime());
            if ($creationTime->lt($now->subDays($days))) {
                File::delete($file->getPathname());
                $this->info("Deleted: " . $file->getFilename());
            }
        }

        $this->info("Files older than $days days have been deleted.");
    }
}
