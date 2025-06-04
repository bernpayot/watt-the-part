let openLoginModal = document.getElementById('open-modal');
let modal = document.querySelector('.modal-container');
let closeModal = document.getElementById('close-modal');
let signupModal = document.getElementById('sign-up');

openLoginModal.onclick = function(){
  modal.style.display = 'flex';
}

closeModal.onclick = function(){
  modal.style.display = 'none';
}

signupModal.onclick = function(){
  modal.style.display = 'flex';
}