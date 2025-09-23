# Gerenciamento de Estoque de Medicamentos nas Receitas Médicas

Este documento descreve como o sistema gerencia automaticamente o estoque de medicamentos quando receitas médicas são criadas, atualizadas ou excluídas.

## Funcionalidades Implementadas

### 1. Verificação de Estoque ao Criar Receitas

Quando uma nova receita médica é criada, o sistema:

1. Verifica se há estoque suficiente para todas as medicações solicitadas
2. Rejeita a operação se alguma medicação não tiver estoque suficiente
3. Subtrai automaticamente as quantidades do estoque quando a receita é confirmada

### 2. Ajuste de Estoque ao Atualizar Receitas

Quando uma receita médica é atualizada, o sistema:

1. Devolve ao estoque as quantidades das medicações da receita original
2. Verifica se há estoque suficiente para as novas medicações solicitadas
3. Subtrai do estoque as quantidades das novas medicações
4. Rejeita a operação se alguma medicação não tiver estoque suficiente

### 3. Devolução ao Estoque ao Excluir Receitas

Quando uma receita médica é excluída, o sistema:

1. Devolve automaticamente ao estoque todas as quantidades de medicações da receita
2. Remove a receita e suas associações com medicações

## Fluxo de Operações

### Criação de Receita

```
1. Usuário seleciona medicações e quantidades
2. Sistema verifica se há estoque suficiente
3. Se sim, cria a receita e subtrai do estoque
4. Se não, exibe mensagem de erro informando quais medicações não têm estoque suficiente
```

### Atualização de Receita

```
1. Usuário modifica medicações e/ou quantidades
2. Sistema devolve ao estoque as quantidades originais
3. Sistema verifica se há estoque suficiente para as novas quantidades
4. Se sim, atualiza a receita e subtrai do estoque
5. Se não, exibe mensagem de erro e reverte a operação
```

### Exclusão de Receita

```
1. Usuário solicita exclusão da receita
2. Sistema devolve ao estoque todas as quantidades
3. Sistema remove a receita e suas associações
```

## Mensagens de Erro

O sistema pode retornar as seguintes mensagens de erro relacionadas ao estoque:

1. **Medicação não encontrada**: "Medicação não encontrada: ID X"
2. **Estoque insuficiente**: "Estoque insuficiente para a medicação ID X. Disponível: Y, Solicitado: Z"

## Exemplo de Uso

### Criação de Receita com Verificação de Estoque

```json
// Requisição
{
  "action": "add",
  "date": "2023-09-23",
  "consult_id": 1,
  "medications": [
    {
      "medication_id": 1,
      "qty": 2,
      "dosage": "1 comprimido a cada 8 horas"
    },
    {
      "medication_id": 2,
      "qty": 1,
      "dosage": "1 comprimido ao dia"
    }
  ]
}

// Resposta de sucesso
{
  "status": "success",
  "message": "Receita médica cadastrada com sucesso!",
  "recipe_id": 3
}

// Resposta de erro (estoque insuficiente)
{
  "status": "error",
  "message": "Estoque insuficiente para a medicação ID 1. Disponível: 1, Solicitado: 2"
}
```

## Observações Importantes

1. Todas as operações de estoque são realizadas dentro de transações para garantir a integridade dos dados.
2. Se ocorrer qualquer erro durante o processo, todas as alterações são revertidas (rollback).
3. O sistema mantém um registro de erros para facilitar a depuração.
4. É recomendável implementar um sistema de alertas para notificar quando o estoque de medicamentos estiver baixo.
5. Considere adicionar um limite mínimo de estoque para cada medicamento para evitar que fiquem completamente sem estoque.
