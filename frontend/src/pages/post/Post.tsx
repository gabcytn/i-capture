import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router";
import styles from "./Post.module.css";
import Button from "../../components/Button";
import SideNav from "../../components/SideNav/SideNav";
import NotFound from "../NotFound";

type PostTypes = {
  profilePic: string;
  postOwner: string;
  photoUrl: string;
  isLiked: boolean;
  likes: number;
};

function Post() {
  const navigate = useNavigate();
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  const postId = useParams().segment;
  const [post, setPost] = useState<PostTypes | null>(null);
  const [likeCount, setLikeCount] = useState<number>(0);
  const [isLiked, setIsLiked] = useState<boolean>(false);
  const [isNotFound, setIsNotFound] = useState<boolean | null>(null);

  const unlike = async () => {
    setIsLiked(false);
    setLikeCount((prev) => prev - 1);
    // TODO: PUT request to unlike the post
  };

  const like = async () => {
    setIsLiked(true);
    setLikeCount((prev) => prev + 1);
    // TODO: PUT request to unlike the post
  };

  useEffect(() => {
    const fetchData = async () => {
      const res = await fetch(`${SERVER_URL}/post/${postId}`, {
        method: "GET",
        credentials: "include",
      });
      switch (res.status) {
        case 200: {
          const data = await res.json();
          setPost(data);
          setLikeCount(data.likes);
          setIsLiked(data.isLiked);
          break;
        }
        case 400:
        case 404:
          setIsNotFound(true);
          break;

        case 403:
          alert("Your session has expired\nLogging out now");
          sessionStorage.clear();
          navigate("/login");
          break;

        default:
          console.log("default");
          console.log(res.status);
          break;
      }
    };
    fetchData();
  }, [SERVER_URL, postId, navigate]);
  if (isNotFound) return <NotFound />;
  return (
    <>
      <SideNav />
      <div className="container">
        <div className="row">
          <div className="col-12 d-flex my-3 align-items-center justify-content-between">
            <div className="d-flex align-items-center">
              <img
                src={post?.profilePic}
                alt="Post owner profile picture"
                className={styles.postOwnerProfile}
              />
              <a href="" className={`${styles.usernameLink} ms-3`}>
                @<strong>{post?.postOwner}</strong>
              </a>
            </div>
            <div>
              <button className="btn btn-danger">Delete</button>
            </div>
          </div>
          <img src={post?.photoUrl} alt="Image post" />
          <div className="col-12 d-flex align-items-center mt-3">
            <form action="" className="w-100 d-flex">
              {isLiked ? (
                <Button
                  title="Unlike"
                  className="btn btn-secondary w-25"
                  type="button"
                  handleClick={unlike}
                />
              ) : (
                <Button
                  title="Like"
                  className="btn btn-primary w-25"
                  type="button"
                  handleClick={like}
                />
              )}
              <p className="m-0 fs-5 ms-3">{likeCount}</p>
            </form>
          </div>
        </div>
      </div>
    </>
  );
}

export default Post;
