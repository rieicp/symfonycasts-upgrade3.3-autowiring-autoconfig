<?php

namespace AppBundle\EventSubscriber;
use AppBundle\Service\MessageManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AddNiceheaderSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var MessageManager
     */
    private $messageManager;

    public function __construct(LoggerInterface $logger, MessageManager $messageManager)
    {
        $this->logger = $logger;
        $this->messageManager = $messageManager;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $this->logger->info('Adding a nice header!');

        $message = $this->messageManager->getEncouragingMessage();

        $event->getResponse()
            ->headers->set('X-NICE-MESSAGE', $message);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse'
        ];
    }

}
