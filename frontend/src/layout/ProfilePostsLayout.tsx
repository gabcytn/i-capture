import { useEffect, useState } from "react";
import { useParams } from "react-router";

type PropTypes = {
  onUserNotFound: (b: boolean) => void;
};

function ProfilePostsLayout({ onUserNotFound }: PropTypes) {
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  const profileName = useParams().segment;
  const [posts, setPosts] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const res = await fetch(`${SERVER_URL}/post/${profileName}`, {
          method: "GET",
          credentials: "include",
        });

        switch (res.status) {
          case 404:
            onUserNotFound(true);
            break;

          case 200:
            setPosts(await res.json());
            break;

          default:
            throw new Error(`Status code: ${res.status}`);
        }
      } catch (e) {
        if (e instanceof Error) console.error(e.message);
      }
    };

    fetchData();
  }, [SERVER_URL, profileName, onUserNotFound]);

  if (posts.length === 0) {
    return <h3 className="text-center">No Posts Yet</h3>;
  }
  return (
    <div className="row">
      {posts.map((post) => {
        return (
          <div className="col-6">
            <img src={post.photoUrl} alt="Post image" />
            <p>Likes: {post.likes}</p>
          </div>
        );
      })}
    </div>
  );
}

export default ProfilePostsLayout;
