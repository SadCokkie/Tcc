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


````
