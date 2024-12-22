type Post = {
  postId: number;
  photoUrl: string;
  profilePic: string;
  postOwner: string;
};
async function fetchPosts(
  cursor: number,
  feedType: string,
  setLikeButtons: (map: Map<number, boolean>) => void,
) {
  console.log("fetching posts: " + feedType);
  const SERVER_URL = import.meta.env.VITE_SERVER_URL;
  const res = await fetch(`${SERVER_URL}/posts/${feedType}?cursor=${cursor}`, {
    method: "GET",
    credentials: "include",
  });
  if (res.status === 403) {
    alert("Session has expired... Logging you out");
    sessionStorage.clear();
    location.reload();
  }
  const data = await res.json();
  const map = new Map<number, boolean>();
  data.map((post: Post) => {
    map.set(post.postId, feedType === "liked");
  });
  setLikeButtons(map);
  return data;
}

export default fetchPosts;
