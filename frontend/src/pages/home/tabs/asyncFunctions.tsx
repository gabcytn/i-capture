type Post = {
  postId: number;
  photoUrl: string;
  profilePic: string;
  postOwner: string;
};
export async function fetchPosts(
  cursor: number,
  feedType: string,
  likeButtons: Map<number, boolean>,
  setLikeButtons: (map: Map<number, boolean>) => void,
) {
  const SERVER_URL = getServerUrl();
  const res = await fetch(`${SERVER_URL}/posts/${feedType}?cursor=${cursor}`, {
    method: "GET",
    credentials: "include",
  });
  if (res.status === 403) sessionExpired();

  if (!res.ok) throw new Error(`Error status code of ${res.status}`);

  const data = await res.json();
  const map = new Map<number, boolean>(likeButtons);
  data.posts.map((post: Post) => {
    map.set(post.postId, feedType === "liked");
  });
  setLikeButtons(map);
  return data;
}

export async function likeUnlike(method: string, postId: number) {
  const SERVER_URL = getServerUrl();
  const res = await fetch(`${SERVER_URL}/post/${method}/${postId}`, {
    method: "POST",
    credentials: "include",
  });
  if (res.status === 403) sessionExpired();
}

function sessionExpired() {
  alert("Session has expired... Logging you out");
  sessionStorage.clear();
  location.reload();
}

function getServerUrl() {
  return import.meta.env.VITE_SERVER_URL;
}
