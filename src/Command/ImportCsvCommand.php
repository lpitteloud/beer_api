<?php

declare(strict_types=1);

namespace App\Command;

use App\Exception\CsvImportException;
use App\Handler\CsvImportHandler;
use League\Csv\UnableToProcessCsv;
use League\Csv\UnavailableStream;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-csv',
    description: 'Import beer data from a CSV file'
)]
class ImportCsvCommand extends Command
{
    public function __construct(
        private readonly CsvImportHandler $csvHandler
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('filePath', InputArgument::OPTIONAL, 'Path to the CSV file', __DIR__ . '/../../open-beer-database.csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('filePath');

        try {
            $result = $this->csvHandler->import($filePath);

            $io->success('data imported successfully');

            $io->title('Import Summary');
            $io->table(
                ['Metric', 'Count'],
                [
                    ['Total rows processed', $result->getTotalCount()],
                    ['Valid entities', $result->getValidCount()],
                    ['Invalid entities', $result->getInvalidCount()],
                ]
            );

            return Command::SUCCESS;
        } catch(UnavailableStream $unavailableStreamException) {
            $io->error('filepath could not be found or read. reason: ' . $unavailableStreamException->getMessage());

            return Command::FAILURE;
        } catch (UnableToProcessCsv $unableToProcessCsvException) {
            $io->error('file could not be processed. reason: ' . $unableToProcessCsvException->getMessage());

            return Command::FAILURE;
        } catch (CsvImportException $csvImportException) {
            $io->error('could not process a line. reason: ' . $csvImportException->getMessage());
        }
    }
}
