<?php

namespace app\Models;

use CodeIgniter\Model;
use App\Exception\ItemNotFoundException;

class PostModel extends Model
{
    protected $table = 'post';

    protected $allowedFields = [
        'title',
        'author',
        'content',
    ];

    protected $updatedField = 'updated_at';

    public function getAllPosts(): array
    {
        return $this->findAll();
    }

    public function findPost($id): array
    {
        $post = $this
            ->asArray()
            ->where(['id' => $id])
            ->first();

        if (!$post) throw new ItemNotFoundException('Could not find post for specified ID');

        return $post;
    }

    public function savePost(array $postDetails): array
    {
        $postId = (int)$this->insert($postDetails);
        $postDetails['id'] = $postId;
        return $postDetails;
    }

    public function updatePost(int $postId, array $newPostDetails): array
    {
        $this->update($postId, $newPostDetails);
        return $this->findPost($postId);
    }

    public function deletePost($id){
        $post = $this->findPost($id);
        $this->delete($post);
    }
}