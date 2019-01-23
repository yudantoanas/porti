<?php

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

defined('BASEPATH') OR exit('No direct script access allowed');

class LineBotController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    private $bot;
    private $httpClient;
    private $signature;

    /**
     * LineBot constructor.
     * @param $bot
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('Service');

        // create bot object
        $this->httpClient = new CurlHTTPClient("tCophUG2l0xpZY+BPf1PMdMLqu5D+iqierAYS7WI7BvXHMqspKVHGisXRj1y1K/GoM+Xeao120BoA3B8N+plhmwao+5GbotYw+IjcpoJHKeoeksEgQzy/F6LBUEy3/nhWeQE2qTpnhO+Sz17VPi5ogdB04t89/1O/w1cDnyilFU=");
        $this->bot  = new LINEBot($this->httpClient, ['channelSecret' => "eaa5e2c5383834d2c07d3fe408a387d3"]);
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function test()
    {
        $flexTemplate = file_get_contents("event-line.json");

        var_dump(json_decode($flexTemplate));
    }

	public function webhook()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Hello Coders!";
            header('HTTP/1.1 400 Only POST method allowed');
            exit;
        }

        // get request
        $body = file_get_contents('php://input');
        $this->signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : "-";

        $data = json_decode($body, true);
        if (is_array($data['events'])) {
            foreach ($data['events'] as $event) {
                if ($event['type'] == 'message') {
                    if ($event['message']['type'] == 'text') {
                        switch (strtolower($event['message']['text'])) {
                            case 'halo':
                                $result = $this->bot->getProfile($event['source']['userId']);
                                $result = $this->bot->replyText($event['replyToken'],
                                    "Halo juga, Kak ".$result->getJSONDecodedBody()['displayName']);
                                return $result->getHTTPStatus();
//                            case 'cari jasa':
//                                $result = $this->httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
//                                    'replyToken' => $event['replyToken'],
//                                    'messages' => [
//                                        [
//                                            'type' => 'flex',
//                                            'altText' => 'Flex Message',
//                                            'contents' => json_decode($this->Service->getService()),
//                                        ]
//                                    ],
//                                ]);
//                                return $result->getHTTPStatus();
                            case 'browse equipment':
                                // get from endpoint
//                                $flexTemplate = file_get_contents("event-line.json");
                                $result = $this->httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                                    'replyToken' => $event['replyToken'],
                                    'messages' => [
                                        [
                                            'type' => 'flex',
                                            'altText' => 'Flex Message',
                                            'contents' => json_decode($this->Service->getService())
                                        ]
                                    ],
                                ]);

                                error_log(json_decode($this->Service->getService()));

                                return $result->getHTTPStatus();
                        }
                    }
                }
            }
        }
        return http_response_code(200);
    }
}
