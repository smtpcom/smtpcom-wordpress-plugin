<?php

namespace SmtpSdk\Tests\HttpClient;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Exception\HttpException;
use SmtpSdk\HttpClient\HttpRequest;

/**
 * Exercises the default HTTP client against a real PHP built-in server.
 */
class HttpRequestTest extends TestCase
{
    /**
     * @var resource|null
     */
    private static $server;

    /**
     * @var string
     */
    private static $baseUrl;

    /**
     * @var string
     */
    private static $log;

    public static function setUpBeforeClass(): void
    {
        $socket = stream_socket_server('tcp://127.0.0.1:0');
        $address = stream_socket_get_name($socket, false);
        fclose($socket);

        self::$baseUrl = 'http://' . $address;
        self::$log = tempnam(sys_get_temp_dir(), 'smtpsdk');
        self::$server = proc_open(
            [PHP_BINARY, '-S', $address, __DIR__ . '/fixtures/router.php'],
            [['pipe', 'r'], ['file', '/dev/null', 'w'], ['file', '/dev/null', 'w']],
            $pipes,
            null,
            ['SMTPSDK_TEST_LOG' => self::$log]
        );

        for ($i = 0; $i < 50; $i++) {
            $connection = @fsockopen('127.0.0.1', (int)parse_url(self::$baseUrl, PHP_URL_PORT));
            if ($connection) {
                fclose($connection);
                return;
            }
            usleep(100000);
        }
        self::fail('PHP built-in server did not start');
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$server) {
            proc_terminate(self::$server);
            proc_close(self::$server);
        }
        @unlink(self::$log);
    }

    protected function setUp(): void
    {
        file_put_contents(self::$log, '');
    }

    public function testRequestUsesDefaultClient()
    {
        $request = new HttpRequest('apiKey', self::$baseUrl, 'v4');

        $this->assertEquals(
            ['status' => 'success', 'data' => ['method' => 'GET']],
            $request->request('GET', 'account')
        );
        $this->assertEquals("GET /v4/account\n", file_get_contents(self::$log));
    }

    public function testRedirectIsNotFollowed()
    {
        $request = new HttpRequest('apiKey', self::$baseUrl . '/redirect', 'v4');

        try {
            $request->request('POST', 'account', ['name' => 'value']);
            $this->fail('Redirect response must raise an exception');
        } catch (HttpException $exception) {
            $this->assertEquals('Unknown HTTP code 302', $exception->getMessage());
        }
        $this->assertEquals('', file_get_contents(self::$log), 'Redirect target must not be requested');
    }
}
