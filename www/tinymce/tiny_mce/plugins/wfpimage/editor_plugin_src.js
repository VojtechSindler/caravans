


(function() {
    tinymce.PluginManager.requireLangPack('wfpimage');
	tinymce.create('tinymce.plugins.WfpimagePlugin', {
		init : function(ed, url) {
			
			// Register commands
			ed.addCommand('mceWfpimage', function() {
				ed.windowManager.open({
					file : url + '/wfpimage.php', 
					width : 600 + parseInt(ed.getLang('wfpimage.delta_width', 0)),
					height : 410 + parseInt(ed.getLang('wfpimage.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('wfpimage', {
				title : 'wfpimage.desc',
				cmd : 'mceWfpimage',
				image : url + '/images/wfpimage.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'WfPImage',
				author : 'KENOD - Petr Danek',
				authorurl : 'http://kenod.net',
				infourl : 'http://webfrompixels.com/vyvoj',
				version : '1.2.0'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('wfpimage', tinymce.plugins.WfpimagePlugin);
})();

