# 📘 Projeto PHP com PDO

Este projeto demonstra o uso de **PHP com PDO (PHP Data Objects)** para gerenciar estudantes e seus telefones usando SQLite. Ele foi desenvolvido com boas práticas de organização e separação em camadas.

## 📁 Estrutura do Projeto

🔹 **index.php**  
Exibe a lista de estudantes cadastrados.

🔹 **insert-student.php**  
Insere um novo estudante e seus telefones no banco de dados.

🔹 **delete-student.php**  
Remove um estudante pelo seu ID.

🔹 **select-students.php**  
Lista todos os estudantes armazenados no banco.

🔹 **select-students-with-phone.php**  
Exibe estudantes junto com seus telefones, usando `JOIN`.

🔹 **create-class.php**  
Cria uma instância de estudante e a salva usando as classes do domínio.

🔹 **database-connection.php**  
Faz a conexão básica com o banco de dados usando PDO (utilizado em scripts diretos).

## 🧱 Arquitetura em Camadas

📦 `Domain/Models/`  
📄 `Student.php`: representa a entidade Estudante.  
📄 `Phone.php`: representa o telefone do estudante.

📦 `Domain/Repository/`  
📄 `StudentRepository.php`: define a interface de repositório.

📦 `Infrastructure/Persistence/`  
📄 `ConnectionCreator.php`: cria a conexão PDO com SQLite.

📦 `Infrastructure/Repository/`  
📄 `PdoStudentRepository.php`: implementação da interface usando PDO.

## 🗃️ Banco de Dados

Este projeto utiliza **SQLite**. O arquivo `database.sqlite` será criado automaticamente quando o projeto for executado.

## 📦 Composer

Utiliza **Composer** para autoload via `psr-4`.  
Para instalar as dependências:

```bash
composer install
```

## ▶️ Como Executar

1. Certifique-se de ter PHP e SQLite instalados.
2. Execute o servidor embutido:

```bash
php -S localhost:8000
```

3. Acesse `http://localhost:8000` no navegador.

## 📝 Licença

Distribuído sob a licença MIT.
