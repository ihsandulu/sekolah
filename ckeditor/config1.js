/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript';
	config.smiley_images = [
		'smiley1.gif', 'smiley2.gif', 'smiley3.gif', 'smiley4.gif', 'smiley5.gif', 'smiley6.gif', 'smiley7.gif', 'smiley8.gif', 'smiley9.gif', 'smiley10.gif', 'smiley11.gif', 'smiley12.gif', 'smiley13.gif', 'smiley14.gif', 'smiley15.gif', 'smiley16.gif', 'smiley17.gif', 'smiley18.gif', 'smiley19.gif', 'smiley20.gif', 'smiley21.gif', 'smiley22.gif', 'smiley23.gif', 'smiley24.gif', 'smiley25.gif', 'smiley26.gif', 'smiley27.gif', 'smiley28.gif', 'smiley29.gif', 'smiley30.gif', 'smiley31.gif', 'smiley32.gif', 'smiley33.gif', 'smiley34.gif', 'smiley35.gif', 'smiley36.gif', 'smiley37.gif', 'smiley38.gif', 'smiley39.gif', 'smiley40.gif'
        ];
	config.smiley_path = 'smiley/';
	config.extraPlugins = 'smiley';
	//config.extraPlugins = 'image';
	//config.extraPlugins = 'fileman';
	//config.uploadUrl = '/fileman/upload.php';
	//config.extraPlugins = 'filebrowser';
	//config.extraPlugins = 'uploadimage';
};
