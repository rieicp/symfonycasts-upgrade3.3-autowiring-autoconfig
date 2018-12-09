<?php

namespace AppBundle\EventSubscriber;
use AppBundle\Service\MessageManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AddNiceheaderSubscriber implements EventSubscriberInterface
{
    private $logger;
    private $messageManager;
    private $isShowDiscouratingMessage;

    public function __construct(LoggerInterface $logger, MessageManager $messageManager, $isShowDiscouratingMessage)
    {
        $this->logger = $logger;
        $this->messageManager = $messageManager;
        $this->isShowDiscouratingMessage = $isShowDiscouratingMessage;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $this->logger->info('Adding a nice header!');

        $message = $this->isShowDiscouratingMessage?
            $this->messageManager->getDiscouragingMessage() :
            $this->messageManager->getEncouragingMessage();

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
