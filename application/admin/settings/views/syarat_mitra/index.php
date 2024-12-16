<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<div class="main-container">
		<?php
		form_open(base_url('inisiasi/pengaturan_umum/save'),'post','form','data-submit="ajax" data-callback="reload"');
			card_open(lang('syarat_kemitraan'),'mb-2');
				col_init(3,9);
				label(lang('minimal_rekanan_memasukan_penawaran'));
				input('text',lang('pengadaan_lelang'),'min_memasukan_lelang','required|number',setting('min_memasukan_lelang'));
				input('text',lang('pengadaan_pemilihan_langsung'),'min_memasukan_pemilihan_langsung','required|number',setting('min_memasukan_pemilihan_langsung'));
				input('text',lang('pengadaan_penunjukan_langsung'),'min_memasukan_penunjukan_langsung','required|number',setting('min_memasukan_penunjukan_langsung'));
				label(lang('minimal_rekanan_lolos_penawaran'));
				input('text',lang('pengadaan_lelang'),'min_pengadaan_lelang','required|number',setting('min_pengadaan_lelang'));
				input('text',lang('pengadaan_pemilihan_langsung'),'min_pengadaan_pemilihan_langsung','required|number',setting('min_pengadaan_pemilihan_langsung'));
				input('text',lang('pengadaan_penunjukan_langsung'),'min_pengadaan_penunjukan_langsung','required|number',setting('min_pengadaan_penunjukan_langsung'));
			card_close();

				form_button(lang('simpan'),false);
		form_close();
		?>
	</div>
</div>
