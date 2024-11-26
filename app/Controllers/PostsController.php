<?php

namespace App\Controllers;

use App\Models\LikesModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class PostsController extends BaseController
{
    public function posts(int $postID): string
    {
        $sessionUser = session()->get("username");

        $postModel = model(PostModel::class);
        $userModel = model(UserModel::class);
        $likesModel = model(LikesModel::class);

        $params = [];
        $params["post"] = $postModel->find($postID);

        if (!$params["post"]) {
            $params["message"] = "Post not found";
            return view("errors/html/error_404", $params);
        }

        $params["postOwnerProfile"] = $userModel->find($params["post"]["post_owner"])["profile_pic"];
        $params["isLikedByThisUser"] = $likesModel->isLikedByThisUser($postID, $sessionUser);

        if ($params["post"]["post_owner"] == $sessionUser) {
            return view("posts-views/your-posts", $params);
        }

        return view("posts-views/other-posts", $params);
    }

    public function unlike(int $postID): ResponseInterface
    {
        $currentUser = session()->get("username");

        $likesModel = model(LikesModel::class);

        $likesModel->unlike($postID, $currentUser);

        return $this->response->setStatusCode(200);
    }

    public function like(int $postID): ResponseInterface
    {
        $currentUser = session()->get("username");

        $likesModel = model(LikesModel::class);

        $likesModel->like($postID, $currentUser);

        return $this->response->setStatusCode(200);
    }

    public function delete(int $postId): ResponseInterface
    {
        $currentUser = session()->get("username");

        $postModel = model(PostModel::class);
        $likesModel = model(LikesModel::class);

        $likesModel->deleteAllWherePostId($postId);
        $this->deleteImageInCloudinary($postId, $postModel);
        $postModel->delete($postId);

        return $this->response->setJSON(["redirect" => base_url("/$currentUser")]);
    }

    public function createPost(): RedirectResponse
    {
        $imageFile = $this->request->getFile("image");
        $imageTypes = ["image/png", "image/jpg"];

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved() && in_array($imageFile->getMimeType(), $imageTypes)) {
            Configuration::instance(getenv("CLOUDINARY_URL"));
            $upload = new UploadApi();
            $uploadDetails = json_encode(
                $upload->upload($imageFile->getTempName(), [
                    "use_filename" => false,
                    "unique_filename" => true,
                    "overwrite" => true
                ])
            );
            $uploadDetails = json_decode($uploadDetails, true);

            $postOwner = session()->get("username");
            $imageLink = $uploadDetails["secure_url"];
            $publicId = $uploadDetails["public_id"];

            $postModel = model(PostModel::class);

            $postModel->save([
                "post_owner" => $postOwner,
                "photo_url" => $imageLink,
                "photo_public_id" => $publicId
            ]);

            return redirect()->to(base_url($postOwner));
        }
        return redirect()->back();
    }

    private function deleteImageInCloudinary(string $postId, PostModel $postModel): void
    {
        Configuration::instance(getenv("CLOUDINARY_URL"));
        $upload = new UploadApi();

        $post = $postModel->find($postId);
        $upload->destroy($post["photo_public_id"]);
    }
}
