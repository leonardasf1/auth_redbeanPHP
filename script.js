
function q(id) { return document.querySelector(id); }
function qAll(id) { return document.querySelectorAll(id); }

function setRed(i) {
  i.style.borderBottom = '2px solid red';
}
function setGreen(i) {
  i.style.borderBottom = '2px solid #37b24d';
  q('.error').innerText = '';
}

qAll('.form__group input').forEach(function(i) {
  if (i.name != 'tel') {
    i.addEventListener('blur', function() {
      if (!i.value) {
        setRed(i);
      } else if (i.name == 'password_2') {
        if (i.value != q('#pas').value) {
          setRed(i);
        } else setGreen(i);
      } else setGreen(i);
    });
  }
});