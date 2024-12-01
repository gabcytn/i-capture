<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    public function index(): string
    {
        $tab = $this->request->getGet("tab");
        if (!$tab) {
            $tab = "foryou";
        }
        $params = [];

        switch ($tab) {
            case "foryou":
                session()->remove("posts");
                $posts = $this->getPostsForForYou(model(PostModel::class));
                break;
            case "following":
                $posts = $this->getPostsForFollowing(model(PostModel::class));
                break;
            case "likes":
                $posts = $this->getPostsForLikes(model(PostModel::class));
                break;
            default:
                return view("errors/html/error_404", ["message" => "Tab $tab is not available"]);
        }

        $params["tab"] = $tab;
        $params["posts"] = $posts;
        return view("home", $params);
    }

    public function search(): string
    {
        $searchUsername = $this->request->getGet("username");
        $params = [];

        if ($searchUsername == "") {
            $params["users"] = [];
            return view("user-views/search", $params);
        }

        $userModel = model(UserModel::class);

        $users = $userModel->search($searchUsername);
        $params["users"] = $users;


        return view("user-views/search", $params);
    }

    public function morePosts(): ResponseInterface
    {
        $postModel = model(PostModel::class);
        $additionalPosts = $postModel->findPostsNotIn(session()->get("posts"), session()->get("username"));
        $this->includeProfilePicLinksInPosts($additionalPosts);
        $this->includeLinkToProfileInPosts($additionalPosts);

        $this->response->setJSON(["posts" => $additionalPosts]);
        return $this->response;
    }

    private function getPostsForForYou(PostModel $postModel): array
    {
        return $postModel->findAllNotLikedBy(session()->get("username"));
    }

    private function getPostsForFollowing(PostModel $postModel): array
    {
        return [];
    }

    private function getPostsForLikes(PostModel $postModel): array
    {

        return [];
    }

    // Include actual links for images
    private function includeProfilePicLinksInPosts(array &$posts): array
    {
        foreach ($posts as &$post) {
            $post->profile_pic = base_url("/" . $post->profile_pic);
        }

        return $posts;
    }

    private function includeLinkToProfileInPosts(array &$posts)
    {
        foreach ($posts as &$post) {
            $post->profile_link = base_url("/" . $post->post_owner);
        }

        return $posts;
    }
}
