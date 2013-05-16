<?php
namespace Application\Controller;

use Application\Controller\Shared as SharedController;

class Api extends SharedController
{

    public function uploadFileAction()
    {

        $response = array();
        $config   = $this->getConfig();

        $file = $_FILES['file'];
        $s3   = new AmazonS3($config['amazons3']['access'], $config['amazons3']['secret']);

        $awsResponse = $s3->create_object('bestad', $file['name'],
              array(
                   'fileUpload'  => fopen($file['tmp_name'], 'r'),
                   'contentType' => $file['type'],
                   'length'      => $file['size'],
                   'acl'         => AmazonS3::ACL_PRIVATE,
                   'storage'     => AmazonS3::STORAGE_REDUCED
              )
        );

        if ($awsResponse->isOK()) {
            $response = array(
                'status' => 'success',
                'code'   => 'OK'
            );
        } else {
            $response = array(
                'status' => 'error',
                'code'   => 'E_FILE_NOT_UPLOADED'
            );
        }

        return $this->createResponse($response);
    }

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