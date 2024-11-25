const likeCountField = document.querySelector("#like-count");
const likeButton = document.querySelector("#like-button");

const likeForm = document.querySelector("#like-form");
const unlikeForm = document.querySelector("#unlike-form");

let LIKE_COUNT = Number(likeCountField.textContent)


likeForm.addEventListener("submit", async (event) => {
	event.preventDefault();

	if (likeButton.textContent === "Like") await like();
	else if (likeButton.textContent === "Unlike") await unlike();
});

async function like () {
	const res = await fetch(likeForm.action, { method: "POST" });
	if (res.ok) {
		likeButton.classList.remove("btn-primary");
		likeButton.classList.add("btn-secondary");
		likeButton.textContent = "Unlike";
		LIKE_COUNT += 1;
		likeCountField.textContent = `${LIKE_COUNT}`;
	}
}

async function unlike () {
	const res = await fetch(unlikeForm.action, { method: "POST" });
	if (res.ok) {
		likeButton.classList.remove("btn-secondary");
		likeButton.classList.add("btn-primary");
		likeButton.textContent = "Like";
		LIKE_COUNT -= 1;
		likeCountField.textContent = `${LIKE_COUNT}`;
	}
}

