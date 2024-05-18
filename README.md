# Sistema de Controle de Produtos

Este projeto é um sistema de controle de produtos, desenvolvido utilizando Laravel 11 e Vue 3. O sistema permite gerenciar produtos contendo nome, situação, preço, categoria e foto.

## Tecnologias Utilizadas

### Backend
- **Laravel 11**: Framework PHP para o desenvolvimento do backend.
- **MySQL**: Banco de dados relacional para persistência dos dados.
- **Redis**: Utilizado para cache.
- **Docker & Docker Compose**: Para gerenciar os containers do ambiente de desenvolvimento.

### Frontend
- **Vue 3**: Framework JavaScript para o desenvolvimento do frontend.
- **TypeScript**: Linguagem utilizada no frontend para adicionar tipagem estática.
- **Pinia**: Biblioteca para gerenciamento de estado.
- **Tailwind CSS**: Framework CSS para estilização da aplicação.
- **Vite**: Ferramenta de build para projetos frontend.

## Funcionalidades

- **CRUD de Produtos**: Criar, ler, atualizar e deletar produtos.
- **Upload de Imagens**: Enviar imagens para o endpoint `/api/upload/imagem` e associá-las aos produtos.
- **Autenticação**: Login e gerenciamento de sessão com tokens Bearer.
- **Filtragem e Paginação**: Listagem de produtos com filtros e paginação.
- **Validação**: Camada de validação separada utilizando `ProductRequest` em vez de `Request`.

## Estrutura do Projeto

### Backend
- **Services e Repositories**: Implementação de uma estrutura com services e repositories para organizar a lógica de negócio e acesso a dados.
- **Validações**: Validações centralizadas em uma camada separada para maior controle e organização.

### Frontend
- **Gerenciamento de Sessão**: O token Bearer é salvo no Pinia e enviado em todas as requisições subsequentes. Se o token expirar, o usuário é redirecionado para a página de login.
- **Estilização**: Utilização de Tailwind CSS para uma estilização eficiente e customizável.

## Utilização

Para executar o projeto, basta utilizar o comando abaixo:

```sh
docker compose up --build
```

### Acessando a Aplicação

Após iniciar os containers, a aplicação estará disponível no endereço `http://localhost:5173`. Utilize as credenciais abaixo para fazer login:

- **E-mail**: admin@admin.com
- **Senha**: admin

## Instalação e Configuração

### Pré-requisitos
- Docker
- Docker Compose
- Node.js

### Passos para Instalação Manual (sem o docker)

1. Clone o repositório:
   ```sh
   git clone https://github.com/seu-usuario/sistema-controle-produtos.git
   cd sistema-controle-produtos
   ```

2. Configure o backend:
   ```sh
   cd backend
   cp .env.example .env
   docker-compose up -d
   docker-compose exec app php artisan key:generate
   ```

3. Configure o frontend:
   ```sh
   cd ../frontend
   cp .env.example .env
   npm install
   npm run dev
   ```

### Executando a Aplicação

Com o backend e o frontend configurados, você pode acessar a aplicação através do endereço `http://localhost:3000` (ou o endereço configurado no Vite).

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests para adicionar novas funcionalidades, corrigir bugs ou melhorar a documentação.

## Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

Espero que este README atenda às suas necessidades. Se precisar de mais alguma coisa, estou à disposição!
