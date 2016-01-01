<?php

namespace FreeElephants\Configuration\Console\Command;

use FreeElephants\Configuration\AbstractConfigurationUnitTestCase;
use FreeElephants\Configuration\Console\Exception\RuntimeException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Helper\QuestionHelper;

/**
 * @author samizdam
 */
class ConvertConfigCommandTest extends AbstractConfigurationUnitTestCase
{
    protected function setUp()
    {
        foreach (glob(self::OUTPUT_PATH.'*') as $filename) {
            if (basename($filename) === '.gitignore') {
                continue;
            }
            unlink($filename);
        }
        parent::setUp();
    }

    public function testExecuteWithNonExistingSourceFile()
    {
        $command = new ConvertConfigCommand();
        $tester = new CommandTester($command);
        $this->setExpectedException(RuntimeException::class);
        $tester->execute([
            'source' => 'foo.php',
            'dest' => 'foo.json',
        ]);
    }

    public function testExecuteWithInvalidSourceFormat()
    {
        $command = new ConvertConfigCommand();
        $tester = new CommandTester($command);
        $this->setExpectedException(RuntimeException::class);
        $tester->execute([
            'source' => self::FIXTURE_PATH.'foo.php',
            'dest' => 'foo.json',
            '--input-format' => 'txt',
        ]);
    }

    public function testExecuteWithInvalidOutputFormat()
    {
        $command = new ConvertConfigCommand();
        $tester = new CommandTester($command);
        $this->setExpectedException(RuntimeException::class);
        $tester->execute([
            'source' => self::FIXTURE_PATH.'foo.php',
            'dest' => 'foo.json',
            '--output-format' => 'txt',
        ]);
    }

    public function testExecuteWithOutputFormatFromFilename()
    {
        $command = new ConvertConfigCommand();
        $tester = new CommandTester($command);
        $outputFilename = self::OUTPUT_PATH.'foo.json';
        $this->assertFileNotExists($outputFilename);
        $tester->execute([
            'source' => self::FIXTURE_PATH.'foo.php',
            'dest' => $outputFilename,
        ]);
        $this->assertFileExists($outputFilename);
    }

    public function testExecuteWithShowOutput()
    {
        $command = new ConvertConfigCommand();
        $tester = new CommandTester($command);
        $outputFilename = self::OUTPUT_PATH.'foo.json';
        $tester->execute([
            'source' => self::FIXTURE_PATH.'foo.php',
            'dest' => $outputFilename,
            '--show-output' => true,
        ]);
        $this->assertContains('"foo": "bar"', $tester->getDisplay(true));
    }

    public function testExecuteWithShowInput()
    {
        $command = new ConvertConfigCommand();
        $tester = new CommandTester($command);
        $outputFilename = self::OUTPUT_PATH.'foo.json';
        $tester->execute([
            'source' => self::FIXTURE_PATH.'foo.php',
            'dest' => $outputFilename,
            '--show-input' => true,
        ]);
        $this->assertContains("'foo' => 'bar'", $tester->getDisplay(true));
    }

    public function testExecuteOverWritePromptYes()
    {
        list($tester, $command) = $this->getConfiguredCommandTesterAndCommand();
        $outputFilename = self::OUTPUT_PATH.'foo.php';
        $inputFileName = self::FIXTURE_PATH.'foo.php';
        $confirmMock = $this->getMock(QuestionHelper::class);
        $confirmMock->method('ask')->willReturn(true);
        $command->getHelperSet()->set($confirmMock, 'question');

        file_put_contents($outputFilename, 'foo');
        $tester->execute([
            'source' => $inputFileName,
            'dest' => $outputFilename,
        ]);
        $displayOutput = $tester->getDisplay(true);
        $this->assertContains("File {$outputFilename} is overwrited. ", $displayOutput);
    }

    public function testExecuteOverWritePromptNo()
    {
        list($tester, $command) = $this->getConfiguredCommandTesterAndCommand();
        $inputFilename = self::FIXTURE_PATH.'foo.php';
        $outputFilename = self::OUTPUT_PATH.'foo.fake.json';
        $confirmMock = $this->getMock(QuestionHelper::class);
        $confirmMock->method('ask')->willReturn(false);
        $command->getHelperSet()->set($confirmMock, 'question');

        copy($inputFilename, $outputFilename);
        $tester->execute([
            'source' => $inputFilename,
            'dest' => $outputFilename,
        ]);

        $this->assertFileEquals($inputFilename, $outputFilename);
    }

    /**
     * @return [\Symfony\Component\Console\Tester\CommandTester, \FreeElephants\Configuration\Console\Command\ConvertConfigCommand]
     */
    private function getConfiguredCommandTesterAndCommand()
    {
        $command = new ConvertConfigCommand();
        $app = new Application();
        $app->add($command);
        $tester = new CommandTester($command);

        return [$tester, $command];
    }
}
