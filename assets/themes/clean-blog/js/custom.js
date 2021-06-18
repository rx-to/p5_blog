// Send ajax form.
function ajax(data) {
	$.ajax({
		type: "POST",
		enctype: "multipart/form-data",
		url: "",
		data: data,
		processData: false,
		contentType: false,
		success: function (result) {
			let json = JSON.parse(result);

			switch (data.get("action")) {
				case "deleteComment":
					$(".comment-list").html(json.comments);
					break;
				default:
					break;
			}

			$(".ajax-form__alert").html(json.alert);
			$(".ajax-form__alert").fadeIn();
			setTimeout(function () {
				$(".ajax-form__alert").fadeOut();
			}, 5000);
		},
	});
}

// Forms.
$(".ajax-form").on("submit", function (e) {
	e.preventDefault();
	let data = new FormData($(this)[0]);
	ajax(data);
});

// Post comments.
$(".comment__nav-trigger").on("click", function (e) {
	let target = $("#" + $(this).closest(".comment").attr("id") + " .actions__list");
	target.toggleClass("displayed");
	e.stopPropagation();
});

$(document).on("click", function (e) {
	if ($(e.target).parent(".actions__list").length == 0) $(".actions__list ").removeClass("displayed");
});

$("a[href='#edit-comment']").on("click", function () {
	$("input[name=comment_id]");
	$("#comment").html($("#comment__content-" + $(this).closest(".comment").attr("data-id")).html());
	$("html, body").animate({ scrollTop: $("#comment").offset().top - 67 }, 200);
});

$(".comment .actions a").on("click", function (e) {
	e.preventDefault();

	let title;
	let content;
	let dataAction;
	let dataAttr;
	let href = $(this).attr("href");
	let commentID = $(this).closest(".comment").attr("data-id");
	let postID = $("input[name=post_id]").val();

	switch (href) {
		case "#delete-comment":
			title = "Supprimer un commentaire";
			content = "Êtes-vous sûr(e) de vouloir supprimer ce commentaire ?";
			dataAction = "delete-comment";
			dataAttr = { "post-id": postID, "comment-id": commentID };
			break;

		case "#report-comment":
			title = "Signaler un commentaire";
			content = "Pour quelle(s) raison(s) souhaitez-vous signaler ce commentaire ?";
			dataAction = "report-comment";
			dataAttr = { "comment-id": commentID };
			break;
	}

	$(".modal .modal-title").html(title);
	$(".modal .modal-body").html(content);
	$(".modal .btn-yes").attr("data-action", dataAction);
	$.each(dataAttr, function (index, value) {
		$(".modal .btn-yes").attr("data-" + index, value);
	});
});

$(".modal .btn-yes").on("click", function () {
	let data = new FormData();
	let action = $(this).attr("data-action");
	let commentID = $(this).attr("data-comment-id");
	let postID = $(this).attr("data-post-id");
	switch (action) {
		case "delete-comment":
			data.append("action", "deleteComment");
			data.append("comment_id", commentID);
			data.append("post_id", postID);
			break;

		case "report-comment":
			data.append("action", "reportComment");
			data.append("comment_id", commentID);
			break;
	}

	ajax(data);
});