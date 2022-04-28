<?php

namespace App\Service;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GlobalPagesCatcher extends AbstractController
{
    private $pageRepository;

    public function __construct(
        PageRepository $pageRepository
    )
    {
        $this->pageRepository = $pageRepository;
    }

    public function allPages()
    {
        return $this->pageRepository->findByStatus(1);
    }
}
