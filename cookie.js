// Set the initial background color based on the 'mode' cookie
setBackgroundBasedOnMode();

// Add event listener to the theme change button
document.getElementById('theme-btn').addEventListener('click', changeTheme);

/**
 * Set the background color based on the value of the 'mode' cookie.
 * If the 'mode' cookie is not set, default to 'light' and create the cookie.
 */
function setBackgroundBasedOnMode() {
  var cookieValue = getCookie('mode');
  if (cookieValue === 'dark') {
    // Set the background color to grey for 'dark' mode
    document.body.style.backgroundColor = '#121212';
  } else if (cookieValue === 'light') {
    // Set the background color to blue for 'light' mode
    document.body.style.backgroundColor = '#7ebfb3';
  } else {
    // If no cookie is set, default to blue and create the 'mode' cookie
    document.body.style.backgroundColor = '#7ebfb3';
    setCookie('mode', 'light', 5); // Set 'mode' cookie to 'light' for 5 days
  }
}

/**
 * Change the theme based on the current value of the 'mode' cookie.
 * Toggle between 'light' and 'dark' mode and update the cookie accordingly.
 */
function changeTheme() {
  var cookieValue = getCookie('mode');
  if (cookieValue === 'dark') {
    // Change to 'light' mode and update the 'mode' cookie
    setCookie('mode', 'light', 5);
    document.body.style.backgroundColor = '#7ebfb3';
  } else if (cookieValue === 'light') {
    // Change to 'dark' mode and update the 'mode' cookie
    setCookie('mode', 'dark', 5);
    document.body.style.backgroundColor = '#121212';
  }
}

/**
 * Set a cookie with a name, value, and expiration date.
 * @param {string} name - The name of the cookie.
 * @param {string} value - The value of the cookie.
 * @param {number} expirationDays - The number of days until the cookie expires.
 */
function setCookie(name, value, expirationDays) {
  var date = new Date();
  date.setTime(date.getTime() + (expirationDays * 24 * 60 * 60 * 1000)); // Set expiration date in milliseconds
  var expires = 'expires=' + date.toUTCString();
  document.cookie = name + '=' + value + ';' + expires + ';path=/';
}

/**
 * Get the value of a cookie by its name.
 * @param {string} cname - The name of the cookie.
 * @returns {string} - The value of the cookie.
 */
function getCookie(cname) {
  let name = cname + '=';
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length);
    }
  }
  return '';
}
