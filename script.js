const JSONcopyButton = document.querySelector('.copyButton');
const JSONfield = document.querySelector('.JSONfield');

//I don't need two blocks for this but it's late o' clock and I need to style.
// JSONcopyButton.addEventListener('click', () => {
//   copyJSON();
// });

function copyJSON() {
  navigator.clipboard.writeText(JSONfield.innerHTML);
  alert("JSON-string copied to clipboard!");
};