let loginModal = document.querySelector('.login');
let loginModalContainer = document.querySelector('.login-modal');
let closeModal = document.getElementById('close-modal');

let signUpModal = document.querySelector('.signup');
let signUpModalContainer = document.querySelector('.signup-modal');

let signUpSpan = document.querySelector('.signup-span')

loginModal.onclick = function(){
  loginModalContainer.style.display = 'flex';
}

closeModal.onclick = function(){
  loginModalContainer.style.display = 'none';
  signUpModalContainer.style.display = 'none';
}

signUpModal.onclick = function(){
  signUpModalContainer.style.display = 'flex';
}

