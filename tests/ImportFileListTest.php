<?php
use App\Importing\ImportList;
use App\Importing\ProcessedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 10:21 AM
 */
class ImportFileListTest extends TestCase
{

    use DatabaseTransactions;

    /**
     *@test
     */
    public function it_gets_the_correct_list_of_files_to_import_from()
    {
        $listMaker = new ImportList();

        $this->addTwoTestFilesToRawImportsDirectory();
        $this->assertArraySubset([
            'raw_imports/a_production_file_will_never_have_this_name1.txt',
            'raw_imports/a_production_file_will_never_have_this_name2.txt'
        ], $listMaker->getNewList());

        $this->removeTestFiles();
    }

    /**
     *@test
     */
    public function it_does_not_include_files_already_processed()
    {
        $listMaker = new ImportList();
        $this->addTwoTestFilesToRawImportsDirectory();

        ProcessedFile::create(['filepath' => 'raw_imports/a_production_file_will_never_have_this_name1.txt']);

        $this->assertNotContains('raw_imports/a_production_file_will_never_have_this_name1.txt', $listMaker->getNewList());

        $this->removeTestFiles();
    }

    protected function addTwoTestFilesToRawImportsDirectory()
    {
        Storage::put('raw_imports/a_production_file_will_never_have_this_name1.txt', 'hello');
        Storage::put('raw_imports/a_production_file_will_never_have_this_name2.txt', 'hello again');
    }

    protected function removeTestFiles() {
        Storage::delete([
            'raw_imports/a_production_file_will_never_have_this_name1.txt',
            'raw_imports/a_production_file_will_never_have_this_name2.txt'
        ]);
    }

}