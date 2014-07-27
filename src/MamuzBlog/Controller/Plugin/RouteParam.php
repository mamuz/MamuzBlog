<?php

namespace MamuzBlog\Controller\Plugin;

use MamuzBlog\Feature\Pageable;

class RouteParam extends AbstractPlugin
{
    /**
     * @param Pageable $service
     * @return void
     */
    public function mapPageTo(Pageable $service)
    {
        $service->setCurrentPage($this->getPageParam());
    }

    /**
     * @return int
     */
    private function getPageParam()
    {
        if ($mvcController = $this->getMvcController()) {
            return (int) $mvcController->params()->fromRoute('page', 1);
        }

        return 1;
    }
}
