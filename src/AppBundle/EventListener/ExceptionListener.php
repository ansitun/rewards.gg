<?php

/**
 * Exception listener class for the kernel exceptions.
 *
 * @author
 *
 * @category Listener
 */
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class ExceptionListener extends \Exception
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * 
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        //getting the exception message
        $errorMsg = $event->getException()->getMessage();
        $status = method_exists($event->getException(), 'getStatusCode') ? $event->getException()->getStatusCode() : 500;
        // Logging the exception
        $this->logger->error('Error', array($status => $errorMsg, 'TRACE' => $event->getException()->getTraceAsString()));
        $response = new JsonResponse(array("Error" => $errorMsg), 401);
        // setting the error response
        $event->setResponse($response);
    }
}
