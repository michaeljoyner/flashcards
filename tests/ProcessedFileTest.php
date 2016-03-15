<?php
use App\Importing\ProcessedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 10:08 AM
 */
class ProcessedFileTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *@test
     */
    public function it_can_check_if_a_given_file_has_been_processed()
    {
        ProcessedFile::create(['filepath' => 'dummy_path1.txt']);

        $this->assertTrue(ProcessedFile::hasProcessed('dummy_path1.txt'));
        $this->assertFalse(ProcessedFile::hasProcessed('dummy_path2.txt'));
    }
}