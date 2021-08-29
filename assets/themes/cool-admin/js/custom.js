// Send ajax form.
function ajax(data, url = "") {
	$.ajax({
		type: "POST",
		enctype: "multipart/form-data",
		url: url,
		data: data,
		processData: false,
		contentType: false,
		success: function (result) {
			let json = JSON.parse(result);

			switch (data.get("action")) {
				case "deletePost":
					$(".post-list").html(json.postlist);
					break;
				case "deleteComment":
				case "validateComment?getPendingComments()":
				case "validateComment?getAllComments()":
					$(".comment-list").html(json.comments);
					break;
				case "deleteImage":
					$(".uploadImage-container").html(json.inputFile);
					break;
				default:
					break;
			}

			$(".ajax-form__alert").html(json.alert);
			$(".ajax-form__alert").fadeIn();

			setTimeout(function () {
				$("html, body").animate({ scrollTop: $(".ajax-form__alert").offset().top - 67 }, 200);
				setTimeout(function () {
					$(".ajax-form__alert").fadeOut();
				}, 10000);
			}, 100);
		},
	});
}

// Forms.
$(".ajax-form").on("submit", function (e) {
	e.preventDefault();
	let data = new FormData($(this)[0]);
	ajax(data);
});

// Comment actions.
$("a[data-toggle=modal]").on("click", function (e) {
	e.preventDefault();

	let title;
	let content;
	let dataAction;
	let dataAttr;
	let href = $(this).attr("href");
	let commentID = $(this).closest(".comment").attr("data-id");
	let postID = $(this).closest(".post").attr("data-id");
	let modal = false;

	switch (href) {
		case "#delete-comment":
			title = "Supprimer un commentaire";
			content = "<p>Êtes-vous sûr(e) de vouloir supprimer ce commentaire ?</p>";
			dataAction = "delete-comment";
			dataAttr = { "comment-id": commentID };
			modal = true;
			break;

		case "#validate-comment?getAllComments()":
			title = "Valider le commentaire";
			content = "<p>Souhaitez-vous valider ce commentaire ?</p>";
			dataAction = "validate-comment?getAllComments()";
			dataAttr = { "comment-id": commentID };
			modal = true;
			break;

		case "#validate-comment?getPendingComments()":
			title = "Valider le commentaire";
			content = "<p>Souhaitez-vous valider ce commentaire ?</p>";
			dataAction = "validate-comment?getPendingComments()";
			dataAttr = { "comment-id": commentID };
			modal = true;
			break;

		case "#delete-post":
			title = "Supprimer un article";
			content = "<p>Êtes-vous sûr(e) de vouloir supprimer cet article ?</p>";
			dataAction = "delete-post";
			dataAttr = { "post-id": postID };
			modal = true;
			break;

		case "#delete-image":
			title = "Supprimer l'image";
			content = "<p>Êtes-vous sûr(e) de vouloir supprimer cette image ?</p>";
			dataAction = "delete-image";
			dataAttr = { "post-id": postID };
			modal = true;
			break;
	}

	// If action requires modal.
	if (modal) {
		$(".modal .modal-title").html(title);
		$(".modal .modal-body").html(content);
		$(".modal .btn-yes").attr("data-action", dataAction);
		$.each(dataAttr, function (index, value) {
			$(".modal .btn-yes").attr("data-" + index, value);
		});
	}
});

// Popup
$(document).on("click", ".modal .btn-yes", function () {
	let data = new FormData();
	let action = $(this).attr("data-action");
	let commentID = $(this).attr("data-comment-id");
	let postID = $(this).attr("data-post-id");
	switch (action) {
		case "delete-comment":
			data.append("action", "deleteComment");
			data.append("comment_id", commentID);
			break;
		case "validate-comment?getPendingComments()":
			data.append("action", "validateComment?getPendingComments()");
			data.append("comment_id", commentID);
			break;
		case "validate-comment?getAllComments()":
			data.append("action", "validateComment?getAllComments()");
			data.append("comment_id", commentID);
			break;
		case "delete-post":
			data.append("action", "deletePost");
			data.append("post_id", postID);
			break;
		case "delete-image":
			data.append("action", "deleteImage");
			data.append("post_id", postID);
			break;
	}

	ajax(data);
});
