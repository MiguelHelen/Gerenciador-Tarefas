# 🎨 Stickie Tasks
### Gerenciador de tarefas em formato de post-its


## 📌 Sobre o projeto

O **Stickie Tasks** é uma aplicação web para gerenciamento de tarefas que utiliza um conceito visual baseado em **post-its digitais**.

Diferente de listas tradicionais, o sistema oferece uma abordagem mais intuitiva e agradável, permitindo que o usuário organize suas tarefas de forma clara, visual e eficiente.

---

## 🎯 Objetivo

Este projeto foi desenvolvido com foco em:

- Praticar Laravel na prática  
- Implementar autenticação completa  
- Desenvolver um CRUD funcional  
- Aplicar o padrão MVC  
- Criar uma interface moderna e responsiva  

---

## 🧠 Conceito da aplicação

Cada tarefa funciona como um **post-it**, contendo:

- 🎨 Cor automática (cada tarefa tem uma cor única)  
- 📝 Título  
- 📄 Descrição  
- 🏷️ Prioridade (baixa, média, alta)  
- 📅 Data limite  
- ✅ Status (pendente ou concluída)  

---

## ✨ Funcionalidades

### 🔐 Autenticação
- Cadastro de usuário  
- Login seguro  
- Logout  
- Proteção de rotas com middleware  
- Isolamento de dados por usuário  

### 📝 CRUD de tarefas
- Criar tarefas  
- Listar tarefas  
- Editar tarefas  
- Excluir tarefas  

### 🎯 Recursos adicionais
- Filtro por status (todas, pendentes, concluídas)  
- Indicador visual de tarefas atrasadas  
- Cores automáticas para cada tarefa  
- Interface responsiva  
- Animações nos cards  

---

Tecnologias Usadas

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8-orange?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple?style=for-the-badge&logo=bootstrap)
![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)

</div>

---

## ⚙️ Instalação e execução

### 📋 Pré-requisitos

- PHP >= 8.2  
- Composer  
- MySQL  
- Node.js (opcional)  

---

### 🚀 Passo a passo

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/stickie-tasks.git

# Entre na pasta
cd stickie-tasks

# Instale as dependências
composer install

# Configure o ambiente
cp .env.example .env
php artisan key:generate

Configure o banco no .env:

DB_DATABASE=gerenciador_tarefas
DB_USERNAME=root
DB_PASSWORD=
# Execute as migrations
php artisan migrate

# Inicie o servidor
php artisan serve

Acesse no navegador:

http://localhost:8000
