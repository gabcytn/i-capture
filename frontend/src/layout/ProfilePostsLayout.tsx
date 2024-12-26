import { useEffect, useState } from "react";
import { useParams } from "react-router";

type Post = {
  id: number;
  postOwner: string;
  photoUrl: string;
  photoPublicId: string;
};

type PropType = {
  setPostsCount: (e: number) => void;
};

function ProfilePostsLayout({ setPostsCount }: PropType) {
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  const profileName = useParams().segment;
  const [posts, setPosts] = useState<Post[]>([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const res = await fetch(`${SERVER_URL}/posts/${profileName}`, {
          method: "GET",
          credentials: "include",
        });

        if (res.status !== 200) {
          setPosts([]);
          throw new Error(`Status code of ${res.status}`);
        }

        const data = await res.json();
        setPosts(data);
        setPostsCount(data.length);
      } catch (e) {
        if (e instanceof Error) console.error(e.message);
      }
    };

    fetchData();
  }, [SERVER_URL, profileName, setPostsCount]);

  if (posts.length === 0) {
    return <h3 className="text-center">No Posts Yet</h3>;
  }
  return (
    <div className="row g-3">
      {posts.map((post) => {
        return (
          <div className="col-6" key={post.id}>
            <a
              href={`/post/${post.id}`}
              style={{ textDecoration: "none", color: "#020202" }}
            >
              <img
                style={{ height: "300px", width: "100%", borderRadius: "5px" }}
                src={post.photoUrl}
                alt="Post image"
              />
            </a>
          </div>
        );
      })}
    </div>
  );
}

export default ProfilePostsLayout;
