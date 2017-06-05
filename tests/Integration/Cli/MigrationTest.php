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
        $this->assertEquals(
            $command->template(),
            file_get_contents($savedFile),
            'Bad content written to migration file'
        );
    }

    public function testMigrateUpAndDown()
    {
        $migrationFile = $this->createMigrateFile();
        /* @var \Phwoolcon\Cli\Command\MigrateList $list */
        $list = $this->cli->get('migrate:list');

        // Test migration list
        $output = $this->runCommand('migrate:list');
        $this->assertContains($migrationFile, $output, 'Unable to detect migrations');
        $list->clearMigratedCache();

        // Test migration up
        $output = $this->runCommand('migrate:up');
        $this->assertContains(
            sprintf('Start migration "%s"... [ OK ]', $migrationFile),
            $output,
            'Unable to run migration'
        );
        $output = $this->runCommand('migrate:list', ['-i']);
        $this->assertContains($migrationFile, $output, 'Unable to detect installed migrations');
        $list->clearMigratedCache();

        // Test repeat migration up
        $output = $this->runCommand('migrate:up');
        $this->assertContains('Nothing to be migrated', $output, 'Should not repeatedly run migrations');
        $output = $this->runCommand('migrate:list');
        $this->assertContains('Nothing to be migrated', $output, 'Should report no migrations');
        $list->clearMigratedCache();

        // Test migration down
        $output = $this->runCommand('migrate:down', ['-f']);
        $this->assertContains(
            sprintf('Start reverting migration "%s"... [ OK ]', $migrationFile),
            $output,
            'Unable to revert migration'
        );
        $output = $this->runCommand('migrate:list');
        $this->assertContains($migrationFile, $output, 'Unable to re-detect migrations');
        $list->clearMigratedCache();

        // Test migration list -a
        $output = $this->runCommand('migrate:list', ['-a']);
        $this->assertContains($migrationFile, $output, 'Unable to detect all migrations');
    }
}
