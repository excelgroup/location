

// Demand cascade input.
function upref(){
    // GET ID Référenec
  var id = document.getElementById("category").value;

    // FORM DATA<
  var data = new FormData();
  data.append("id", id);

    // AJAX FETCH Référenece
  fetch("../class/ajax.php?column=category", {
  method: "POST",
  body: data
  })
  .then(res => res.json())
  .then(res => {
      var selector = document.getElementById("soucateg");
      selector.innerHTML = "";
      for (let i in res) {
      let opt = document.createElement("option");
      opt.value = i;
      opt.innerHTML = res[i];
      selector.appendChild(opt);
      }
  })
}