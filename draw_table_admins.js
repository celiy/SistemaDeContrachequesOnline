function drawTableAdmins() {
  const funcionariosData =
    document.getElementById("data_admins").textContent;
  const funcionarios = JSON.parse(funcionariosData);

  // Create the table element
  const table = document.createElement("table");
  table.classList.add("table");

  // Create the table header
  const thead = document.createElement("thead");
  const tr = document.createElement("tr");
  const headers = [
    "ID",
    "E-mail",
    "Ultimo Acesso",
    "Está ativo",
    "Excluir",
  ];
  headers.forEach((header) => {
    const th = document.createElement("th");
    th.textContent = header;
    tr.appendChild(th);
  });


  thead.appendChild(tr);
  table.appendChild(thead);

  // Create the table body
  const tbody = document.createElement("tbody");
  funcionarios.forEach((row) => {
    const tr = document.createElement("tr");
    Object.values(row).forEach((value) => {
      const td = document.createElement("td");
      td.textContent = value;
      tr.appendChild(td);
    });

    // Add remove
    const tdRemove = document.createElement("td");
    const removeButton = document.createElement("button");
    removeButton.textContent = "Excluir";
    removeButton.onclick = function() {
      const form = document.getElementById("delete_admin_form");
      const formType = document.getElementById("delete_admin");
      const valueToDelete = document.getElementById("value_to_delete_admin");
      valueToDelete.value = row.id_admin;
      form.appendChild(formType);
      form.appendChild(valueToDelete);
      form.submit();
    };
    tdRemove.appendChild(removeButton);

    tr.appendChild(tdRemove);
    tbody.appendChild(tr);
  });
  table.appendChild(tbody);

  // Append the table to the page
  const section = document.getElementById("admins");
  section.appendChild(table);
}

document.addEventListener("DOMContentLoaded", function () {
  drawTableAdmins();
});