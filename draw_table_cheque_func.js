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
