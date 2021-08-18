<?php

namespace App\Services;

use App\Services\SirvAPIClient;

class Sirv
{
    protected $sirv;
    protected $clientID;
    protected $secretID;
    protected $token;
    protected $tokenExpireTime;
    protected $userAgent;

    public function __construct()
    {
        $this->clientID = env("SIRV_CLIENT_ID");
        $this->secretID = env("SIRV_CLIENT_SECRET");
        $this->userAgent = "SIRV PHP Client";

        $this->sirv = new SirvAPIClient(
            $this->clientID,
            $this->secretID,
            "",
            "",
            $this->userAgent,
        );

        if ($this->sirv->isConnected()) {
            $this->token = $this->sirv->getToken();
            $this->tokenExpireTime = $this->sirv->getTokenExpireTime();

            $this->sirv = new SirvAPIClient(
                $this->clientID,
                $this->secretID,
                $this->token,
                $this->tokenExpireTime,
                $this->userAgent,
            );
        }
    }

    public function uploadFile($filePath, $sirvUploadPath)
    {
        return $this->sirv->uploadFile($filePath, $sirvUploadPath);
    }
}
