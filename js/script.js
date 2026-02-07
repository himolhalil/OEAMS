function addClassTo(className, element) {
	element.classList.add(className);
}

function removeClassFrom(className, element) {
	element.classList.remove(className);
}

let editableElements = Array.from(
	document.getElementsByClassName("editable-ajax-input"),
);

editableElements.forEach(element => {
	element.ondblclick = e => {
		element.contentEditable = true;
		element.onblur = () => {
			let row = element.parentElement.dataset.id;
			let column = element.dataset.column;
			let newValue = element.innerText;
			editMarkRow({ row, column, new_value: newValue })
		};
	};
});

function editMarkRow(body){
	fetch("http://localhost/php/OEAMS/registrations/edit_registration_marks.php", {
			method: "POST",
			body: JSON.stringify(body),
		},
	)
	.then(response => {
		return response.json();
	})
	.then(message => {
		let toast = document.createElement("div");
		toast.innerText = message.message;
		toast.classList.add("toast-message");
		let timeToWaitForToast = 1000;
		if (!(message.code >= 200 && message.code <= 300)) {
			toast.classList.add("toast-message-error");
			timeToWaitForToast = 3000;
		}

		document.body.append(toast);
		toast.classList.add("shown-toast-message");
		setTimeout(() => {
			toast.remove();
		}, timeToWaitForToast);
	});
}


let editableElementsFees = Array.from(
	document.getElementsByClassName("editable-ajax-input-fees"),
);

editableElementsFees.forEach(element => {
	element.ondblclick = e => {
		element.contentEditable = true;
		element.onblur = () => {
			let row = element.parentElement.dataset.id;
			let column = element.dataset.column;
			let newValue = element.innerText;
			editFeesRow({ row, column, new_value: newValue })
		};
	};
});

function editFeesRow(body){
	fetch("http://localhost/php/OEAMS/registrations/edit_registration_fees.php", {
			method: "POST",
			body: JSON.stringify(body),
		},
	)
	.then(response => {
		return response.json();
	})
	.then(message => {
		let toast = document.createElement("div");
		toast.innerText = message.message;
		toast.classList.add("toast-message");
		let timeToWaitForToast = 1000;
		if (!(message.code >= 200 && message.code <= 300)) {
			toast.classList.add("toast-message-error");
			timeToWaitForToast = 3000;
		}

		document.body.append(toast);
		toast.classList.add("shown-toast-message");
		setTimeout(() => {
			toast.remove();
		}, timeToWaitForToast);
	});
}