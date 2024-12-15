import { useEffect } from "react";
import { useParams } from "react-router";

function Post() {
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  const postId = useParams().segment;
  useEffect(() => {
    const fetchData = async () => {
      const res = await fetch(`${SERVER_URL}/post/${postId}`);
    };
    //TODO: fetch individual post
  }, [SERVER_URL, postId]);
  return (
    <div className="container">
      <div className="row">
        <div className="col-12">
          <h3>Individual post here</h3>
        </div>
      </div>
    </div>
  );
}

export default Post;
