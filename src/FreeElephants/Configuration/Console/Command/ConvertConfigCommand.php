<?php

namespace FreeElephants\Configuration\Console\Command;

use FreeElephants\Configuration\Console\Exception\RuntimeException;
use FreeElephants\Configuration\FormatNameNormalizer;
use FreeElephants\Configuration\Reader\ReaderFactory;
use FreeElephants\Configuration\Writer\WriterFactory;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 *
 *
 * @author samizdam
 *
 */
class ConvertConfigCommand extends AbstractCommand
{

    const ARGUMENT_SOURCE = "source";
    const ARGUMENT_DEST = "dest";

    const OPTION_FORCE = "force";

    const OPTION_OUPUT_FORMAT = "output-format";
    const OPTION_INPUT_FORMAT = "input-format";

    const OPTION_DRY_RUN = "dry-run";

    const OPTION_SHOW_OUTPUT = "show-output";

    const OPTION_SHOW_INPUT = "show-input";

    public function getDefaultName()
    {
        return "config:convert";
    }

    protected function configure()
    {
        $this->addArgument(self::ARGUMENT_SOURCE, InputArgument::REQUIRED, "Source config file");
        $this->addArgument(self::ARGUMENT_DEST, InputArgument::REQUIRED, "Distance config file");

        $this->addOption(self::OPTION_INPUT_FORMAT, "i", InputOption::VALUE_OPTIONAL, "Use given format for input instead file extension.");
        $this->addOption(self::OPTION_OUPUT_FORMAT, "o", InputOption::VALUE_OPTIONAL, "Use given format for output instead file extension.");

        $this->addOption(self::OPTION_FORCE, "f", InputOption::VALUE_NONE, "Override existed dest file without prompt. ");
        $this->addOption(self::OPTION_DRY_RUN, null, InputOption::VALUE_NONE, "Not wrtie dest file. ");

        $this->addOption(self::OPTION_SHOW_OUTPUT, 'd', InputOption::VALUE_NONE, "Show output content in console. ");
        $this->addOption(self::OPTION_SHOW_INPUT, 's', InputOption::VALUE_NONE, "Show source file content in output. ");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputFilename = $input->getArgument(self::ARGUMENT_SOURCE);
        $outputFilename = $input->getArgument(self::ARGUMENT_DEST);
        if(!file_exists($inputFilename)){
            throw new RuntimeException("Input file not exists. ");
        }

        $configFormatNormalizer = new FormatNameNormalizer();

        if(!$inputFormat = $input->getOption(self::OPTION_INPUT_FORMAT)){
            $inputFormat = pathinfo($inputFilename, PATHINFO_EXTENSION);
        }

        $inputFormat = $configFormatNormalizer->normalizeFormat($inputFormat);

        if(!$configFormatNormalizer->isValidFormat($inputFormat)){
            throw new RuntimeException("{$inputFormat} not supported, valid values: " . join(", ", $configFormatNormalizer->getValidFormats()));
        }

        if(!$outputFormat = $input->getOption(self::OPTION_OUPUT_FORMAT)){
            $outputFormat = pathinfo($outputFilename, PATHINFO_EXTENSION);
        }

        $outputFormat = $configFormatNormalizer->normalizeFormat($outputFormat);

        if(!$configFormatNormalizer->isValidFormat($outputFormat)){
            throw new RuntimeException("{$outputFormat} not supported, valid values: " . join(", ", $configFormatNormalizer->getValidFormats()));
        }


        $configReader = (new ReaderFactory())->createReader($inputFormat);
        $sourceData = $configReader->readFile($inputFilename);

        if($input->getOption(self::OPTION_SHOW_INPUT))
        {
            $output->writeln(file_get_contents($inputFilename));
        }

        $configWriter = (new WriterFactory())->createWriter($outputFormat);
        if($input->getOption(self::OPTION_SHOW_OUTPUT))
        {
            $distData = $configWriter->toString($sourceData);
            $output->writeln($distData);
        }

        $dryRun = $input->getOption(self::OPTION_DRY_RUN);
        $approved = true;
        if(file_exists($outputFilename)){
            $questionHelper = $this->getHelper('question');
            /* @var $questionHelper Question */
            $overwriteConfirm = new ConfirmationQuestion("Overwrite existing dest file?", false);
            if($approved = $questionHelper->ask($input, $output, $overwriteConfirm)){
                $output->writeln("File {$outputFilename} is overwrited. ");
            }
        }

        if($dryRun === false & $approved){
            $configWriter->writeFile($outputFilename, $sourceData);
        }
    }

}