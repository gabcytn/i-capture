const likeForms = document.querySelectorAll(".like-form");
const unlikeForms = document.querySelectorAll(".unlike-form");
const likeButtons = document.querySelectorAll(".like-button");
const likeCounts = document.querySelectorAll(".like-count");

for (let i = 0; i < likeButtons.length; i++)
{
    likeButtons[i].addEventListener("click", async() => {
	const currentLikeButton = likeButtons[i];
	const currentLikeFormAction = likeForms[i].action;
	const currentUnlikeFormAction = unlikeForms[i].action;
	const currentLikeCount = likeCounts[i];
	console.log(currentLikeFormAction);
	if (likeButtons[i].textContent === "Like") 
		await like(currentLikeFormAction, currentLikeButton, currentLikeCount);
	else if (likeButtons[i].textContent === "Unlike")
		await unlike(currentUnlikeFormAction, currentLikeButton, currentLikeCount);
    });
}

async function like (url, likeButton, likeCount) {
    const res = await fetch(url, { method: "POST" });

    if (res.ok) {
	likeButton.classList.remove("btn-primary");
	likeButton.classList.add("btn-secondary");
	likeButton.textContent = "Unlike";
	likeCount.textContent = Number(likeCount.textContent) + 1;
    }
}

async function unlike (url, likeButton, likeCount) {
    const res = await fetch(url, { method: "POST" });

    if (res.ok) {
	likeButton.classList.remove("btn-secondary");
	likeButton.classList.add("btn-primary");
	likeButton.textContent = "Like";
	likeCount.textContent = Number(likeCount.textContent) - 1;
    }
}
