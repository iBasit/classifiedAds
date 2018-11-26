<?php


namespace App\Tests\Controller;


use App\Entity\Ad;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdsControllerTest extends WebTestCase
{
    /**
     * @var array list of ids
     */
    private $id = [];

    public function setUp()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->find(1);

        $ad = new Ad();
        $ad
            ->setTitle('Test #1')
            ->setDescription('Affiliate Ads')
            ->setPrice(5.55)
            ->setUser($user);




        $em->persist($ad);
        $em->flush();

        $this->id[] = $ad->getId();
    }

    public function testCreateAdsSuccessAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_create');

        $data = [
            'title' => 'Ads #1',
            'description' => 'facebook conversion ads',
            'price' => '23.23',
        ];

        $client->request('POST', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    public function testCreateAdsFailedMissingTitleAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_create');

        $data = [
            'description' => 'facebook conversion ads',
            'price' => '23.23',
        ];

        $client->request('POST', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function testCreateAdsFailedMissingDescriptionAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_create');

        $data = [
            'title' => 'Ads #1',
            'price' => '23.23',
        ];

        $client->request('POST', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function testCreateAdsFailedMissingPriceAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_create');

        $data = [
            'title' => 'Ads #1',
            'description' => 'facebook conversion ads',
        ];

        $client->request('POST', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }


    public function testCreateAdsFailedMissingPriceIntegerAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_create');

        $data = [
            'title' => 'Ads #1',
            'description' => 'facebook conversion ads',
            'price' => '34asdf',
        ];

        $client->request('POST', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function testUpdateAdsSuccessAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_update', ['id' => $this->id[0]]);

        $data = [
            'title' => 'Ads #2',
            'description' => 'facebook conversion ads',
            'price' => '23.23',
        ];

        $client->request('PUT', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }



    public function testUpdateAdsFailedMissingTitleAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_update', ['id' => $this->id[0]]);

        $data = [
            'description' => 'facebook conversion ads',
            'price' => '23.23',
        ];

        $client->request('PUT', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function testUpdateAdsFailedMissingDescriptionAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_update', ['id' => $this->id[0]]);

        $data = [
            'title' => 'Ads #1',
            'price' => '23.23',
        ];

        $client->request('PUT', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function testUpdateAdsFailedMissingPriceAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_update', ['id' => $this->id[0]]);

        $data = [
            'title' => 'Ads #1',
            'description' => 'facebook conversion ads',
        ];

        $client->request('PUT', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function testUpdateAdsFailedMissingPriceIntegerAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_update', ['id' => $this->id[0]]);

        $data = [
            'title' => 'Ads #1',
            'description' => 'facebook conversion ads',
            'price' => '34asdf',
        ];

        $client->request('PUT', $url, $data);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function testAdsListSuccessAction()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('ads_list');

        $client->request('GET', $url);

        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertArrayHasKey(0, $responseData, 'must have one or more row in return');

        $ads = $responseData['0'];
        $this->assertArrayHasKey('id', $ads);
        $this->assertArrayHasKey('title', $ads);
        $this->assertArrayHasKey('description', $ads);
        $this->assertArrayHasKey('price', $ads);
        $this->assertArrayHasKey('created', $ads);
        $this->assertArrayHasKey('user', $ads);

        $this->assertArrayHasKey('email', $ads['user']);
        $this->assertArrayHasKey('name', $ads['user']);
    }
}
