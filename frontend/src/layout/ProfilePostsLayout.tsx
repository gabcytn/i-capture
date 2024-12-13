import { useEffect, useState } from "react";

function ProfilePostsLayout() {
  const [posts, setPosts] = useState([]);
  useEffect(() => {
    const SERVER_URL = import.meta.env.SERVER_URL;
    // TODO: const data = fetch(SERVER_URL);
    // TODO: setPosts(data);
    console.log("fetch posts here");
  }, [posts]);
  if (posts.length === 0) {
    return <h3 className="text-center">No Posts Yet</h3>;
  }
  return (
    <div className="row">
      <div className="col-6">
        <a href="#">
          <img src="" alt="" />
          <p>Likes: 8</p>
        </a>
      </div>
    </div>
  );
}

export default ProfilePostsLayout;
