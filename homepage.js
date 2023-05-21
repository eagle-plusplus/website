// Get all elements with class "accordion"
let acc = document.getElementsByClassName("accordion");

// Iterate over each accordion element
for (let i = 0; i < acc.length; i++) {
  // Add a click event listener to toggle the active class and expand/collapse the panel
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active"); // Toggle the "active" class of the clicked accordion
    let panel = this.nextElementSibling; // Get the next sibling element (panel) of the clicked accordion
    if (panel.style.maxHeight) {
      // If the panel is already expanded (has a max-height value), collapse it by setting max-height to null
      panel.style.maxHeight = null;
    } else {
      // If the panel is collapsed, expand it by setting max-height to its scrollHeight
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}