<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;




/**
 * vessel test case.
 */
class vesselTest extends TestCase
{

    /**
     *
     * @var vessel
     */
    private $vessel;
     /** @var \Slim\App */
    public $request;
    public $response;
    private $cookies = array();

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void 
    {
        parent::setUp();

        // TODO Auto-generated vesselTest::setUp()

    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        // TODO Auto-generated vesselTest::tearDown()
        $this->vessel = null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }
    
 	
    public function getPositionTest
    {
    	$_SERVER['REQUEST_METHOD'] = 'GET';
    	$_SERVER['REQUEST_URI'] = 'http://localhost/vesselApi/index.php/listAll/json';
    	
    	$vPos = new controller\vPositionController;
    	$vPos->listAll(50,'json');
    	

    }
    
	 public function setUpXml()
	 {
	     $uri = Uri::createFromString('http://localhost/vesselApi/index.php/listAll/xml');
	     $headers = new Headers();
	     $headers->set('Content-Type', 'application/xml;charset=utf8');
	     $cookies = [];
	     $env = Environment::mock(['SCRIPT_NAME' => '/index.php', 'REQUEST_URI' => '/listAll/json', 'REQUEST_METHOD' => 'GET']);
	     $serverParams = $env->all();
	     $body = new RequestBody();
	     $this->request = new Request('GET', $uri, $headers, $cookies, $serverParams, $body);
	     $this->response = new Response();
	      
	     $this->response = $app($this->request, $response);
	     // Return the application output.
	     $this->assertEmpty($this->response->getBody());
	     
	 }
	 

		public function testPOST()
		{
		    // create our http client (Guzzle)
		    $client = new Client('http://localhost/vesselApi/index.php/listAll/xml', array(
		        'request.options' => array(
		            'exceptions' => false,
		        )
		    ));
		
		    $nickname = 'ObjectOrienter'.rand(0, 999);
		    $data = array(
		        'nickname' => $nickname,
		        'avatarNumber' => 5,
		        'tagLine' => 'a test dev!'
		    );
		
		    $request = $client->get('/api/programmers', null, json_encode($data));
		    $response = $request->send();
		}
}

