# Páginas de Gestão de Pesos dos Clientes

Este documento descreve as páginas criadas para gerenciar os registros de peso dos clientes no sistema da clínica.

## Páginas Criadas

### 1. Lista de Pesos dos Clientes
**Arquivo:** `/pages/client-weights/client-weight-list.php`
**Rota:** `link.php?route=23`
**Menu:** Pesos dos Clientes > Listar

**Funcionalidades:**
- ✅ Listagem de todos os registros de peso
- ✅ Tabela responsiva com DataTables
- ✅ Busca e filtros
- ✅ Visualização de detalhes
- ✅ Edição de registros
- ✅ Exclusão de registros
- ✅ Badges coloridos para classificação do IMC
- ✅ Integração com API de client-weights

**Colunas da Tabela:**
- ID do registro
- Nome do cliente
- Altura (cm)
- Peso (kg)
- IMC
- Classificação (com badges coloridos)
- Data de registro
- Ações (Visualizar, Editar, Excluir)

### 2. Registro de Peso do Cliente
**Arquivo:** `/pages/client-weights/client-weight-register.php`
**Rota:** `link.php?route=22`
**Menu:** Pesos dos Clientes > Registar

**Funcionalidades:**
- ✅ Formulário para novo registro de peso
- ✅ Seleção de cliente via dropdown
- ✅ Cálculo automático de IMC
- ✅ Determinação automática da classificação
- ✅ Validação de dados
- ✅ Guia visual das classificações de IMC
- ✅ Integração com API de client-weights

**Campos do Formulário:**
- Cliente (obrigatório) - Select com lista de pacientes
- Altura em cm (obrigatório) - Input numérico
- Peso em kg (obrigatório) - Input numérico
- IMC (calculado automaticamente)
- Classificação (determinada automaticamente)

### 3. Modais de Operações CRUD
**Arquivo:** `/pages/client-weights/client-weight-modal.php`

**Modais Incluídos:**
- ✅ **Modal de Visualização:** Exibe detalhes completos do registro
- ✅ **Modal de Adição:** Formulário para novo registro
- ✅ **Modal de Edição:** Formulário para atualizar registro existente
- ✅ **Modal de Exclusão:** Confirmação de exclusão com aviso

**Recursos dos Modais:**
- Cálculo automático de IMC em tempo real
- Validação de campos obrigatórios
- Feedback visual para o usuário
- Integração completa com a API

## Integração no Sistema

### Navegação
As páginas foram integradas no menu lateral do sistema:

```
Pesos dos Clientes
├── Registar (route=22)
└── Listar (route=23)
```

### Roteamento
Adicionado no arquivo `link.php`:
```php
// Pesos dos Clientes
$pag[22] = "client-weights/client-weight-register.php";
$pag[23] = "client-weights/client-weight-list.php";
```

### Menu de Navegação
Adicionado no arquivo `src/components/header.php` com ícone `feather icon-activity`.

## Recursos Técnicos

### Frontend
- **Framework CSS:** Bootstrap 4
- **Tabelas:** DataTables com responsividade
- **Ícones:** Feather Icons e IcoFont
- **Alertas:** SweetAlert
- **AJAX:** jQuery para comunicação com API

### Backend
- **API:** Endpoints CRUD completos
- **Validação:** Server-side e client-side
- **Cálculos:** IMC e classificação automáticos
- **Segurança:** Sanitização de dados

### Funcionalidades Especiais

#### Cálculo Automático de IMC
```javascript
function calculateBMI(height, weight) {
    if (height && weight && height > 0 && weight > 0) {
        const heightInMeters = height / 100;
        const bmi = weight / (heightInMeters * heightInMeters);
        return bmi;
    }
    return null;
}
```

#### Classificação Visual com Badges
- **Abaixo do peso:** Badge cinza
- **Peso normal:** Badge verde
- **Sobrepeso:** Badge amarelo
- **Obesidade grau I:** Badge laranja
- **Obesidade grau II:** Badge vermelho
- **Obesidade grau III:** Badge roxo

#### Validações Implementadas
- Cliente obrigatório
- Altura entre 50-250 cm
- Peso entre 20-300 kg
- Campos numéricos com decimais
- Prevenção de submissão duplicada

## Como Usar

### Para Registrar um Novo Peso:
1. Acesse "Pesos dos Clientes" > "Registar"
2. Selecione o cliente
3. Insira altura e peso
4. O IMC e classificação são calculados automaticamente
5. Clique em "Salvar Registro"

### Para Gerenciar Registros:
1. Acesse "Pesos dos Clientes" > "Listar"
2. Use a busca para encontrar registros específicos
3. Clique nos botões de ação para:
   - 👁️ Visualizar detalhes
   - ✏️ Editar registro
   - 🗑️ Excluir registro

## URLs de Acesso

- **Lista:** `http://localhost/clinica-system/link.php?route=23`
- **Registro:** `http://localhost/clinica-system/link.php?route=22`

## Arquivos Criados

```
pages/client-weights/
├── client-weight-list.php      # Página de listagem
├── client-weight-register.php  # Página de registro
└── client-weight-modal.php     # Modais CRUD
```

## Status do Projeto

✅ **Concluído:** Todas as páginas foram criadas e integradas com sucesso ao sistema da clínica, seguindo os padrões existentes e oferecendo uma experiência de usuário completa para gestão de pesos dos clientes.
