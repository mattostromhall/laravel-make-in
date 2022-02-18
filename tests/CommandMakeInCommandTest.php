<?php

use Illuminate\Filesystem\Filesystem;
use MattOstromHall\MakeIn\Commands\CommandMakeInCommand;
use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->fileSystem = app(Filesystem::class);
    if (!$this->fileSystem->exists(app_path('Console') . '/Kernel.php')) {
        $this->fileSystem->put(
            app_path('Console') . '/Kernel.php',
            '<?php' . "\n" .

'namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application\'s command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command(\'inspire\')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.\'/Commands\');

        require base_path(\'routes/console.php\');
    }
}'
        );
    }
});

it('creates a command, moves it to the requested path, updates the namespace and adds the load function call to the kernel', function () {
    artisan(CommandMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'Test/SubTest/'
    ])
        ->expectsOutput('Command created in ' . config('make-in.path.base.command') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.command') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.command') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.command') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.command') . 'Test/Subtest/Test.php')
    );
    $this->assertStringContainsString(
        '$this->load(__DIR__.\'/../Console/Commands/Test/Subtest\');',
        $this->fileSystem->get(app_path('Console') . '/Kernel.php')
    );
});

it('will format the path provided to follow directory case convention', function () {
    artisan(CommandMakeInCommand::class, [
        'name' => 'Test',
        '--path' => 'tEst/subtest/'
    ])
        ->expectsOutput('Command created in ' . config('make-in.path.base.command') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.command') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.command') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.command') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.command') . 'Test/Subtest/Test.php')
    );
});

it('will create the command in the base location if no path is provided', function () {
    artisan(CommandMakeInCommand::class, [
        'name' => 'Test',
        '--path' => null
    ])
        ->expectsQuestion('What is the path? (press enter for default)', null)
        ->expectsOutput('Command created in ' . config('make-in.path.base.command') . 'Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.command'))
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.command') . 'Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.command'),
        $this->fileSystem->get(config('make-in.path.base.command') . 'Test.php')
    );
});

it('prompts for a name and a path if they are not provided', function () {
    artisan(CommandMakeInCommand::class)
        ->expectsQuestion('What is the command called?', 'Test')
        ->expectsQuestion('What is the path? (press enter for default)', 'Test/SubTest/')
        ->expectsOutput('Command created in ' . config('make-in.path.base.command') . 'Test/Subtest/Test.php')
        ->expectsOutput('Created with Namespace ' . config('make-in.namespace.base.command') . '\Test\Subtest')
        ->assertSuccessful();

    expect($this->fileSystem->exists(config('make-in.path.base.command') . 'Test/Subtest/Test.php'))->toBeTrue();
    $this->assertStringContainsString(
        config('make-in.namespace.base.command') . '\Test\Subtest',
        $this->fileSystem->get(config('make-in.path.base.command') . 'Test/Subtest/Test.php')
    );
    $this->assertStringContainsString(
        '$this->load(__DIR__.\'/../Console/Commands/Test/Subtest\');',
        $this->fileSystem->get(app_path('Console') . '/Kernel.php')
    );
});
