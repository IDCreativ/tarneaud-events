<?php

namespace App\Service;

use DateTime;
use DateInterval;
use App\Entity\Event;
use App\Entity\GeneralConfiguration;
use App\Repository\PageConfigRepository;
use App\Repository\GeneralConfigurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GlobalVariablesCatcher extends AbstractController
{
    private $generalConfigurationRepository;

    public function __construct(GeneralConfigurationRepository $generalConfigurationRepository)
    {
        $this->generalConfigurationRepository = $generalConfigurationRepository;
    }

    public function websiteConfig()
    {
        $configSite = $this->generalConfigurationRepository->findLast();
        $date = new DateTime();
        $nextDate = $date->add(new DateInterval('P30D'));
        $defaultEvent = new Event;
        $defaultEvent->setName('Événement par défaut')
            ->setDateStart(new \DateTime())
            ->setDateEnd($nextDate)
            ->setActive(false)
        ;
        if (!$configSite) {
            $configSite = new GeneralConfiguration;
            $configSite
                ->setTitle('Titre de votre site')
                ->setTagline('Your tagline here')
                ->setEvent($defaultEvent)
            ;
        }
        return $configSite;
    }
}
