<?php

namespace App\Command;

use App\Repository\MovieRepository;
use App\ThirdPartyApi\OmdbGateway;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieFetchDescriptionsCommand extends Command
{
    protected static $defaultName = 'app:movie:fetch-descriptions';
    protected static $defaultDescription = 'Fetch missing descriptions from Omdb API.';

    private MovieRepository $movieRepository;
    private OmdbGateway $omdbGateway;
    private EntityManagerInterface $entityManager;

    public function __construct(MovieRepository $movieRepository, OmdbGateway $omdbGateway, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->movieRepository = $movieRepository;
        $this->omdbGateway = $omdbGateway;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('dry-run', 'd', InputOption::VALUE_NONE, 'Show the number of movies that would get a description.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $moviesWithoutDescriptions = $this->movieRepository->findBy(['description' => null]);
        $countMoviesWithoutDescriptions = count($moviesWithoutDescriptions);

        $movieDescribed = 0;

        $progressBar = $io->createProgressBar($countMoviesWithoutDescriptions);

        foreach($moviesWithoutDescriptions as $movie) {
            $description = $this->omdbGateway->getDescriptionByMovie($movie);
            if(!empty($description)) {
                $movie->setDescription($description);
                $movieDescribed++;
            }
            $progressBar->advance(1);
        }
        $progressBar->finish();

        $dryRun = (bool) $input->getOption('dry-run');

        if($movieDescribed > 0 && !$dryRun) {
            $this->entityManager->flush();
        }

        $successMessage = $dryRun ?
            'There would be %d movies updated on %d.'
            : 'All done ! %d movies on %d got their description.';

        $io->success(sprintf($successMessage, $movieDescribed, $countMoviesWithoutDescriptions));

        return Command::SUCCESS;
    }
}
