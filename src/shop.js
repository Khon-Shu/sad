let shop = document.getElementById("shop");//pcs and laptops
let key=document.getElementById("key");//keyboard
let con=document.getElementById("con");//console
let basket = JSON.parse(localStorage.getItem("data")) || [];

let generateShop = (itemstorage,container) => {
  return (container.innerHTML = itemstorage
    .map((x) => {
      let { id, name, price, desc, img } = x;
      let search = basket.find((x) => x.id === id) || [];
      return `
      <div class="card" style="background-image:url(${img});">
        <div class="card-content">
          <h2 class="card-title">${name}</h2>
          <p class="card-body">
            ${desc}
          </p>
          <h2>$ ${price}</h2>
          <div class="buttons">
            <i onclick="decrement(${id})" class="bi bi-dash-lg"></i>
              <div id=${id} class="quantity">
              ${search.item === undefined ? 0 : search.item}
              </div>
            <i onclick="increment(${id})" class="bi bi-plus-lg"></i>
          </div>
        </div>
      </div>
      `;
    }).join(""));
};
generateShop(shopItemsData,shop);
generateShop(keyboardItems,key);
generateShop(consoleData,con);

let increment = (id) => {
  let selectedItem = id;
  let search = basket.find((x) => x.id === selectedItem.id);

  if (search === undefined) {
    basket.push({
      id: selectedItem.id,
      item: 1,
    });
  } else {
    search.item += 1;
  }
  // console.log(basket);
  update(selectedItem.id);

  localStorage.setItem("data", JSON.stringify(basket));
};
let decrement = (id) => {
  let selectedItem = id;
  let search = basket.find((x) => x.id === selectedItem.id);

  if (search === undefined) return;
  else if (search.item === 0) return;
  else {
    search.item -= 1;
  }
  update(selectedItem.id);
  basket = basket.filter((x) => x.item !== 0);
  // console.log(basket);

  localStorage.setItem("data", JSON.stringify(basket));
};

let update = (id) => {
  let search = basket.find((x) => x.id === id);
  console.log(search.item);
  console.log(id);
  document.getElementById(id).innerHTML = search.item;
};
