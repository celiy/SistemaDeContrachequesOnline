# Sistema de Contracheques Online

Sistema web feito em PHP com MySQL para consultar contracheques pela internet. O administrador cadastra funcionários, outros administradores e contracheques, e pode enviar o PDF de cada um. O funcionário entra com o próprio login e baixa o que já foi enviado para ele.

## O que precisa

PHP com a extensão mysqli e um banco MySQL ou MariaDB. Qualquer pacote pronto como o XAMPP já traz tudo isso. Também dá para rodar com Docker, e os dois jeitos estão abaixo.

O banco tem que se chamar `sistema_contracheque`. O arquivo `db_principal.php` conecta em `localhost` com o usuário `root` e senha vazia, então se o seu banco for diferente é nele que se muda.

## Rodando com XAMPP

1. Coloque esta pasta dentro do `htdocs` e ligue o Apache e o MySQL.
2. Crie um banco chamado `sistema_contracheque`.
3. Abra o arquivo `db/db.txt` e execute o conteúdo nesse banco. Ele cria as tabelas, os gatilhos que geram os ids e alguns dados de teste.
4. Acesse `http://localhost/SistemaDeContrachequesOnline/login.php`.

## Rodando com Docker

Na pasta do projeto. O PHP precisa falar com o banco por socket, porque o `db_principal.php` usa `localhost`, então os dois containers dividem um volume.

```bash
printf 'FROM php:8.3-cli\nRUN docker-php-ext-install mysqli\n' | docker build -t contracheque-php -
```

```bash
docker volume create contracheque-sock
```

```bash
docker run -d --name contracheque-db -v contracheque-sock:/run/mysqld -e MARIADB_ALLOW_EMPTY_ROOT_PASSWORD=1 -e MARIADB_DATABASE=sistema_contracheque mariadb:11 --skip-networking
```

Espere uns 10 segundos o banco terminar de subir e carregue o script.

```bash
docker exec -i contracheque-db mariadb -uroot sistema_contracheque < db/db.txt
```

```bash
docker run -d --name contracheque-app --network host -v contracheque-sock:/run/mysqld -v "$PWD":/app -w /app contracheque-php php -d mysqli.default_socket=/run/mysqld/mysqld.sock -S 127.0.0.1:8001
```

Depois é só abrir `http://127.0.0.1:8001/login.php`. O banco não abre porta nenhuma e o site só responde na própria máquina. Para apagar tudo:

```bash
docker rm -f contracheque-app contracheque-db
```

## Logins de exemplo

São os dados de teste que o `db/db.txt` já cria. O e-mail é escrito assim mesmo, sem ponto com.

| Tipo | E-mail | Senha |
| --- | --- | --- |
| Administrador | admin@email | admin |
| Funcionário Diogo | diogo@email | 123 |
| Funcionário Aniele | aniele@email | 456 |
| Funcionário Romenei | romenei@email | 789 |

O administrador cai na página `administrativo.php` e o funcionário na `funcionario.php`.

## Pastas e arquivos

O `login.php` cuida da entrada e o `sair.php` da saída. Os PDFs enviados pelo administrador ficam na pasta `uploads`, e o script do banco está em `db/db.txt`.

As senhas ficam gravadas sem criptografia e o login compara o texto direto. Serve para estudo, mas antes de usar de verdade precisa trocar por `password_hash`.
