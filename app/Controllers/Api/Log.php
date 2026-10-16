<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\LogModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Log extends BaseController
{
    // protected LogModel $logModel;

    // public function initController(
    //     RequestInterface $request,
    //     ResponseInterface $response,
    //     LoggerInterface $logger
    // ): void {
    //     parent::initController($request, $response, $logger);
    //     $this->logModel = model(LogModel::class);
    // }

    public function index()
    {
        //
    }

    public function create() {
        $data = $this->request->getJSON(true);

        if(!is_array($data) || !isset($data['message']) || !is_string($data['message'])) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['error' => 'A message is required']);
        }

        $model = new LogModel();
        $id = $model->insert([
            'message' => $data['message']
        ]);

        if($id === false) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['errors' => $model->errors()]);
        }

        return $this->response
            ->setStatusCode(201)
            ->setJSON(['id' => $id, 'message' => $data['message']]);
    }
}
