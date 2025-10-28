function showMenu2(name, price, status) {
  document.getElementById('popupName2').innerText = name;
  document.getElementById('popupPrice2').innerText = Number(price).toLocaleString('id-ID');
  document.getElementById('popupStatus2').innerText = status || '-';
  document.getElementById('menuPopup2').style.display = 'flex';
}

function closeMenu2() {
  document.getElementById('menuPopup2').style.display = 'none';
}
