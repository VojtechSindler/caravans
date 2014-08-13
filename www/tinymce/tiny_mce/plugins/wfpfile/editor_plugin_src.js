

(function() {
    tinymce.PluginManager.requireLangPack('wfpfile');
	tinymce.create('tinymce.plugins.WfpfilePlugin', {
		init : function(ed, url) {
			
			// Register commands
			ed.addCommand('mceWfpfile', function() {
				ed.windowManager.open({
					file : url + '/wfpfile.php', 
					width : 550 + parseInt(ed.getLang('wfpfile.delta_width', 0)),
					height : 250 + parseInt(ed.getLang('wfpfile.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('wfpfile', {
				title : 'wfpfile.desc',
				cmd : 'mceWfpfile',
				image : url + '/images/wfpfile.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'WfPFile',
				author : 'BATIX & KENOD - Petr Danek',
				authorurl : 'http://kenod.net',
				infourl : 'http://webfrompixels.com/vyvoj',
				version : '1.2.0'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('wfpfile', tinymce.plugins.WfpfilePlugin);
})();

