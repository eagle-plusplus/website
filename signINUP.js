// Get references to the register and login buttons and the container element
const registerButton = document.getElementById("register");
const loginButton = document.getElementById("login");
const container = document.getElementById("container");

// Add event listener to the register button
registerButton.addEventListener("click", () => {
  // Add the 'right-panel-active' class to the container element
  container.classList.add("right-panel-active");
});

// Add event listener to the login button
loginButton.addEventListener("click", () => {
  // Remove the 'right-panel-active' class from the container element
  container.classList.remove("right-panel-active");
});
