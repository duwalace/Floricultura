# 🌸 VivaFlor - E-commerce para Floricultura

Sistema completo de e-commerce para floricultura com painel administrativo, desenvolvido em PHP/MySQL.

## ✨ Funcionalidades Principais
- 🛒 **Carrinho de Compras** com cálculo de frete
- 👤 **Autenticação** de usuários (cliente/admin)
- 📊 **Painel Administrativo** para gestão de produtos/pedidos
- 🌷 **Catálogo Organizado** por categorias (buquês, plantas, presentes)
- 📱 **Design Responsivo** para mobile e desktop

## 🛠 Stack Tecnológica
| Front-end       | Back-end       | Banco de Dados | Infraestrutura  |
|-----------------|----------------|----------------|-----------------|
| HTML5           | PHP 8+         | MySQL 8.0      | XAMPP/Apache    |
| CSS3 (Flex/Grid)| POO/MVC        | Procedures     | Composer        |
| JavaScript ES6  | JWT Auth       | Triggers       | Git             |

## 🚀 Instalação

### Pré-requisitos
- PHP 8.0+
- MySQL 5.7+
- Apache/Nginx
- Composer (opcional)

```bash
# Clonar repositório
git clone https://github.com/seu-usuario/floricultura.git
cd floricultura

# Configurar banco de dados
mysql -u root -p < database/structure.sql
mysql -u root -p < database/sample_data.sql

# Configurar ambiente
cp includes/config.example.php includes/config.php
📦 Estrutura de Arquivos
floricultura/
├── .vscode/
│ │ └── settings.json
│ ├── admin/
│ │ ├── components/
│ │ ├── barra-navegacao.php
│ │ ├── menu-lateral.php
│ │ ├── adicionar-produto.php
│ │ ├── adicionar-usuario.php
│ │ ├── editar-produto.php
│ │ ├── editar-usuario.php
│ │ ├── excluir-produto.php
│ │ ├── excluir-usuario.php
│ │ ├── index.php
│ │ ├── produtos.php
│ │ └── usuarios.php
│ ├── ajax/
│ │ ├── adicionar-ao-carrinho.php
│ │ ├── atualizar-carrinho.php
│ │ ├── contar-itens-carrinho.php
│ │ ├── limpar-carrinho.php
│ │ ├── processar-cadastro.php
│ │ ├── processar-login.php
│ │ └── remover-do-carrinho.php
│ ├── assets/
│ │ ├── css/
│ │ │ ├── admin.css
│ │ │ ├── estilo-novo.css
│ │ │ └── estilo.css
│ │ └── js/
│ │ ├── admin.js
│ │ ├── script-novo.js
│ │ └── script.js
│ ├── components/
│ │ ├── barra-navegacao.php
│ │ └── rodape.php
│ ├── config/
│ │ ├── conexao.php
│ │ └── global.php
│ ├── img/
│ ├── models/
│ │ ├── Carrinho.php
│ │ ├── Produto.php
│ │ └── Usuario.php
│ └── public/
│ ├── .htaccess
│ ├── cadastro.php
│ ├── carrinho.php
│ ├── detalhes-produto.php
│ ├── floricultura.sql
│ ├── index.php
│ ├── login.php
│ ├── logout.php
│ └── produtos.php
└── README.md
🔐 Acesso de Teste
Tipo	Email	Senha
Admin	admin@vivaflor.com	Admin@123
Cliente	cliente@teste.com	Cliente123
📌 Roadmap
MVP inicial

Integração com PagSeguro

Sistema de cupons

Relatórios avançados

🤝 Contribuição
Faça um fork do projeto

Crie uma branch (git checkout -b feature/nova-funcionalidade)

Commit suas mudanças (git commit -m "Adiciona XYZ")

Push para a branch (git push origin feature/nova-funcionalidade)

Abra um Pull Request

---
