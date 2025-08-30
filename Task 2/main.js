const array = [
  { name: "apple", count: 5, price: 70 },
  { name: "orange", count: 10, price: 90 },
];

let result = 0;
array.forEach((e) => (result += e.count * e.price));
console.log("Общая сумма товаров: " + result);

const obj = {
  bill: array,
  result: result,
};
console.log(JSON.stringify(obj));

console.log((new Date()).toString());

// Copy text

const elements = document.querySelectorAll("li");
const btnCopy = document.querySelector(".copy");
const text = document.querySelector(".text");

let copyString = "";
elements.forEach((e) => copyString += e.textContent + ", ");
btnCopy.addEventListener("click", () => text.textContent += copyString);

// Change Style

const btnChange = document.querySelector(".changeStyle");
let fontSize = 16;

btnChange.addEventListener("click", () => {
  fontSize += 2;
  elements.forEach((e) => e.style.fontSize = `${fontSize}px`);
});

// Search

const input = document.querySelector(".search");

input.addEventListener("input", () => {
  const inputValue = input.value;
  elements.forEach((e) => {
    const eText = e.innerText;

    if (eText.includes(inputValue)) {
      const regex = new RegExp(inputValue, "g");
      const coloredText = eText.replace(regex, `<span>${inputValue}</span>`);
      e.innerHTML = coloredText;
    }
  });
});
