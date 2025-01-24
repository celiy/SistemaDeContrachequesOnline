function drawTableAdmins() {
  const chequesData = document.getElementById("data_cheques").textContent;
  const cheques = JSON.parse(chequesData);

  // Create the table element
  const table = document.createElement("table");
  table.classList.add("table");

  // Create the table header
  const thead = document.createElement("thead");
  const tr = document.createElement("tr");
  const headers = [
    "ID Cheque",
    "ID Funcionário",
    "Mês",
    "Data geração",
    "Salário base",
    "Vencimentos",
    "Descontos",
    "Salário líquido",
    "Editar",
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
  cheques.forEach((row) => {
    const tr = document.createElement("tr");
    Object.values(row).forEach((value) => {
      const td = document.createElement("td");
      td.textContent = value;
      tr.appendChild(td);
    });

    // Add edit
    const tdEdit = document.createElement("td");
    const editButton = document.createElement("button");
    editButton.textContent = "Editar";
    editButton.onclick = function() {
      const rowItens = (row);
      openContracheques(rowItens, row.id_contracheque);
    };
    tdEdit.appendChild(editButton);

    // Add remove
    const tdRemove = document.createElement("td");
    const removeButton = document.createElement("button");
    removeButton.textContent = "Excluir";
    removeButton.onclick = function() {
      const form = document.getElementById("delete_cheque_form");
      const formType = document.getElementById("delete_cheque");
      const valueToDelete = document.getElementById("value_to_delete_cheque");
      valueToDelete.value = row.id_contracheque;
      form.appendChild(formType);
      form.appendChild(valueToDelete);
      form.submit();
    };
    tdRemove.appendChild(removeButton);

    tr.appendChild(tdEdit);
    tr.appendChild(tdRemove);
    tbody.appendChild(tr);
  });
  table.appendChild(tbody);

  // Append the table to the page
  const section = document.getElementById("cheques");
  section.appendChild(table);
}

document.addEventListener("DOMContentLoaded", function () {
  drawTableAdmins();
});
