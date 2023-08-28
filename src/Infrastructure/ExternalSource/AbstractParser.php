<?php

namespace App\Infrastructure\ExternalSource;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractParser
{
    private HttpClientInterface $httpClient;

    protected const USER_AGENT_LIST = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Safari/605.1.15',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 13_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Safari/605.1.15'
    ];

    protected const COMMON_HEADERS = [
        'Accept' => 'text/html',
        'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
        'Connection' => 'keep-alive',
        'Upgrade-Insecure-Requests' => '1',
        'Sec-Fetch-Dest' => 'document',
        'Sec-Fetch-Mode' => 'navigate',
        'Sec-Fetch-Site' => 'same-origin',
        'Sec-Fetch-User' => '?1',
        'Pragma' => 'no-cache',
        'Cache-Control' => 'no-cache',
        'TE' => 'trailers'
    ];

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    protected function getCrawler(string $url): Crawler
    {
        $headers = self::COMMON_HEADERS;

        for ($attempt = 1; $attempt <= 3; $attempt++) {
            $headers['User-Agent'] = $this->getRandomUserAgent();

            $response = $this->httpClient->request('GET', $url, ['headers' => $headers]);

            if ($response->getStatusCode() === Response::HTTP_OK) {
                return new Crawler($response->getContent());
            }

            sleep($this->getRandomSleepTime());
        }

        return new Crawler();
    }


    protected function isEmptyNode(Crawler $node): bool
    {
        return $node->count() === 0;
    }

    protected function fetchPriceFromString(string $priceText): int
    {
        return (int) preg_replace('/\D/', '', $priceText);
    }

    private function getRandomUserAgent(): string
    {
        $randomIndex = array_rand(self::USER_AGENT_LIST);

        return self::USER_AGENT_LIST[$randomIndex];
    }

    private function getRandomSleepTime(): int
    {
        return random_int(5, 10);
    }
}
