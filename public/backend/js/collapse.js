const collapse = document.querySelector('.collapse_catelogue');
	const right = document.querySelector(".fa-caret-right");

	const collapse_show = document.querySelector('.collapse-show');
	collapse_show.style.width = `${collapse.offsetWidth}px`;

	collapse.addEventListener('click', () => {
		const height = collapse_show.querySelector(".catelogue").offsetHeight;
		console.log(height);
		// collapse_show.classList.toggle('active');
		if (collapse_show.classList.toggle('active')) {
			collapse_show.style.height = `${height + 10}px`;
		}
		else {
			collapse_show.style.height = `0px`;
		}


		right.classList.toggle('active');
	})