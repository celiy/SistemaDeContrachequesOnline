function drawTable() {
  const funcionariosData =
    document.getElementById("data").textContent;
  const funcionarios = JSON.parse(funcionariosData);

  // Create the table element
  const table = document.createElement("table");
  table.classList.add("table");

  // Create the table header
  const thead = document.createElement("thead");
  const tr = document.createElement("tr");
  const headers = [
    "ID",
    "Nome",
    "E-mail",
    "CPF",
    "Data de Admissão",
    "Departamento",
    "Cargo",
    "Salário Base (R$)",
    "Editar",
    "Excluir"
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
    
    // Add edit
    const tdEdit = document.createElement("td");
    const editButton = document.createElement("button");
    editButton.textContent = "Editar";
    editButton.onclick = function() {
      const rowItens = (row);
      openCadastroFuncionario(rowItens, row.id_funcionario);
    };
    tdEdit.appendChild(editButton);

    // Add remove
    const tdRemove = document.createElement("td");
    const removeButton = document.createElement("button");
    removeButton.textContent = "Excluir";
    removeButton.onclick = function() {
      const form = document.getElementById("delete_func_form");
      const formType = document.getElementById("delete_func");
      const valueToDelete = document.getElementById("value_to_delete");
      valueToDelete.value = row.id_funcionario;
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
  const section = document.querySelector("section");
  section.appendChild(table);
}

document.addEventListener("DOMContentLoaded", function () {
  drawTable();
});

{/* <section>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>CPF</th>
        <th>Data de Admissão</th>
        <th>Departamento</th>
        <th>Cargo</th>
        <th>Salário Base</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>543</td>
        <td>func1</td>
        <td>func@email.com</td>
        <td>44353</td>
        <td>0000-00-00</td>
        <td>departamento1</td>
        <td>cargo 1</td>
        <td>20</td>
      </tr>
    </tbody>
  </table>
</section>; */}