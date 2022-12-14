<div class="form-group">
    <label for="">Kondisi Pelaksana Pekerjaan</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->kondisi_pelaksana_pekerjaan : '' }}">
</div>
<div class="form-group">
    <label for="">Penggunaan APD</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->penggunaan_apd : '' }}">
</div>
<div class="form-group">
    <label for="">Penggunaan Perlengkapan Kerja</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->penggunaan_perlengkapan_kerja : '' }}">
</div>
<div class="form-group">
    <label for="">Pemasangan Rambu K3</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->pemasangan_rambu_k3 : '' }}">
</div>
<div class="form-group">
    <label for="">Pemasangan LOTO</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->pemasangan_loto : '' }}">
</div>
<div class="form-group">
    <label for="">Pemasangan Pembumian</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->pemasangan_pembumian : '' }}">
</div>
<div class="form-group">
    <label for="">Pembebasan/Pemeriksaan Tegangan</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->pembebasasn_pemeriksaan_tegangan : '' }}">
</div>
<div class="form-group">
    <label for="">Pelaksanaan Briefing K3 di Lokasi</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->pelaksanaan_breafing : '' }}">
</div>
<div class="form-group">
    <label for="">JSA</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->jsa : '' }}">
</div>
<div class="form-group">
    <label for="">SOP</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->sop : '' }}">
</div>
<div class="form-group">
    <label for="">WP</label>
    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->inspeksi != null ?$wp->inspeksi->wp : '' }}">
</div>