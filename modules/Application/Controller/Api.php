<?php
namespace Application\Controller;

use Application\Controller\Shared as SharedController;

class Api extends SharedController
{

    public function getLastUrlAction()
    {

        $storage = $this->getService('purchases.storage');
        $data    = $storage->getLastRow();

        return $this->createResponse(
               array(
                    'status' => 'success',
                    'code'   => 'OK',
                    'data'   => $data->getUrl()
               )
        );
    }


    public function getLastPriceAction()
    {

        $storage = $this->getService('purchases.storage');
        $data    = $storage->getLastRow();

        return $this->createResponse(
            array(
                 'status' => 'success',
                 'code'   => 'OK',
                 'data'   => $data->getPrice()
            )
        );
    }
}
