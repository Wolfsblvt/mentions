/**
 * 
 * '@Mention System
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

// Autocomplete feature
$(document).ready(function () {
	// If autocomplete is deactivated, we don't want to do anything here
	if (!$.wolfsblvt.mentions_json_data.autocomplete_enabled) {
		return;
	}

	var $message = $("#message");

	// For subsilver2 and any other style that has no "message" id, but "message" name attribute
	if (!$message.length) {
		$message = $('textarea[name="message"]').first();
	}

	var default_options = {
		data: $.wolfsblvt.mentions_json_data.ajax_path,
		searchKey: $.wolfsblvt.mentions_json_data.searchKey,
		limit: 5,
		displayTpl: '<li><div class="mentions-avatar">${avatar}</div> ${username_no_profile}</li>',

		maxLen: $.wolfsblvt.mentions_json_data.max_length,
		startWithSpace: true,
		displayTimeout: 300,
		highlightFirst: true,
		delay: null,
		suffix: '',
		hideWithoutSuffix: true,
	};

	// Unset data if we want to load it remove, and not at start
	// Then add the remote filter
	if ($.wolfsblvt.mentions_json_data.autocomplete_remote_load) {
		default_options.data = undefined;
		default_options.remoteFilter = $.wolfsblvt.callback_remoteFilter;
	}

	// Add the mention listeners
	if ($.wolfsblvt.mentions_json_data.active_at) {
		$message.atwho($.extend({}, default_options, {
			at: "@",
			alias: "at",
			insertTpl: '${atwho-at}${name}',

			callbacks: {
				matcher: $.wolfsblvt.callback_matcher_at,
				highlighter: $.wolfsblvt.callback_highlighter,
				beforeSave: $.wolfsblvt.callback_beforeSave,
				sorter: $.wolfsblvt.callback_sorter,
				tplEval: $.wolfsblvt.callback_tplEval,
			},
		}));
	}
	if ($.wolfsblvt.mentions_json_data.active_bbcode) {
		$message.atwho($.extend({}, default_options, {
			at: "[mention]",
			closingTag: "[/mention]",
			alias: "mention-bbcode",
			insertTpl: '${atwho-at}${name}',

			callbacks: {
				matcher: $.wolfsblvt.callback_matcher_mention,
				highlighter: $.wolfsblvt.callback_highlighter,
				beforeSave: $.wolfsblvt.callback_beforeSave,
				sorter: $.wolfsblvt.callback_sorter,
				tplEval: $.wolfsblvt.callback_tplEval,
			},
		}));
	}
	if ($.wolfsblvt.mentions_json_data.active_bbcode_text) {
		$message.atwho($.extend({}, default_options, {
			at: "[mention=",
			prependingCode: "\"",
			closingTag: "\"][/mention]",
			closingTagTextInside: true,
			alias: "mention-equals-bbcode",
			insertTpl: 'mention="${name}', // dunno why the hell I can't use ${atwho-at} here, but it inserts two "[" at front. So let's come around with this

			callbacks: {
				matcher: $.wolfsblvt.callback_matcher_mention,
				highlighter: $.wolfsblvt.callback_highlighter,
				beforeSave: $.wolfsblvt.callback_beforeSave,
				sorter: $.wolfsblvt.callback_sorter,
				tplEval: $.wolfsblvt.callback_tplEval,
			}
		}));
	}

	if ($.wolfsblvt.mentions_json_data.autocomplete_autoclose_bbcode) {
		// Change caret to behind the bbcode for mention tags
		$message.on("inserted-mention-bbcode.atwho", function (event, $li) {
			console.log(event, "inserted ", $li, "context is", this);
			$.wolfsblvt.move_behind_tag($message);
		});
		$message.on("inserted-mention-equals-bbcode.atwho", function (event, $li) {
			console.log(event, "inserted ", $li, "context is", this);
			$.wolfsblvt.move_behind_tag($message, true);
		});
	}

	// Open autocomplete if bbcode is inserted
	$("input.bbcode-mention, input.bbcode-mention-text").on("click", function () {
		console.log("okay, click function");
		$message.atwho("run");
	});
});