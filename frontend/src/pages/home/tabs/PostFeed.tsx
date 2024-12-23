import Loading from "../../loading/Loading";
import styles from "./PostFeed.module.css";
import Button from "../../../components/Button";
import { fetchPosts, likeUnlike } from "./asyncFunctions";
import { useInfiniteQuery } from "@tanstack/react-query";
import React from "react";

type Post = {
  postId: number;
  photoUrl: string;
  profilePic: string;
  postOwner: string;
};

type APIResponse = {
  posts: Post[];
  nextCursor: number;
};

type TabProps = {
  feedType: string;
  likeButtons: Map<number, boolean>;
  setLikeButtons: (map: Map<number, boolean>) => void;
};

function Tab({ feedType, likeButtons, setLikeButtons }: TabProps) {
  const {
    data,
    error,
    fetchNextPage,
    hasNextPage,
    isFetchingNextPage,
    status,
  } = useInfiniteQuery({
    queryKey: ["posts", feedType],
    queryFn: ({ pageParam }) => {
      return fetchPosts(pageParam, feedType, likeButtons, setLikeButtons);
    },
    initialPageParam: 0,
    getNextPageParam: (lastPage: APIResponse) => {
      if (lastPage.posts.length < 10) return null;
      return lastPage.nextCursor;
    },
    staleTime: Infinity,
  });
  if (status === "pending") return <Loading />;
  else if (status === "error")
    return <h2 className="error">Error: {error.message}</h2>;
  return (
    <div className="container mb-4">
      <div className="row">
        {data.pages.map((group, i) => (
          <React.Fragment key={i}>
            {group.posts.length !== 0 ? (
              group.posts.map((post) => {
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
                      <Button
                        className={`w-25 btn ${likeButtons.get(post.postId) ? "btn-secondary" : "btn-primary"}`}
                        title={likeButtons.get(post.postId) ? "Unlike" : "Like"}
                        type="button"
                        handleClick={() => {
                          const map = new Map(likeButtons);
                          const oldValue = map.get(post.postId);
                          const method = map.get(post.postId)
                            ? "unlike"
                            : "like";
                          map.set(post.postId, !oldValue);
                          setLikeButtons(map);
                          likeUnlike(method, post.postId);
                        }}
                      />
                    </div>
                  </div>
                );
              })
            ) : (
              <h2 className="text-center">No posts to show</h2>
            )}
          </React.Fragment>
        ))}
        {hasNextPage && (
          <div className="col-12">
            <button
              className="btn btn-warning w-100 mt-4 py-2"
              onClick={() => {
                fetchNextPage();
              }}
              disabled={!hasNextPage || isFetchingNextPage}
            >
              Load more
            </button>
          </div>
        )}
      </div>
    </div>
  );
}

export default Tab;
