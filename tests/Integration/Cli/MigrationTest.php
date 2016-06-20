<?php
namespace Phwoolcon\Tests\Integration\Cli;

use Phwoolcon\Cli\Command\Migrate;
use Phwoolcon\Tests\Helper\CliTestCase;
use Symfony\Component\Console\Input\ArgvInput;

class MigrationTest extends CliTestCase
{
    /**
     * @var Migrate
     */
    protected $migrateCommand;

    public function setUp()
    {
        parent::setUp();
        $this->migrateCommand = $this->cli->get('migrate');
        $this->migrateCommand->cleanMigrationsTable();
    }

    protected function createMigrateFile()
    {
        foreach (glob(migrationPath('/*test.php')) as $file) {
            @unlink($file);
        }
        $output = $this->runCommand('migrate:create', ['test']);
        preg_match('/Created\ Migration:\ (.+)/', $output, $matches);
        return fnGet($matches, 1);
    }

    public function testMigrateCreate()
    {
        $migrationFile = $this->createMigrateFile();
        /* @var \Phwoolcon\Cli\Command\MigrateCreate $command */
        $command = $this->cli->get('migrate:create');
        $this->assertNotEmpty($migrationFile, 'Unable to create migration file');
        $this->assertFileExists($savedFile = migrationPath($migrationFile), 'Unable to write migration file');
        $this->assertEquals($command->template(), file_get_contents($savedFile), 'Bad content written to migration file');
    }

    public function testMigrateUpAndDown()
    {
        $migrationFile = $this->createMigrateFile();
        /* @var \Phwoolcon\Cli\Command\MigrateList $list */
        $list = $this->cli->get('migrate:list');
        /* @var \Phwoolcon\Cli\Command\Migrate $up */
        $up = $this->cli->get('migrate:up');
        /* @var \Phwoolcon\Cli\Command\MigrateRevert $down */
        $down = $this->cli->get('migrate:down');

        $output = $this->runCommand('migrate:list');
        $this->assertContains($migrationFile, $output, 'Unable to detect migrations');
        $list->clearMigratedCache();

        $output = $this->runCommand('migrate:up');
        $this->assertContains(sprintf('Finish migration "%s"', $migrationFile), $output, 'Unable to run migration');
        $output = $this->runCommand('migrate:list', ['-i']);
        $this->assertContains($migrationFile, $output, 'Unable to detect installed migrations');
        $list->clearMigratedCache();

        $output = $this->runCommand('migrate:down');
        $this->assertContains(sprintf('Finish reverting migration "%s"', $migrationFile), $output, 'Unable to revert migration');
        $output = $this->runCommand('migrate:list');
        $this->assertContains($migrationFile, $output, 'Unable to re-detect migrations');
        $list->clearMigratedCache();
        $output = $this->runCommand('migrate:list', ['-a']);
        $this->assertContains($migrationFile, $output, 'Unable to detect all migrations');
    }
}
