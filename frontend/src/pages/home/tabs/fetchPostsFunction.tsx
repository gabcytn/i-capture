async function fetchPosts(cursor: number, feedType: string) {
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
  return data;
}

export default fetchPosts;
