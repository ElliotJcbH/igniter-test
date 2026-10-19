<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\LogModel;

class Log extends BaseController
{

    public function index(int $id)
    {
        $model = new LogModel();
        $data = $model->find($id);

        if(! isset($data) || ! array_key_exists('id', $data) || ! isset($data['id'])) {
            return $this->response
                ->setStatusCode(404);
        }

        return $this->response
            ->setStatusCode(200)
            ->setJSON(json_encode($data));
    }

    public function create() {
        $data = $this->request->getJSON(true) ?? [];

        // if(!is_array($data) || !isset($data['message']) || !is_string($data['message'])) {         
        // }

        $rules = [
            'message' => 'required|max_length[2000]|min_length[1]',
        ];

        if(! $this->validateData($data, $rules)) {
            return $this->response
                ->setJSON($this->validator->getErrors())
                ->setStatusCode(400);
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
