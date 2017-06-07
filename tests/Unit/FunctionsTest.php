<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Config;
use Phwoolcon\Tests\Helper\TestCase;

class FunctionsTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testArrayForget()
    {
        $array = [
            'child' => [
                'child' => [
                    'child' => 'no child',
                ],
            ],
        ];
        $this->assertTrue(isset($array['child']['child']['child']), 'Bad initial array');
        array_forget($array, 'child.child.child');
        $this->assertTrue(!isset($array['child']['child']['child']), 'Unable to forget array key');
        $this->assertTrue(isset($array['child']['child']), 'Bad forget array result');
        array_forget($array, 'child.child.child.child');
    }

    public function testArraySet()
    {
        $array = [];
        $value = 'no child';
        $this->assertTrue(!isset($array['child']), 'Bad initial array');
        array_set($array, 'child.child.child', $value);
        $this->assertTrue(isset($array['child']['child']['child']), 'Unable to set array key');
        $this->assertEquals($value, $array['child']['child']['child'], 'Bad array key set result');
        array_set($array, null, $value);
        $this->assertEquals($value, $array, 'Bad array set result');
    }

    public function testBase62encode()
    {
        $this->assertEquals('Z', base62encode('61'), 'Bad base62encode value for 61');
        $this->assertEquals('10', base62encode('62'), 'Bad base62encode value for 62');
    }

    public function testFnGet()
    {
        $array = [
            'child' => [
                'child' => [
                    'child' => 'no child',
                ],
            ],
        ];
        $obj = json_decode(json_encode($array));
        $default = 'default';
        $this->assertEquals(
            $array['child']['child']['child'],
            fnGet($array, 'child.child.child'),
            'Unable to fetch child on array'
        );
        $this->assertEquals(
            $array['child']['child']['child'],
            fnGet($array, 'child.child.child', null, '.', true),
            'Unable to fetch child on array'
        );
        $this->assertEquals(
            $obj->child->child->child,
            fnGet($obj, 'child.child.child', null, '.', true),
            'Unable to fetch child on object'
        );
        $this->assertEquals(
            $default,
            fnGet($array, 'bad.key', $default),
            'Unable to return default value if child not found on array'
        );
        $this->assertEquals(
            $default,
            fnGet($obj, 'bad.key', $default, '.', true),
            'Unable to return default value if child not found on object'
        );
    }

    public function testUrl()
    {
        $baseUrl = Config::get('app.url');
        $uri = 'test/done';
        $expected = rtrim($baseUrl, '/') . '/' . ltrim($uri, '/');
        $this->assertEquals($expected, url($uri), 'Bad url() result');
        $expected = rtrim($baseUrl, '/') . '/' . ltrim($uri, '/') . '?k=v';
        $this->assertEquals($expected, url($uri, ['k' => 'v']), 'Bad url() result on queries');
        Config::set('app.enable_https', true);
        $expected = str_replace('http:', 'https:', rtrim($baseUrl, '/')) . '/' . ltrim($uri, '/') . '?k=v';
        $this->assertEquals($expected, secureUrl($uri, ['k' => 'v']), 'Bad url() result on https');
        $expected = $uri = 'http://test.com';
        $this->assertEquals($expected, url($uri), 'Bad url() result on external links');
    }

    public function testGetRelativePath()
    {
        // Same level
        $source = '/a/b/c.php';
        $destination = '/a/b/d.php';
        $expected = './d.php';
        $this->assertEquals($expected, getRelativePath($source, $destination));

        // To child
        $source = '/a/b/c.php';
        $destination = '/a/b/c/d.php';
        $expected = './c/d.php';
        $this->assertEquals($expected, getRelativePath($source, $destination));

        // Another child
        $source = '/a/b/c.php';
        $destination = '/a/b/d/d.php';
        $expected = './d/d.php';
        $this->assertEquals($expected, getRelativePath($source, $destination));

        // Just parent
        $source = '/a/b/c.php';
        $destination = '/a/c.php';
        $expected = '../c.php';
        $this->assertEquals($expected, getRelativePath($source, $destination));

        // Different parent
        $source = '/a/b/c.php';
        $destination = '/a/c/d.php';
        $expected = '../c/d.php';
        $this->assertEquals($expected, getRelativePath($source, $destination));

        // Directories
        $source = '/a/b/c/';
        $destination = '/a/b/d/';
        $expected = './d/';
        $this->assertEquals($expected, getRelativePath($source, $destination));

        // Directories
        $source = '/a/b/c/';
        $destination = '/a/c/d/';
        $expected = '../c/d/';
        $this->assertEquals($expected, getRelativePath($source, $destination));

        // Non absolute paths
        $source = 'a/b/c/';
        $destination = 'a/c/d/';
        $expected = $destination;
        $this->assertEquals($expected, getRelativePath($source, $destination));
    }

    public function testRemoveDir()
    {
        // Prepare dir structure
        $targetDir = storagePath('dirs/rand-' . mt_rand(1000, 9999));
        mkdir($subDir = $targetDir . '/a/b/c', 0777, true);
        touch($file = $subDir . '/x.log');
        $this->assertFileExists($file);

        // Remove dir recursively
        removeDir(dirname($targetDir));
        $this->assertFileNotExists($targetDir);
    }

    public function testCopyDirMerge()
    {
        // Prepare variables
        $sourceDir = storagePath('dirs/source-' . mt_rand(1000, 9999));
        $targetDir = storagePath('dirs/target-' . mt_rand(1000, 9999));
        $subDir = '/a/b/c/';
        $file1 = $fileContent1 = 'x.log';
        $file2 = $fileContent2 = 'y.log';
        $file3 = $fileContent3 = 'z.log';
        $sourceSubDir = $sourceDir . $subDir;
        $sourceFile1 = $sourceSubDir . $file1;
        $sourceFile2 = $sourceSubDir . $file2;
        $sourceFile3 = $sourceSubDir . $file3;
        $targetSubDir = $targetDir . $subDir;
        $targetFile1 = $targetSubDir . $file1;
        $targetFile2 = $targetSubDir . $file2;
        $targetFile3 = $targetSubDir . $file3;

        // Prepare source dir structure, with file1, file2 and file3
        mkdir($sourceSubDir, 0777, true);
        fileSaveArray($sourceFile1, $fileContent1);
        fileSaveArray($sourceFile2, $fileContent2);
        fileSaveArray($sourceFile3, $fileContent3);
        $this->assertFileExists($sourceFile1);
        $this->assertFileExists($sourceFile2);
        $this->assertFileExists($sourceFile3);

        // Prepare target dir structure, with file3 which holds content 'a.log'
        mkdir($targetSubDir, 0777, true);
        fileSaveArray($targetFile3, $fileContent3Target = 'a.log');
        $this->assertFileExists($targetFile3);

        // Target don't have file1 and file2 before copy
        $this->assertFileNotExists($targetFile1);
        $this->assertFileNotExists($targetFile2);

        // Perform copy
        copyDirMerge($sourceDir, $targetDir);

        // Now target have file1, file2 and file3, but file3 remains unchanged
        $this->assertFileExists($targetFile1);
        $this->assertFileExists($targetFile2);
        $this->assertFileExists($targetFile3);

        $this->assertEquals($fileContent1, include $sourceFile1);
        $this->assertEquals($fileContent2, include $sourceFile2);
        $this->assertEquals($fileContent3, include $sourceFile3);

        $this->assertEquals($fileContent1, include $targetFile1);
        $this->assertEquals($fileContent2, include $targetFile2);
        $this->assertNotEquals($fileContent3, include $targetFile3);
        $this->assertEquals($fileContent3Target, include $targetFile3);

        // Clean
        removeDir(dirname($sourceDir));
        $this->assertFileNotExists($sourceDir);
        $this->assertFileNotExists($targetDir);
    }

    public function testCopyDirOverride()
    {
        // Prepare variables
        $sourceDir = storagePath('dirs/source-' . mt_rand(1000, 9999));
        $targetDir = storagePath('dirs/target-' . mt_rand(1000, 9999));
        $subDir = '/a/b/c/';
        $file1 = $fileContent1 = 'x.log';
        $file2 = $fileContent2 = 'y.log';
        $file3 = $fileContent3 = 'z.log';
        $sourceSubDir = $sourceDir . $subDir;
        $sourceFile1 = $sourceSubDir . $file1;
        $sourceFile2 = $sourceSubDir . $file2;
        $sourceFile3 = $sourceSubDir . $file3;
        $targetSubDir = $targetDir . $subDir;
        $targetFile1 = $targetSubDir . $file1;
        $targetFile2 = $targetSubDir . $file2;
        $targetFile3 = $targetSubDir . $file3;

        // Prepare source dir structure, with file1, file2 and file3
        mkdir($sourceSubDir, 0777, true);
        fileSaveArray($sourceFile1, $fileContent1);
        fileSaveArray($sourceFile2, $fileContent2);
        fileSaveArray($sourceFile3, $fileContent3);
        $this->assertFileExists($sourceFile1);
        $this->assertFileExists($sourceFile2);
        $this->assertFileExists($sourceFile3);

        // Prepare target dir structure, with file3 which holds content 'a.log'
        mkdir($targetSubDir, 0777, true);
        fileSaveArray($targetFile3, $fileContent3Target = 'a.log');
        $this->assertFileExists($targetFile3);

        // Target don't have file1 and file2 before copy
        $this->assertFileNotExists($targetFile1);
        $this->assertFileNotExists($targetFile2);

        // Perform copy
        copyDirOverride($sourceDir, $targetDir);

        // Now target have file1, file2 and file3, this time file3 is overridden
        $this->assertFileExists($targetFile1);
        $this->assertFileExists($targetFile2);
        $this->assertFileExists($targetFile3);

        $this->assertEquals($fileContent1, include $sourceFile1);
        $this->assertEquals($fileContent2, include $sourceFile2);
        $this->assertEquals($fileContent3, include $sourceFile3);

        $this->assertEquals($fileContent1, include $targetFile1);
        $this->assertEquals($fileContent2, include $targetFile2);
        $this->assertEquals($fileContent3, include $targetFile3);
        $this->assertNotEquals($fileContent3Target, include $targetFile3);

        // Clean
        removeDir(dirname($sourceDir));
        $this->assertFileNotExists($sourceDir);
        $this->assertFileNotExists($targetDir);
    }

    public function testCopyDirReplace()
    {
        // Prepare variables
        $sourceDir = storagePath('dirs/source-' . mt_rand(1000, 9999));
        $targetDir = storagePath('dirs/target-' . mt_rand(1000, 9999));
        $subDir = '/a/b/c/';
        $file1 = $fileContent1 = 'x.log';
        $file2 = $fileContent2 = 'y.log';
        $file3 = $fileContent3 = 'z.log';
        $file4 = $fileContent4 = 'a.log';
        $sourceSubDir = $sourceDir . $subDir;
        $sourceFile1 = $sourceSubDir . $file1;
        $sourceFile2 = $sourceSubDir . $file2;
        $sourceFile4 = $sourceSubDir . $file4;
        $targetSubDir = $targetDir . $subDir;
        $targetFile1 = $targetSubDir . $file1;
        $targetFile2 = $targetSubDir . $file2;
        $targetFile3 = $targetSubDir . $file3;
        $targetFile4 = $targetSubDir . $file4;

        // Prepare source dir structure, with file1, file2 and file4
        mkdir($sourceSubDir, 0777, true);
        fileSaveArray($sourceFile1, $fileContent1);
        fileSaveArray($sourceFile2, $fileContent2);
        fileSaveArray($sourceFile4, $fileContent4);
        $this->assertFileExists($sourceFile1);
        $this->assertFileExists($sourceFile2);
        $this->assertFileExists($sourceFile4);

        // Prepare target dir structure, with file3
        mkdir($targetSubDir, 0777, true);
        fileSaveArray($targetFile3, $fileContent3);
        $this->assertFileExists($targetFile3);

        // Target don't have file1, file2 and file4 before copy
        $this->assertFileNotExists($targetFile1);
        $this->assertFileNotExists($targetFile2);
        $this->assertFileNotExists($targetFile4);

        // Perform copy
        copyDirReplace($sourceDir, $targetDir);

        // Now target have file1, file2 and file4, file3 is removed
        $this->assertFileExists($targetFile1);
        $this->assertFileExists($targetFile2);
        $this->assertFileExists($targetFile4);
        $this->assertFileNotExists($targetFile3);

        $this->assertEquals($fileContent1, include $sourceFile1);
        $this->assertEquals($fileContent2, include $sourceFile2);
        $this->assertEquals($fileContent4, include $sourceFile4);

        $this->assertEquals($fileContent1, include $targetFile1);
        $this->assertEquals($fileContent2, include $targetFile2);
        $this->assertEquals($fileContent4, include $targetFile4);

        // Clean
        removeDir(dirname($sourceDir));
        $this->assertFileNotExists($sourceDir);
        $this->assertFileNotExists($targetDir);
    }

    public function testSymlinkDirOverride()
    {
        // Prepare variables
        $sourceDir = storagePath('dirs/source-' . mt_rand(1000, 9999));
        $targetDir = storagePath('dirs/target-' . mt_rand(1000, 9999));
        $subDir = '/a/b/c/';
        $file1 = $fileContent1 = 'x.log';
        $file2 = $fileContent2 = 'y.log';
        $file3 = $fileContent3 = 'z.log';
        $file4 = $fileContent4 = 'a.log';
        $sourceSubDir = $sourceDir . $subDir;
        $sourceFile1 = $sourceSubDir . $file1;
        $sourceFile2 = $sourceSubDir . $file2;
        $sourceFile3 = $sourceSubDir . $file3;
        $targetSubDir = $targetDir . $subDir;
        $targetFile1 = $targetSubDir . $file1;
        $targetFile2 = $targetSubDir . $file2;
        $targetFile3 = $targetSubDir . $file3;
        $targetFile4 = $targetSubDir . $file4;

        // Prepare source dir structure, with file1, file2 and file3
        mkdir($sourceSubDir, 0777, true);
        fileSaveArray($sourceFile1, $fileContent1);
        fileSaveArray($sourceFile2, $fileContent2);
        fileSaveArray($sourceFile3, $fileContent3);
        $this->assertFileExists($sourceFile1);
        $this->assertFileExists($sourceFile2);
        $this->assertFileExists($sourceFile3);

        // Prepare target dir structure, with file3 which holds content 'a.log' and file4
        mkdir($targetSubDir, 0777, true);
        fileSaveArray($targetFile3, $fileContent3Target = 'a.log');
        fileSaveArray($targetFile4, $fileContent4);
        $this->assertFileExists($targetFile3);
        $this->assertFileExists($targetFile4);

        // Target don't have file1 and file2 before copy
        $this->assertFileNotExists($targetFile1);
        $this->assertFileNotExists($targetFile2);

        // Perform symlink
        symlinkDirOverride($sourceDir, $targetDir);

        // Now target have symlinks to file1, file2, file3 and file4, file3 is overridden, but file4 remain unchanged
        $this->assertFileExists($targetFile1);
        $this->assertFileExists($targetFile2);
        $this->assertFileExists($targetFile3);
        $this->assertFileExists($targetFile4);

        $this->assertTrue(is_link($targetFile1));
        $this->assertTrue(is_link($targetFile2));
        $this->assertTrue(is_link($targetFile3));
        $this->assertFalse(is_link($targetFile4));

        // Check link path
        $basedir = dirname($sourceDir);
        $this->assertEquals(str_replace($basedir, '../../../..', $sourceFile1), readlink($targetFile1));
        $this->assertEquals(str_replace($basedir, '../../../..', $sourceFile2), readlink($targetFile2));
        $this->assertEquals(str_replace($basedir, '../../../..', $sourceFile3), readlink($targetFile3));

        // Check source contents
        $this->assertEquals($fileContent1, include $sourceFile1);
        $this->assertEquals($fileContent2, include $sourceFile2);
        $this->assertEquals($fileContent3, include $sourceFile3);

        // Check target contents
        $this->assertEquals($fileContent1, include $targetFile1);
        $this->assertEquals($fileContent2, include $targetFile2);
        $this->assertEquals($fileContent3, include $targetFile3);
        $this->assertNotEquals($fileContent3Target, include $targetFile3);
        $this->assertEquals($fileContent4, include $targetFile4);

        // Clean
        removeDir(dirname($sourceDir));
        $this->assertFileNotExists($sourceDir);
        $this->assertFileNotExists($targetDir);
    }

    public function testFileSaveInclude()
    {
        // Prepare files
        $targetDir = storagePath('dirs/save-' . mt_rand(1000, 9999));
        mkdir($targetDir, 0777, true);
        $targetFile = $targetDir . '/include-me.php';
        $fileToBeIncluded = $targetDir . '/to-be-included.php';
        $x = $oldX = 456;
        $y = $newX = 789;
        file_put_contents($fileToBeIncluded, '<?php $x = ' . var_export($y, true) . ';');
        $this->assertFileExists($fileToBeIncluded);

        // Perform save
        fileSaveInclude($targetFile, [$fileToBeIncluded]);

        // Check saved file
        $this->assertFileExists($targetFile);

        // Replace ROOT_PATH with TEST_ROOT_PATH
        file_put_contents($targetFile, str_replace(' ROOT_PATH ', ' TEST_ROOT_PATH ', file_get_contents($targetFile)));

        // Check saved content
        $this->assertEquals($oldX, $x);
        include $targetFile;
        $this->assertEquals($newX, $x);

        // Clean
        removeDir(dirname($targetDir));
        $this->assertFileNotExists($targetFile);
        $this->assertFileNotExists($fileToBeIncluded);
    }

    public function testDetectPhwoolconPackageFiles()
    {
        $vendorDir = dirname(dirname(dirname(dirname(__DIR__))));
        $packageFiles = detectPhwoolconPackageFiles($vendorDir);
        $target = $vendorDir . '/phwoolcon/phwoolcon/phwoolcon-package/phwoolcon-package-phwoolcon.php';
        $this->assertContains($target, $packageFiles);
    }

    public function testEscape()
    {
        $text = '<script>alert(1);</script>';
        $expected = '&lt;script&gt;alert(1);&lt;/script&gt;';
        $this->assertEquals($expected, _e($text));
    }

    public function testArraySortedMerge()
    {
        $array = [
            10 => [                 // 10 is a sort order
                'foo' => 'bar',     // Holds value 'bar' in key 'foo'
                'who' => 'me',
            ],
            20 => [                 // 20 is a bigger sort order
                'foo' => 'baz',     // This will override the key 'foo' with value 'baz'
                'hello' => 'world', // New values will be merged
            ],
        ];
        $expected = [
            'foo' => 'baz',
            'who' => 'me',
            'hello' => 'world',
        ];
        $this->assertEquals($expected, arraySortedMerge($array));
    }
}
