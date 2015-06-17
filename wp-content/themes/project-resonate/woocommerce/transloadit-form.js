
console.log( jQuery( 'body' ).find( 'a' ).length );
console.log( 'nuts' );

var formData = new FormData();
formData.append( 'transloadit-data', 'http://resonate.lsp.goozmo.com/wp-content/uploads/product_addons_uploads/c4ca4238a0b923820dcc509a6f75849b/smb_stage_clear49.wav' );

/*
jQuery(function(){
	jQuery('#transloadit-form').transloadit({
		wait : true,
		triggerUploadOnFileSelection : false,
		params : {
			auth : {
				key: "b15a103003e211e5a7cb1199b0923661"
			},
			steps : {
				import : {
					robot : "/http/import",
					url : "http://resonate.lsp.goozmo.com/wp-content/uploads/product_addons_uploads/c4ca4238a0b923820dcc509a6f75849b/smb_stage_clear49.wav"
				},
				waveform : {
					robot : "/audio/waveform",
					use : "import",
					width : 500,
					height : 200,
					background_color : "000000",
					outer_color : "cccccc",
					center_color : "ffffff"
				}
			},
			notify_url : window.location.href
		},
	});
});
*/

/*
var request = new XMLHttpRequest();
request.open( 'POST', 'http://api2.transloadit.com/assemblies' );
request.send( formData );
*/

