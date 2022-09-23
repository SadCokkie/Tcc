# portal-codeigniter
```

git clone https://gitlab.com/bezerrabarbosarafael/portal-codeigniter.git
git remote add origin https://gitlab.com/bezerrabarbosarafael/portal-codeigniter.git
git fetch
git checkout -b [seu_nome]
git push --set-upstream origin [seu_nome]

```

# branches
````
BRANCH MASTER - Base oficial
BRANCH HOMOLOG - Base de homologação e testes

1. Para novas rotinas:
    1.1 git checkout -b [nome_da_rotina];
    1.2 desenvolvimento;
    1.3 git push --set-upstream origin [nome_da_rotina];

2. Para bugfix:
    2.1 git checkout -b [bugfix_nome_da_rotina];
    2.2 desenvolvimento;
    2.3 git push --set-upstream origin [bugfix_nome_da_rotina];

3. Merge com homolog e base oficial    
    3.1 git checkout homolog;
    3.2 git merge [branch utilizada];
    3.3 resolver conflitos;
    3.4 testes em homolog;
    3.5 git checkout master;
    3.6 git merge homolog;
        3.6.1 não deve haver conflitos neste merge a não ser que alguma funcionalidade foi desenvolvida direto na master;

````
php install
composer install
descomentar a extensão openssl no php.ini-development

# Estrutura de requisições em JSON

````
Dados de usuário devem estar sempre na requisição.

{
    user:{
        cd_usuario: "dado"
    },
    data:{
        campo_1: "dado_1",
        campo_2: {
            "campo_a" : "dado_a",
            "campo_b" : "dado_b"
        },
        campo_3:["dado_a","dado_b","dado_c"]
    }
}

````

# Estrutura de direitos de acesso

````
Chave do direito = funcao_controller
Nome do direito = CONTROLER - Função

````
