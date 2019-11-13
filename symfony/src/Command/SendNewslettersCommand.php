<?php

namespace App\Command;

use App\DTO\ZdrojakFeedDTO;
use App\Mapper\Devel\ZdrojakFeedMapper;
use App\Repository\Devel\QuestionRepository;
use App\Service\Devel\NewsletterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SendNewslettersCommand extends Command {

    /**
     * @var NewsletterService
     */
    protected $newsletterService;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var ZdrojakFeedMapper
     */
    protected $mapper;

    /**
     * @var QuestionRepository
     */
    protected $questionRepository;

    /**
     * @param string $url
     * @param NewsletterService $newsletterService
     * @param ZdrojakFeedMapper $mapper
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        string $url,
        NewsletterService $newsletterService,
        ZdrojakFeedMapper $mapper,
        QuestionRepository $questionRepository
    ) {
        $this->newsletterService = $newsletterService;
        $this->url = $url;
        $this->mapper = $mapper;
        $this->questionRepository = $questionRepository;
        parent::__construct();
    }


    public function configure() {
        $this->setName('newsletters:send')
            ->setDescription('Send devel.cz newsletters.')
            ->setHelp('This command will send regular devel.cz newsletters...');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws ClientExceptionInterface
     * @throws LoaderError
     * @throws RedirectionExceptionInterface
     * @throws RuntimeError
     * @throws ServerExceptionInterface
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        $rawRssContent = HttpClient::create()->request('GET', $this->url)->getContent(true);
        $mappedContent = $this->mapper->mapRawFeedToCollection($rawRssContent);

        return $this->send($mappedContent);
    }

    /**
     * @param $mappedContent
     * @return int
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function send($mappedContent) {
        $questions = $this->questionRepository->getAllInLastWeek();

        $articles = array_filter($mappedContent, function (ZdrojakFeedDTO $dto) {
            return $dto->isFromLastWeek() && $dto->isArticle();
        });

        $news = array_filter($mappedContent, function (ZdrojakFeedDTO $dto) {
            return $dto->isFromLastWeek() && $dto->isNews();
        });


        return $this->newsletterService->sendNewsletters(
            $questions,
            $news,
            $articles
        );
    }
}