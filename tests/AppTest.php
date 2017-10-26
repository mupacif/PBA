<?php
namespace PBA\Tests;


use Symfony\Component\HttpKernel\HttpKernelInterface;
use Silex\WebTestCase;

class AppTest extends WebTestCase
{

    /**
     * Creates the application.
     *
     * @return HttpKernelInterface
     */
    public function createApplication()
    {
        $app = new \Silex\Application();

        require __DIR__.'/../app/dev.php';

        require __DIR__.'/../app/app.php';

        require __DIR__.'/../app/route.php';

        $app['session.test'] = true;
        // Enable anonymous access to admin zone
        $app['security.access_rules'] = array();

        return $app;
    }

    /**
     * Provides all valid application URLs.
     *
     * @return array The list of all valid application URLs.
     */
    public function provideUrls()
    {
        return array(
            array('/'),
            //UserBundle
            array('/User/test'),
            array('/User/signup'),
            array('/User/login'),
            //member
            array('/member/'),
            array('/member/settings'),
        );
    }


    /**
     * Basic, application-wide functional test inspired by Symfony best practices.
     * Simply checks that all application URLs load successfully.
     * During test execution, this method is called for each URL returned by the provideUrls method.
     *
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = $this->createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful(),"url failed");
    }

}