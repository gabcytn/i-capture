import { useEffect } from "react";
import Loading from "../../loading/Loading";
import styles from "./PostFeed.module.css";
import Button from "../../../components/Button";

type Post = {
  postId: number;
  photoUrl: string;
  profilePic: string;
  postOwner: string;
};

type ForYouProps = {
  postProp: Post[] | null;
  setPostProp: (posts: Post[]) => void;
  feedType: string;
};

function ForYou({ postProp, setPostProp, feedType }: ForYouProps) {
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  const fetchPosts = async (cursor: number) => {
    try {
      const res = await fetch(
        `${SERVER_URL}/posts/${feedType}?cursor=${cursor}`,
        {
          method: "GET",
          credentials: "include",
        },
      );
      switch (res.status) {
        case 403:
          alert("Session has expired...Logging you out");
          sessionStorage.clear();
          location.reload();
          break;
        case 200: {
          const data = await res.json();
          setPostProp(data);
          break;
        }
        default:
          throw new Error(`Error status code of ${res.status}`);
      }
    } catch (e: unknown) {
      if (e instanceof Error) {
        console.error("Error fetching posts");
        console.error(e.message);
      }
    }
  };
  useEffect(() => {
    if (postProp === null) fetchPosts(0);
    else if (postProp.length === 0) fetchPosts(0);
  }, []);
  if (!postProp) return <Loading />;
  return (
    <div className="container mb-4">
      <div className="row">
        {postProp.map((post) => {
          return (
            <div className="col-12" key={post.postId}>
              <div className="d-flex my-3 align-items-center">
                <img
                  src={post.profilePic}
                  className={styles.postOwnerProfile}
                />
                <a
                  href={`${location.origin}/${post.postOwner}`}
                  className="ms-3 text-decoration-none text-dark"
                >
                  @<strong>{post.postOwner}</strong>
                </a>
              </div>
              <img
                src={post.photoUrl}
                alt=""
                role="button"
                onClick={() => {
                  location.href = `${location.origin}/post/${post.postId}`;
                }}
              />

              <div className="mt-3 d-flex align-items-center justify-content-start">
                {feedType === "liked" ? (
                  <Button
                    className="btn btn-secondary w-25"
                    title="Unlike"
                    type="button"
                  />
                ) : (
                  <Button
                    className="btn btn-primary w-25"
                    title="Like"
                    type="button"
                  />
                )}
              </div>
            </div>
          );
        })}
        <div className="col-12">
          <Button
            className="btn btn-warning w-100 mt-4 py-2"
            title="Load more"
            type="button"
          />
        </div>
      </div>
    </div>
  );
}

export default ForYou;
