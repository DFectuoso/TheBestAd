<?php
namespace Application\Controller;

use Application\Controller\Shared as SharedController;

class Index extends SharedController
{

    public function indexAction()
    {

        // download last picture

        return $this->render('Application:index:index.html.php');
    }

}
