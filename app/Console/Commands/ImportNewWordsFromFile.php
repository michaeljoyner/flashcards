<?php

namespace App\Console\Commands;

use App\Importing\ImportWordsFromFiles;
use Illuminate\Console\Command;

class ImportNewWordsFromFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcards:fromfiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import new words from the files in the raw_imports folder';
    /**
     * @var ImportWordsFromFiles
     */
    private $importer;

    /**
     * Create a new command instance.
     *
     */
    public function __construct(ImportWordsFromFiles $importer)
    {
        parent::__construct();
        $this->importer = $importer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->importer->import();
        if(! $this->importer->newList) {
            return $this->info('Nothing to import.');
        }
        $this->info('Importing...');
        foreach($this->importer->newList as $name) {
            $this->info('Imported from file ' . $name);
        }
        $this->info('All done :)');
    }
}
