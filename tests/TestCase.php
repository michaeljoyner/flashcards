<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    public $testDummyThreeWordArray = [
        [
            'eng' => 'pig',
            'py' => 'ju',
            'trad' => 'ㄘ'
        ],
        [
            'eng' => 'dog',
            'py' => 'goa',
            'trad' => 'ㄕ'
        ],
        [
            'eng' => 'cat',
            'py' => 'mao',
            'trad' => 'ㄙㄨㄜ'
        ]
    ];
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
}
