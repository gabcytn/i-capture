const likeForms = document.querySelectorAll(".like-form");
const unlikeForms = document.querySelectorAll(".unlike-form");
const likeButtons = document.querySelectorAll(".like-button");
const likeCounts = document.querySelectorAll(".like-count");

for (let i = 0; i < likeButtons.length; i++) {
  likeButtons[i].addEventListener("click", async () => {
    const currentLikeButton = likeButtons[i];
    const currentLikeFormAction = likeForms[i].action;
    const currentUnlikeFormAction = unlikeForms[i].action;
    const currentLikeCount = likeCounts[i];
    console.log(currentLikeFormAction);
    if (likeButtons[i].textContent === "Like")
      await like(currentLikeFormAction, currentLikeButton, currentLikeCount);
    else if (likeButtons[i].textContent === "Unlike")
      await unlike(
        currentUnlikeFormAction,
        currentLikeButton,
        currentLikeCount,
      );
  });
}

async function like(url, likeButton, likeCount) {
  const res = await fetch(url, { method: "POST" });

  if (res.ok) {
    likeButton.classList.remove("btn-primary");
    likeButton.classList.add("btn-secondary");
    likeButton.textContent = "Unlike";
    likeCount.textContent = Number(likeCount.textContent) + 1;
  }
}

async function unlike(url, likeButton, likeCount) {
  const res = await fetch(url, { method: "POST" });

  if (res.ok) {
    likeButton.classList.remove("btn-secondary");
    likeButton.classList.add("btn-primary");
    likeButton.textContent = "Like";
    likeCount.textContent = Number(likeCount.textContent) - 1;
  }
}

// LOAD MORE CONTENT

const loadMoreButton = document.querySelector("#load-more-button");
const loadMoreForm = document.querySelector("#load-more-form");

loadMoreButton.addEventListener("click", async () => {
  try {
    const res = await fetch(loadMoreForm.action);
    const data = await res.json();

    displayMorePosts(data.posts);
  } catch (error) {
    console.error(error);
  }
});

// DOM Manipulation to display more posts fetched

function displayMorePosts(posts) {
  const previousPosts = document.querySelectorAll(".post");
  const lastPost = previousPosts[previousPosts.length - 1];

  posts.forEach((post) => {
    // div that holds all contents of a SINGLE post
    const newPost = document.createElement("div");
    newPost.classList.add("col-12");

    // div that holds the profile pic and username
    const headerDiv = document.createElement("div");
    headerDiv.classList.add("d-flex", "my-3", "align-items-center");
    const profilePic = document.createElement("img");
    profilePic.src = post.profile_pic;
    profilePic.alt = "Post owner's profile pic";
    const postOwner = document.createElement("a");
    postOwner.textContent = `@${post.post_owner}`;
    postOwner.classList.add("ms-3", "fw-600");
    headerDiv.append(profilePic, postOwner);

    // img for the actual post
    const actualPostImage = document.createElement("img");
    actualPostImage.src = post.photo_url;
    actualPostImage.alt = "Post Image";

    // div that holds the like button section
    const likeDiv = document.createElement("div");
    likeDiv.classList.add(
      "mt-3",
      "d-flex",
      "align-items-center",
      "justify-content-start",
    );
    const newPostLikeButton = document.createElement("button");
    newPostLikeButton.classList.add(
      "btn",
      "btn-primary",
      "w-25",
      "new-like-button",
    );
    const newPostLikeCount = document.createElement("p");
    newPostLikeCount.textContent = post.likes;
    newPostLikeCount.classList.add("fs-5", "m-0", "ms-3", "new-like-count");
    likeDiv.append(newPostLikeButton, newPostLikeCount);

    // append every sub div to the main div
    newPost.append(headerDiv, actualPostImage, likeDiv);
    // lastPost.insertAdjacentElement("afterend", newPost);
  });
}
