document.addEventListener('DOMContentLoaded', function() {

  // Tombol Lihat
  document.querySelectorAll('.btn-lihat').forEach(btn => {
    btn.addEventListener('click', function() {
      const modal = document.getElementById('modalLihat');
      modal.querySelector('#lihatNama').textContent = this.dataset.nama;
      modal.querySelector('#lihatJumlah').textContent = this.dataset.jumlah;
      modal.querySelector('#lihatMeja').textContent = this.dataset.meja;
      modal.querySelector('#lihatTanggal').textContent = this.dataset.tanggal;
      modal.querySelector('#lihatJam').textContent = this.dataset.jam;
      modal.querySelector('#lihatCatatan').textContent = this.dataset.catatan || '-';

      modal.style.display = 'flex';
      const content = modal.children[0];
      requestAnimationFrame(()=> {
        content.style.transform = 'scale(1)';
        content.style.opacity = '1';
      });
    });
  });

  // Tutup Modal
  document.getElementById('tutupModal').addEventListener('click', function() {
    const modal = document.getElementById('modalLihat');
    const content = modal.children[0];
    content.style.transform = 'scale(0.8)';
    content.style.opacity = '0';
    setTimeout(()=>{ modal.style.display = 'none'; }, 300);
  });

  // Pesan sukses fade out
  const pesan = document.getElementById('pesanSukses');
  if(pesan){
    setTimeout(()=>{ pesan.style.opacity = '0'; }, 2500);
  }

  // Tombol Hapus dengan efek scale
  document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      if(confirm('Yakin ingin menghapus reservasi ini?')){
        const btn = this.querySelector('button');
        btn.style.transform = 'scale(0.95)';
        setTimeout(()=>{ this.submit(); }, 150);
      }
    });
  });

  // Tombol hover effect
  document.querySelectorAll('.btn-lihat, .btn-hapus').forEach(b => {
    b.addEventListener('mouseover', ()=> b.style.transform='scale(1.05)');
    b.addEventListener('mouseout', ()=> b.style.transform='scale(1)');
  });
});
