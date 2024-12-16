
	function detail_callback(id){
		$.get(base_url+'manajemen_aset/mitra/detail/'+id,function(result){
		cInfo.open(lang.detil,result);
		});
	}
