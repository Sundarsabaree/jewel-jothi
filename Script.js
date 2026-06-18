/* ============================================================
   Jewel Jothi Tech — Frontend JS
   Handles: panel switching, validation, API calls
   ============================================================ */

'use strict';

/* ── Utility: get element ── */
function el(id) { return document.getElementById(id); }

/* ── Toggle password visibility ── */
function togglePw(inputId, eyeId) {
  var input = el(inputId);
  var eye   = el(eyeId);
  if (input.type === 'password') {
    input.type      = 'text';
    eye.innerHTML   = '&#128584;'; // eye-slash
  } else {
    input.type      = 'password';
    eye.innerHTML   = '&#128065;'; // eye
  }
}

/* ── Switch between login and register panels ── */
function switchTo(panel) {
  clearAll();
  if (panel === 'register') {
    el('loginPanel').classList.add('hidden');
    el('registerPanel').classList.remove('hidden');
  } else {
    el('registerPanel').classList.add('hidden');
    el('loginPanel').classList.remove('hidden');
  }
}

/* ── Clear all messages & errors ── */
function clearAll() {
  ['loginError','loginSuccess','regError','regSuccess'].forEach(function(id) {
    el(id).style.display = 'none';
    el(id).textContent   = '';
  });
  ['loginEmailErr','loginPasswordErr',
   'regFirstErr','regLastErr','regEmailErr','regPasswordErr','regConfirmErr'
  ].forEach(function(id) {
    el(id).textContent = '';
  });
}

/* ── Show alert banner ── */
function showAlert(id, msg) {
  var div = el(id);
  div.textContent  = msg;
  div.style.display = 'block';
  div.classList.remove('shake');
  void div.offsetWidth;
  div.classList.add('shake');
}

/* ── Set field error ── */
function fieldErr(id, msg) {
  el(id).textContent = msg;
}

/* ── Email regex ── */
var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

/* ============================================================
   LOGIN SUBMIT
   ============================================================ */
function submitLogin() {
  clearAll();

  var email    = el('loginEmail').value.trim();
  var password = el('loginPassword').value;
  var valid    = true;

  if (!email) {
    fieldErr('loginEmailErr', 'Email is required.');
    valid = false;
  } else if (!emailRe.test(email)) {
    fieldErr('loginEmailErr', 'Please enter a valid email address.');
    valid = false;
  }

  if (!password) {
    fieldErr('loginPasswordErr', 'Password is required.');
    valid = false;
  }

  if (!valid) return;

  /* ── Disable button & show loading ── */
  var btn = el('loginBtn');
  btn.disabled = true;
  btn.classList.add('loading');
  btn.textContent = 'Signing in';

  fetch('login.php', {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({ email: email, password: password })
  })
  .then(function(res) { return res.json(); })
  .then(function(data) {
    btn.disabled = false;
    btn.classList.remove('loading');
    btn.textContent = 'Sign In';

    if (data.success) {
      showAlert('loginSuccess', '✔ ' + data.message + ' Redirecting…');
      setTimeout(function() {
        window.location.href = data.redirect || 'Home.html';
      }, 1200);
    } else {
      showAlert('loginError', data.message || 'Login failed. Please try again.');
      el('loginPassword').value = '';
    }
  })
  .catch(function() {
    btn.disabled = false;
    btn.classList.remove('loading');
    btn.textContent = 'Sign In';
    showAlert('loginError', 'Server error. Please try again later.');
  });
}

/* ============================================================
   REGISTER SUBMIT
   ============================================================ */
function submitRegister() {
  clearAll();

  var first    = el('regFirst').value.trim();
  var last     = el('regLast').value.trim();
  var email    = el('regEmail').value.trim();
  var password = el('regPassword').value;
  var confirm  = el('regConfirm').value;
  var valid    = true;

  if (!first) {
    fieldErr('regFirstErr', 'First name is required.');
    valid = false;
  }

  if (!last) {
    fieldErr('regLastErr', 'Last name is required.');
    valid = false;
  }

  if (!email) {
    fieldErr('regEmailErr', 'Email is required.');
    valid = false;
  } else if (!emailRe.test(email)) {
    fieldErr('regEmailErr', 'Please enter a valid email address.');
    valid = false;
  }

  if (!password) {
    fieldErr('regPasswordErr', 'Password is required.');
    valid = false;
  } else if (password.length < 6) {
    fieldErr('regPasswordErr', 'Password must be at least 6 characters.');
    valid = false;
  }

  if (!confirm) {
    fieldErr('regConfirmErr', 'Please confirm your password.');
    valid = false;
  } else if (password !== confirm) {
    fieldErr('regConfirmErr', 'Passwords do not match.');
    valid = false;
  }

  if (!valid) return;

  /* ── Disable button & show loading ── */
  var btn = el('regBtn');
  btn.disabled = true;
  btn.classList.add('loading');
  btn.textContent = 'Creating account';

  fetch('register.php', {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({
      first_name: first,
      last_name:  last,
      email:      email,
      password:   password
    })
  })
  .then(function(res) { return res.json(); })
  .then(function(data) {
    btn.disabled = false;
    btn.classList.remove('loading');
    btn.textContent = 'Create Account';

    if (data.success) {
      showAlert('regSuccess', '✔ ' + data.message);
      /* Clear form fields */
      ['regFirst','regLast','regEmail','regPassword','regConfirm'].forEach(function(id) {
        el(id).value = '';
      });
      /* Switch to login after 2 seconds */
      setTimeout(function() { switchTo('login'); }, 2000);
    } else {
      showAlert('regError', data.message || 'Registration failed. Please try again.');
    }
  })
  .catch(function() {
    btn.disabled = false;
    btn.classList.remove('loading');
    btn.textContent = 'Create Account';
    showAlert('regError', 'Server error. Please try again later.');
  });
}

/* ── Allow Enter key in both panels ── */
document.addEventListener('keydown', function(e) {
  if (e.key !== 'Enter') return;
  if (!el('loginPanel').classList.contains('hidden')) {
    submitLogin();
  } else {
    submitRegister();
  }
});