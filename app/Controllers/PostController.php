<?php

namespace app\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Exception\ItemNotFoundException;

class PostController extends BaseController
{
    public function create()
    {
        $rules = [
            'title' => 'required|min_length[6]|max_length[100]',
            'author' => 'required|min_length[6]|max_length[100]',
            'content' => 'required|min_length[6]|max_length[1000]',
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $model = new PostModel();
        $savePostResponse = $model->savePost($input);
        return $this->getResponse(
            [
                'message' => 'Post added successfully',
                'post' => $savePostResponse
            ],
            ResponseInterface::HTTP_CREATED
        );
    }

    public function index()
    {
        $model = new PostModel();
        return $this->getResponse([
            'message' => 'Posts retrieved successfully',
            'posts' => $model->getAllPosts()
        ]);
    }

    public function show($id)
    {
        $model = new PostModel();
        try {
            return $this->getResponse([
                'message' => 'Post retrieved successfully',
                'post' => $model->findPost($id)
            ]);
        } catch (ItemNotFoundException $e) {
            return $this->getResponse([
                'message' => $e->getMessage(),
            ],
                ResponseInterface::HTTP_NOT_FOUND);
        }
    }

    public function update($id)
    {
        $input = $this->getRequestInput($this->request);
        $model = new PostModel();
        $updatePostResponse = $model->updatePost($id, $input);

        return $this->getResponse(
            [
                'message' => 'Post updated successfully',
                'post' => $updatePostResponse
            ]
        );
    }

    public function delete($id){
        $model = new PostModel();
        $model->deletePost($id);

        return $this->getResponse(
            [
                'message' => 'Post deleted successfully',
            ]
        );
    }
}