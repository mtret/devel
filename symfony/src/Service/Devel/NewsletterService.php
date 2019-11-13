<?php

namespace App\Service\Devel;

use App\DTO\ZdrojakFeedDTO;
use App\Entity\Devel\Question;
use App\Entity\Devel\User;
use App\Repository\Devel\UserRepository;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class NewsletterService {

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var Environment
     */
    protected $templating;

    public function __construct(UserRepository $userRepository, Swift_Mailer $mailer, Environment $templating) {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param Question[] $questions
     * @param ZdrojakFeedDTO[] $news
     * @param ZdrojakFeedDTO[] $articles
     * @return int
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendNewsletters($questions, $news, $articles) {
        $message = (new Swift_Message('Newsletter'))
            ->setFrom('send@example.com')
            ->setTo(array_map(function (User $user) {
                return $user->getEmail();
            }, $this->userRepository->getAllSubscribed()))
            ->setBody(
                $this->templating->render(
                    'emails/newsletter.html.twig',
                    [
                        'questions' => $questions,
                        'articles' => $articles,
                        'news' => $news
                    ]
                ),
                'text/html'
            )
            ->addPart(
                $this->templating->render(
                    'emails/newsletter.txt.twig',
                    [
                        'questions' => $questions,
                        'articles' => $articles,
                        'news' => $news
                    ]
                ),
                'text/plain'
            );

        return (bool) $this->mailer->send($message);
    }

}