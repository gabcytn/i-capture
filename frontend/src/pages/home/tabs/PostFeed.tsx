import Loading from "../../loading/Loading";
import styles from "./PostFeed.module.css";
import Button from "../../../components/Button";
import fetchPosts from "./fetchPostsFunction";
import { useQuery } from "@tanstack/react-query";

type Post = {
  postId: number;
  photoUrl: string;
  profilePic: string;
  postOwner: string;
};

type TabProps = {
  feedType: string;
};

function Tab({ feedType }: TabProps) {
  const query = useQuery({
    queryKey: ["posts", feedType],
    queryFn: () => {
      return fetchPosts(0, feedType);
    },
    select: (data) => {
      if (feedType === "liked")
        return [...data].sort((a, b) => b.postId - a.postId);
      return [...data].sort((a, b) => a.postId - b.postId);
    },
  });
  if (query.isLoading) return <Loading />;
  if (query.isError || !query.data) return <h2 className="error">error</h2>;
  return (
    <div className="container mb-4">
      <div className="row">
        {query.data.map((post: Post) => {
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

export default Tab;
