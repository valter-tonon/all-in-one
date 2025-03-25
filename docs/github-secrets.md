# Configuração de Secrets no GitHub

Este documento explica como configurar corretamente os secrets no GitHub para proteger informações sensíveis como credenciais de servidores.

## Por que usar Secrets em vez de variáveis expostas?

Informações sensíveis como nomes de host, nomes de usuário, senhas e chaves SSH nunca devem ser expostas diretamente no código ou em arquivos de configuração versionados. 

Expor esses dados pode levar a:
- Acesso não autorizado aos seus servidores
- Comprometimento da segurança da sua aplicação
- Vazamento de dados
- Ataques maliciosos

## Como configurar Secrets no GitHub

1. Acesse o repositório no GitHub
2. Vá para "Settings" (Configurações)
3. No menu lateral, clique em "Secrets and variables" → "Actions"
4. Clique em "New repository secret"
5. Adicione os seguintes secrets:
   - `SSH_PRIVATE_KEY`: Sua chave SSH privada
   - `SSH_USER`: Nome de usuário para conexão SSH
   - `VM_HOSTS`: Endereço do(s) servidor(es)

## Usando os Secrets nos Workflows

No arquivo de workflow (`.github/workflows/*.yml`), você pode acessar os secrets usando a sintaxe:

```yaml
${{ secrets.NOME_DO_SECRET }}
```

Por exemplo:
```yaml
ssh ${{ secrets.SSH_USER }}@${{ secrets.VM_HOSTS }}
```

## Importante

- Nunca adicione informações sensíveis diretamente em arquivos de configuração
- Troque senhas e chaves se elas foram acidentalmente expostas
- Use secrets para todas as informações sensíveis
- Revise regularmente as permissões de acesso ao repositório

Se você identificou que credenciais como `vm_hosts` e `ssh_user` estão diretamente expostas em seu código, recomendamos:

1. Remover imediatamente essas informações do código
2. Revogar/trocar as credenciais comprometidas
3. Configurar novos secrets no GitHub
4. Atualizar os workflows para usar os secrets 