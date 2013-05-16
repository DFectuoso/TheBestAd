<?php
namespace Application\Controller;

use Application\Controller\Shared as SharedController;

class Api extends SharedController
{

    public function savePurchaseAction()
    {

        $response = array(
            'status' => 'success',
            'code'   => 'OK'
        );

        $post    = $this->post();
        $storage = $this->getService('purchases.storage');

        $storage->create(
            array(
                 'ad'             => $post['ad'],
                 'price'          => $post['price'],
                 'url'            => $post['url'],
                 'transaction_id' => $post['transaction_id'],
                 'created_at'     => date('Y-m-d h:i:s'),
                 'modified_at'    => date('Y-m-d h:i:s')
            )
        );

        return $this->createResponse($response);
    }

    public function uploadFileAction()
    {

        $response = array();
        $config   = $this->getConfig();
        $file     = $_FILES['file'];
        $s3       = new AmazonS3(
            $config['amazons3']['access'],
            $config['amazons3']['secret']
        );

        $awsResponse = $s3->create_object($config['amazons3']['bucket'], $file['name'],
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

    public function downloadfileAction()
    {

        $config        = $this->getConfig();
        $file          = $config['amazons3']['bucket'] . "/" . urlencode($this->post('file'));
        $downExp       = time() + 10;
        $downStrToSign = "GET\n\n\n$downExp\n$file";
        $downSig       = urlencode(base64_encode(hash_hmac('sha1', $downStrToSign, $config['amazons3']['secret'], true)));
        $downLink      = "http://$file?AWSAccessKeyId=" . $config['amazons3']['access'] . "&Signature=$downSig&Expires=$downExp";
        // ^^^ yes the link looks weird but it's correct

        return $this->createResponse(
               array(
                    'status' => 'success',
                    'code'   => 'OK',
                    'url'    => $downLink
               )
        );
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
