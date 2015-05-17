function pc_notification(message) {
	$.notify.defaults({ className: "success" });
	//$.notify(message, { globalPosition:"top center" });
	$.notify(message, { globalPosition:"top right" });
}
