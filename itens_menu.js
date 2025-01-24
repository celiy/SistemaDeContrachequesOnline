let itensMenu = {};

document.addEventListener("DOMContentLoaded", function () {
    itensMenu = {
        "cadastroFuncionario": document.getElementById("cadastro-funcionario"),
        "funcionariosData": document.getElementById("funcionarios-data"),
        "cadastroAdministradores": document.getElementById("cadastro-administradores"),
        "contracheques": document.getElementById("contracheques"),
        "contracheques_table": document.getElementById("contracheques_table"),
    }

    const url = new URL(window.location.href);
    const fragment = url.hash;
    if (fragment){
        Object.keys(itensMenu).forEach(key => {
            const tostr = "#"+itensMenu[key].id
            if (tostr !== fragment){
                itensMenu[key].style.display = 'none';
            }
        });
    } else {
        let count = 0;
        Object.keys(itensMenu).forEach(key => {
            if (count !== 0){
                itensMenu[key].style.display = 'none';
            }
            count++;
        });
    }
});

function setItensNone (itemKey){
    Object.keys(itensMenu).forEach(key => {
        if (key != itemKey){
            itensMenu[key].style.display = 'none';
        }
    });
}

function openCadastroFuncionario(itensFROW, funcID){
    const key = 'cadastroFuncionario';
    setItensNone(key);
    itensMenu.cadastroFuncionario.style.display = 'block';
    
    const formItens = []
    formItens.push(
        [document.getElementById('nome')],
        [document.getElementById('email')],
        [document.getElementById('senha')],
        [document.getElementById('cpf')],
        [document.getElementById('admissao')],
        [document.getElementById('departamento')],
        [document.getElementById('cargo')],
        [document.getElementById('salario')]
    )
    const btn = document.getElementById('cadastrar_func');
    const formType = document.getElementById('form_type_func');
    const formID = document.getElementById('id_func');

    if (itensFROW){
        const itens = itensFROW;
        formItens[0][0].value = itens.nome;
        formItens[1][0].value = itens.email;
        formItens[2][0].disabled = true;
        formItens[3][0].value = itens.cpf;
        formItens[4][0].value = itens.admissao;
        formItens[5][0].value = itens.departamento;
        formItens[6][0].value = itens.cargo;
        formItens[7][0].value = itens.salario_base;
        btn.value = 'Alterar';
        formType.value = 'update_func';
        formID.value = funcID;
    } else {
        for (let n=0; n<formItens.length; n++){
            formItens[n][0].value = null;
        }
        formItens[2][0].disabled = false;
        btn.value = 'Cadastrar';
        formType.value = 'funcionario';
        formID.value = null;
    }
}

function openConsultaFuncionario(){
    const key = 'funcionariosData';
    setItensNone(key);
    itensMenu.funcionariosData.style.display = 'block';
}

function openCadastrarAdministradores(){
    const key = 'cadastroAdministradores';
    setItensNone(key);
    itensMenu.cadastroAdministradores.style.display = 'block';
}

function openContracheques(itensFROW, chequeID){
    const key = 'contracheques';
    setItensNone(key);
    itensMenu.contracheques.style.display = 'block';
    const formItens = []
    formItens.push(
        [document.getElementById('mes')],
        [document.getElementById('geracao')],
        [document.getElementById('salario')],
        [document.getElementById('vencimentos')],
        [document.getElementById('desconto')],
        [document.getElementById('liquido')],
        [document.getElementById('funcionario')]
    )
    const btn = document.getElementById('cadastrar_cheque');
    const formType = document.getElementById('form_type_cheque');
    const formID = document.getElementById('id_cheque');

    if (itensFROW){
        const itens = itensFROW;
        formItens[0][0].value = itens.mes_referencia;
        formItens[1][0].value = itens.data_geracao;
        formItens[2][0].value = itens.salario_base*1;
        formItens[3][0].value = itens.total_vencimentos;
        formItens[4][0].value = itens.total_descontos;
        formItens[5][0].value = itens.salario_liquido;
        formItens[6][0].value = itens.id_funcionario;
        btn.value = 'Alterar';
        formType.value = 'update_cheque';
        formID.value = chequeID;
    } else {
        for (let n=0; n<formItens.length; n++){
            formItens[n][0].value = null;
        }
        btn.value = 'Cadastrar';
        formType.value = 'contracheque';
        formID.value = null;
    }
}

function openContrachequesTable(){
    const key = 'contracheques_table';
    setItensNone(key);
    itensMenu.contracheques_table.style.display = 'block';
}