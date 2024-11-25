const likeCountField = document.querySelector("#like-count");
const unlikeButton = document.querySelector("#unlike-button");

const likeForm = document.querySelector("#like-form");
const unlikeForm = document.querySelector("#unlike-form");

let LIKE_COUNT = Number(likeCountField.textContent)

unlikeForm.addEventListener("submit", async (event) => {
	event.preventDefault();

	if (unlikeButton.textContent === "Like") await like();
	else if (unlikeButton.textContent === "Unlike") await unlike();
});

async function unlike () {
	const res = await fetch(unlikeForm.action, { method: "POST" });
	if (res.ok) {
		unlikeButton.classList.remove("btn-secondary");
		unlikeButton.classList.add("btn-primary");
		unlikeButton.textContent = "Like";
		LIKE_COUNT -= 1;
		likeCountField.textContent = `${LIKE_COUNT}`;
	}
}

async function like () {
	const res = await fetch(likeForm.action, { method: "POST" });
	if (res.ok) {
		unlikeButton.classList.remove("btn-primary");
		unlikeButton.classList.add("btn-secondary");
		unlikeButton.textContent = "Unlike";
		LIKE_COUNT += 1;
		likeCountField.textContent = `${LIKE_COUNT}`;
	}
}

