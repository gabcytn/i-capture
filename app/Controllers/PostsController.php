<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;

class PostsController extends BaseController
{
    public function posts ($postID)
    {
        $postModel = model(PostModel::class);
        $params["post"] = $postModel->find($postID);

        return view("posts-views/your-posts", $params);
    }
}