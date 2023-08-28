<?php

namespace App\Infrastructure\ExternalSource;

use Symfony\Component\DomCrawler\Crawler;
use App\Domain\ExternalSource\ExternalSourceProductDto;
use App\Domain\ExternalSource\ExternalProductSourceInterface;

class AlzaCzParser extends AbstractParser implements ExternalProductSourceInterface
{
    public function getProduct(string $url): ExternalSourceProductDto
    {
        $crawler = $this->getCrawler($url);

        $photo = $this->extractPhoto($crawler);
        $title = $this->extractTitle($crawler);
        $price = $this->extractPrice($crawler);

        return new ExternalSourceProductDto($title, $price, $photo);
    }

    private function extractTitle(Crawler $crawler): ?string
    {
        $titleNode = $crawler->filter('h1[itemprop="name"]');

        return $this->isEmptyNode($titleNode) ? null : $titleNode->text();
    }

    private function extractPrice(Crawler $crawler): ?int
    {
        $priceNode = $crawler->filter('.price-box__price');

        return $this->isEmptyNode($priceNode) ? null : $this->fetchPriceFromString($priceNode->text());
    }

    private function extractPhoto(Crawler $crawler): ?string
    {
        $photoNode = $crawler->filter('img[class*="detailGallery"][alt*="Main"]');

        return $this->isEmptyNode($photoNode) ? null : $photoNode->attr('src');
    }
}
