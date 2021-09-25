<?php

namespace App\Services;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseService
{
    protected $apiBaseUrl;
    /** @var int */
    protected int $requestTimeout = 8;
    protected string $apiKey;
    protected array $headers;

    public function __construct()
    {
        $this->apiBaseUrl = config('config.api_base_url');
        $this->setApiKey(config('config.api_key'));
        $this->setHeaders([]);
    }

    /**
     * @return PendingRequest
     */
    protected function createClient(): PendingRequest
    {
        $client = Http::timeout($this->requestTimeout)
            ->withOptions(['verify' => false]);

        if (isset($this->token)) {
            $client->withToken(trim(trim($this->token, 'Bearer')));
        }
        if (isset($this->headers)) {
            $client->withHeaders($this->headers);
        }

        return $client;
    }

    /**
     * @param string $url
     * @param array $params
     * @param int $retry
     * @return object
     * @throws AuthorizationException
     */
    public function get(string $url, array $params = [], int $retry = 2): object
    {
        $url = $this->getUrl($url);
        $client = $this->createClient()
            ->retry($retry, 100);

        $params = array_merge($params, ['api_key' => $this->apiKey]);

        $res = $client->get($url, $params);

        $this->requestExceptionHandler($res, $url);

        return $res->object();
    }

    /**
     * @param string $url
     * @param array $params
     * @param int $retry
     * @return object
     * @throws AuthorizationException
     */
    public function post(string $url, array $params = [], int $retry = 2): object
    {
        $url = $this->getUrl($url);
        $client = $this->createClient()
            ->retry($retry, 100);

        $params = array_merge($params, ['api_key' => $this->apiKey]);
        $res = $client->post($url, $params);

        $this->requestExceptionHandler($res, $url);

        return $res->object();
    }

    protected function setHeaders(array $headers)
    {
        $this->headers = array_merge(['accept' => 'application/json'], $headers);
    }

    public function setApiKey(string $key)
    {
        $this->apiKey = $key;
    }


    /**
     * @param string $url
     * @return $this
     */
    protected function setBaseUrl(string $url): self
    {
        $this->apiBaseUrl = $url;
        return $this;
    }

    protected function getUrl(string $url): string
    {
        return $this->apiBaseUrl . $url;
    }

    /**
     * @param Response $response
     * @param string $url
     * @throws AuthorizationException
     * @throws NotFoundHttpException
     * @throws HttpException
     */
    protected function requestExceptionHandler(Response $response, string $url): void
    {
        if ($response->clientError()) {
            if ($response->status() == 401 || $response->status() == 403 || $response->status() == 422) {
                throw new AuthorizationException();
            }
            throw new NotFoundHttpException($response->body(), null, 404);
        }
        if ($response->serverError()) {
            $message = "Request Exception: " . $response->body() . "(" . $url . ")";
            throw new HttpException(500, 'API Request Exception : ' . $message);
        }
    }
}
