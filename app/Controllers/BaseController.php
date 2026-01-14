<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\OfficeModel;  // <- import your model
use App\Models\UserModel;    // <- import your model if needed

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    // protected $session;
    protected $officeModel;
    protected $userModel;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        helper('form'); // <-- Load form helper
        
        // E.g.: $this->session = service('session');
        $this->session = service('session');          // For sessions
        $this->request = service('request');          // HTTP request handler
        $this->response = service('response');        // HTTP response handler
        $this->validation = service('validation');    // For form validation
        $this->email = service('email');              // For sending emails
        $this->pager = service('pager');              // For pagination
        $this->logger = service('logger');            // Logging

        $this->officeModel = new OfficeModel();
        $this->userModel = new UserModel();
    }
}

