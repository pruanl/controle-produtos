# frontend/Dockerfile

FROM node:20

# Definir diretório de trabalho
WORKDIR /app

# Copiar package.json antes de copiar os outros arquivos
# Isso ajuda a cachear as dependências do Yarn se os arquivos de dependência não mudaram
COPY package.json ./

# Instalar todas as dependências do projeto
RUN yarn install

# Copiar todos os arquivos do projeto
COPY . .

# Instalar Vite globalmente
RUN yarn global add vite

# Expor a porta padrão do Vite
EXPOSE 5173

# Comando padrão para rodar o Vite
CMD ["yarn", "run", "dev", "--host"]
